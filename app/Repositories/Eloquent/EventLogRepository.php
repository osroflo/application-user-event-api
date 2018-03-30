<?php
namespace App\Repositories\Eloquent;

use App\Repositories\EventLogInterface;
use App\Models\Event\EventLog;
use App\Models\Event\EventLogApplicationAttribute;
use App\Models\Event\EventLogAttributeValue;
use App\Events\EventFired;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\Eloquent\EventTypeRepository;
use App\Models\User\UserFactory;

/**
 * This class is the collection of event logs also called repository
 */
class EventLogRepository extends EloquentRepository implements EventLogInterface
{
    protected $event_properties = [];

    public function getAll()
    {
        $events = EventLog::paginate(10);

        if ($events->isEmpty()) {
            throw new ModelNotFoundException;
        }

        return $events;
    }

    public function findById($id)
    {
        return EventLog::findOrFail($id);
    }

    /**
     * Insert an event log into the database.
     *
     * An Event Log needs two types of properties:
     *
     * - Application properties:
     *     Parameters required per application like: Application, Resource, Other Application.
     *     Every application requires different parameters.
     *
     * - Event properties:
     *     Parameters needed to create an event, for example: The event "contact
     *     created" will require an executor_user_id and a contact_id
     *
     * This is an example about how to create or log an event:
     * POST http://local.api.com/event/v1/Application/log/contact
     * {
     *     "network_id": 2,
     *     "ip_address": "1.1.1.1",
     *     "member_id": 4,
     *     "event_type_id":33,
     *     "user_id":1,
     *     "contact_id":1011,
     *     "properties":{
     *         "executor_user_id":84,
     *         "contact_id":1011
     *     }
     * }
     *
     * @param $data array  The date needed to create the the event log
     *
     * @return EventLog
     */
    public function create(array $data)
    {
        // get defined application attributes from data base
        // each application has different identifiers that
        // are needed in order to log an event.
        $application_attributes = $this->getApplicationIdentifiers();
        $formatted_attributes = [];

        // get application parameters passed from client and convert them in a format that is easy to insert in the db
        foreach ($application_attributes as $attribute) {
            $identifier = $attribute->identifier;

            if (array_key_exists($identifier, $data)) {
                $formatted_attribute = [
                    'event_log_application_attribute_id' => $attribute->id,
                    'value' => $data[$identifier]
                ];
                $formatted_attributes[] = $formatted_attribute;
            }
        }

        // get event parameters passed from client and convert them in a format that is easy to insert in the db
        if (isset($data['properties'])) {
            $formatted_properties = [];

            foreach ($data['properties'] as $key => $value) {
                if (array_key_exists($key, $this->event_properties)) {
                    $formatted_properties[] = [
                        'event_placeholder_id' => $this->event_properties[$key]['event_placeholder_id'],
                        'value' => $data['properties'][$key]
                    ];
                }
            }
        }

        // add application id
        $data['application_id'] = $this->getApplicationId();
        // insert the event log
        $eventLog = EventLog::create($data);
        // create the event log identifier attributes
        $eventLog->addAttributes($formatted_attributes);
        // create the placeholder properties tied to the event log
        $eventLog->addProperties($formatted_properties);

        // fire notification for this event
        event(new EventFired($eventLog, $this->getApplicationName(), $this->getApplicationId()));

        return $eventLog;
    }

    /**
     * When an event is being logged, it is needed to pass some placeholders or properties, like:
     * user who is executing the action, survey, contact_id, etc. Event types are unique per applications.
     * Also Event Types requires a set of different properties.
     *
     * The main responsibility of this method is:
     * - Get parameters needed to log an event.
     * - Get validation rules for those parameters.
     *
     * @param  integer $event_type_id   The event type id
     * @return array                    Required properties per Event Type.
     */
    public function setEventProperties($event_type_id)
    {
        // get the event type by id
        $eventType = new EventTypeRepository();
        $properties = $eventType->findById($event_type_id)->load('placeholders.placeholder');

        $rules = [];
        // get the properties and the validation rules
        foreach ($properties->placeholders as $property) {
            $rules[$property->placeholder->label] = [
                'event_placeholder_id' => $property->placeholder->id,
                'validation_rules' => $property->placeholder->validation_rules
            ];
        }

        $this->event_properties = $rules;

        return $rules;
    }

    /**
     * Get the validation rules from the Event properties
     *
     * @param  integer $key_prefix   The key prefix will allow to specify rules for object
     *                               attributes. The client will pass something like:
     *                               "properties":{
     *                                     "executor_user_id":84,
     *                                     "contact_id":1011
     *                                }
     *
     *                                The validation rule key shold be defined like: properties.contact_id
     *
     * @return array                 Rules needed by the Validator object.
     */
    public function getEventValidationRules($key_prefix = 'properties')
    {
        $validation_rules = [];
        // get the properties and the validation rules
        foreach ($this->event_properties as $key => $value) {
            $validation_rules["$key_prefix.$key"] = $value['validation_rules'];
        }

        return $validation_rules;
    }
}

<?php
namespace App\Repositories\Eloquent;

use App\Repositories\EventTypeInterface;
use App\Models\Event\EventType;
use App\Models\Event\EventTypeCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * This class is the collection of event types also called repository
 */
class EventTypeRepository extends EloquentRepository implements EventTypeInterface
{
    /**
     * Get all the event types
     *
     * @return collection  Event type models
     */
    public function getAll()
    {
        $events = EventType::all();

        if ($events->isEmpty()) {
            throw new ModelNotFoundException;
        }

        return $events;
    }

    /**
     * Find event types by event type category label
     *
     * @param  string  $category_label   The category name
     * @return collection                Collection of event type models
     */
    public function findByCategory($category_label)
    {
        $application_id = $this->getApplicationId();

        $category = EventTypeCategory::where('label', '=', $category_label)
                                       ->where('application_id', $application_id)
                                       ->firstOrFail();

        $event_types  = EventType::where('event_type_category_id', $category->id)
                                   ->where('application_id', $application_id)
                                   ->get();

        return $event_types;
    }

    /**
     * Find event types by event type category label
     *
     * @param  integer $application_id  The application unique identifier
     * @return collection               Collection of event type models
     */
    public function findByApplicationId($application_id = null)
    {
        if (empty($application_id)) {
            $application_id = $this->getApplicationId();
        }

        $event_types  = EventType::where('application_id', $application_id)->get();

        if ($event_types->isEmpty()) {
            throw new ModelNotFoundException;
        }

        return $event_types;
    }

    /**
     * Find event types by id
     *
     * @param  string  $event_type_id   The event type unique identifier
     * @return EventType                The event type model
     */
    public function findById($event_type_id = null)
    {
        $eventType = EventType::find($event_type_id);

        if (!$eventType) {
            throw new ModelNotFoundException;
        }

        return $eventType;
    }
}

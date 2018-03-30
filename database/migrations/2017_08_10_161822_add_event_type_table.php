<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec(
            "CREATE TABLE event.event_type (
                id SERIAL PRIMARY KEY,
                active boolean DEFAULT TRUE,
                label varchar(100),
                message text,
                event_type_category_id integer REFERENCES event.event_type_category(id),
                application_id integer REFERENCES system.application(id),
                sort_order integer,
                created_at timestamp(0) without time zone DEFAULT NOW(),
                updated_at timestamp(0) without time zone DEFAULT NOW()
            );

            COMMENT ON TABLE event.event_type IS 'This table stores a type of event and the message related to it. For example, label:Contact Assigned, message: {user_from} assigned the contact id {contact_id} to {user_to}';
            COMMENT ON COLUMN event.event_type.active IS 'If event type is enable or not. Event types can not be deleted for reporting purposes';
            COMMENT ON COLUMN event.event_type.label IS 'The abstract description of the event. e.g: Contact Assigned';
            COMMENT ON COLUMN event.event_type.message IS 'This is a more descriptive message. e.g: Joe assigned contact 1309 to John';
            COMMENT ON COLUMN event.event_type.event_type_category_id IS 'This is a way to categorize event types, like: create, update, delete';
                "
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection()->getPdo()->exec('DROP TABLE event.event_type');
    }
}

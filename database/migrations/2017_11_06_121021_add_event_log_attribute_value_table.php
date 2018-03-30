<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventLogAttributeValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec(
            "CREATE TABLE event.event_log_attribute_value (
                id SERIAL PRIMARY KEY,
                event_log_id integer REFERENCES event.event_log(id),
                event_log_application_attribute_id integer REFERENCES event.event_log_application_attribute(id),
                value integer
            );

            COMMENT ON TABLE event.event_log_attribute_value IS 'This table stores the attribute values for an event log. This is the detail table for the event.event_log_application_attribute.';
            COMMENT ON COLUMN event.event_log_attribute_value.id IS 'Unique id for the log record.';
            COMMENT ON COLUMN event.event_log_attribute_value.event_log_id IS 'The foreign key to reference the event_log table.';
            COMMENT ON COLUMN event.event_log_attribute_value.event_log_application_attribute_id IS 'The foreign key to reference the attribute table.';
            COMMENT ON COLUMN event.event_log_attribute_value.value IS 'The real attribute value. It should be an integer value because it is related to the id.';
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
        DB::connection()->getPdo()->exec('DROP TABLE event.event_log_attribute_value');
    }
}

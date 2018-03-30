<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventLogPropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec("
            CREATE TABLE event.event_log_property (
                id SERIAL PRIMARY KEY,
                event_log_id integer REFERENCES event.event_log(id),
                event_placeholder_id integer REFERENCES event.event_placeholder(id),
                value varchar(255)
            );

            COMMENT ON TABLE event.event_log_property IS 'This table stores any property used to compose the message to describe the event action.';
            COMMENT ON COLUMN event.event_log_property.event_log_id IS 'The id for the event_log table record';
            COMMENT ON COLUMN event.event_log_property.event_placeholder_id IS 'The id of the placeholder';
            COMMENT ON COLUMN event.event_log_property.value IS 'The actual value for the identifier, property or placeholder';
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection()->getPdo()->exec("DROP TABLE event.event_log_property");
    }
}

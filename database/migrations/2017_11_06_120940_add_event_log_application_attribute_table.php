<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventLogApplicationAttributeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec(
            "CREATE TABLE event.event_log_application_attribute (
                id SERIAL PRIMARY KEY,
                application_id integer REFERENCES system.application(id),
                attribute_id integer REFERENCES event.attribute(id)
            );

            COMMENT ON TABLE event.event_log_application_attribute IS 'This table defines attributes for event logs that are exclusively used by a specific application, like: contact_id, agency_id, etc. But not used in other application.';
            COMMENT ON COLUMN event.event_log_application_attribute.id IS 'Unique id for the log record.';
            COMMENT ON COLUMN event.event_log_application_attribute.application_id IS 'The implicit foreign key for the application where the event comes from, for example: Application, Sampleweb, Other Application.';
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
        DB::connection()->getPdo()->exec('DROP TABLE event.event_log_application_attribute');
    }
}

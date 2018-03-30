<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec(
            "CREATE TABLE event.event_log (
                id SERIAL PRIMARY KEY,
                date timestamp without time zone DEFAULT NOW(),
                ip_address character varying(40) NOT NULL,
                event_type_id integer,
                application_id integer
            );

            COMMENT ON TABLE event.event_log IS 'This table stores any event or action executed by an user or program.';
            COMMENT ON COLUMN event.event_log.id IS 'Unique id for the log record.';
            COMMENT ON COLUMN event.event_log.date IS 'Timestamp for when this event was logged.';
            COMMENT ON COLUMN event.event_log.ip_address IS 'The IP address for the user.';
            COMMENT ON COLUMN event.event_log.event_type_id IS 'The implicit foreing key to relate event type with activity log.';
            COMMENT ON COLUMN event.event_log.application_id IS 'The application where the event comes from, for example: Application, Sampleweb, Other Application.';
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
        DB::connection()->getPdo()->exec("DROP TABLE event.event_log");
    }
}

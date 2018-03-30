<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventTypePlaceholderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec(
            "CREATE TABLE event.event_type_placeholder (
                id SERIAL PRIMARY KEY,
                event_type_id integer REFERENCES event.event_type(id),
                event_placeholder_id integer REFERENCES event.event_placeholder(id)
            );

            COMMENT ON TABLE event.event_type IS 'This is a lookup table to store possible placeholders used in the event log. This is useful in case it is needed to know what placeholders are needed to compose the log';
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
        DB::connection()->getPdo()->exec("DROP TABLE event.event_type_placeholder");
    }
}

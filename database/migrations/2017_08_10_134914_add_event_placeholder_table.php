<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventPlaceholderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec("
            CREATE TABLE event.event_placeholder (
                id SERIAL PRIMARY KEY,
                label varchar(50),
                description varchar(150),
                attribute_id integer,
                validation_rules varchar(100),
                active boolean DEFAULT true
            );

            COMMENT ON TABLE event.event_placeholder IS 'This table stores any placeholder used by the event log property table';
            COMMENT ON COLUMN event.event_placeholder.label IS 'Is a placeholder to extend the event_type message description';
            COMMENT ON COLUMN event.event_placeholder.validation_rules IS 'Rules used to validate the placeholder when it is passed in the api as parameter';
            COMMENT ON COLUMN event.event_placeholder.attribute_id IS 'The type of attribute that this placeholder is, like: member_id, user_id, etc. It is useful to make queries if needed';
            COMMENT ON COLUMN event.event_placeholder.description IS 'Is a brief description about the reason why the placeholder label is used for';
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection()->getPdo()->exec("DROP TABLE event.event_placeholder");
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttributeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec(
            "CREATE TABLE event.attribute (
                id SERIAL PRIMARY KEY,
                attribute_category_id integer REFERENCES event.attribute_category(id),
                label character varying(50) NOT NULL,
                description varchar(150),
                validation_rules varchar(100)
            );

            COMMENT ON TABLE event.attribute IS 'This table defines attributes that can be re-used by multiple tables.';
            COMMENT ON COLUMN event.attribute.id IS 'Unique id for the log record.';
            COMMENT ON COLUMN event.attribute.validation_rules IS 'Rules used to validate the placeholder when it is passed in the api as parameter';
            COMMENT ON COLUMN event.attribute.attribute_category_id IS 'Foreing key to map attribute categories.';
            COMMENT ON COLUMN event.attribute.label IS 'The identifier like: network_id, contact_id, member_id, etc.';
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
        DB::connection()->getPdo()->exec('DROP TABLE event.attribute');
    }
}

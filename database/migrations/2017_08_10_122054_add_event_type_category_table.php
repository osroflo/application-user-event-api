<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventTypeCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec(
            "CREATE TABLE event.event_type_category (
                id SERIAL PRIMARY KEY,
                application_id integer REFERENCES system.application(id),
                label varchar(100),
                description text,
                sort_order integer,
                created_at timestamp(0) without time zone DEFAULT NOW(),
                updated_at timestamp(0) without time zone DEFAULT NOW()
            );

            COMMENT ON TABLE event.event_type_category IS 'This table stores tags to categorize event types';
            COMMENT ON COLUMN event.event_type_category.application_id IS 'The foreing key is related with system.application';
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
        DB::connection()->getPdo()->exec('DROP TABLE event.event_type_category');
    }
}

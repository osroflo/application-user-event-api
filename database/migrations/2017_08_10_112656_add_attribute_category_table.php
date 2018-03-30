<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttributeCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec(
            "CREATE TABLE event.attribute_category (
                id SERIAL PRIMARY KEY,
                label varchar(50) NOT NULL,
                description varchar(150)
            );

            COMMENT ON TABLE event.attribute_category IS 'This table defines attribute categories. For example, the attributes member_id, user_id can be under the user identity category.';
            COMMENT ON COLUMN event.attribute_category.id IS 'Unique id for the log record.';
            COMMENT ON COLUMN event.attribute_category.label IS 'The identifier like: network_id, contact_id, member_id, etc.';
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
        DB::connection()->getPdo()->exec('DROP TABLE event.attribute_category');
    }
}

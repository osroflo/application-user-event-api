<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotificationPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec(
            "CREATE TABLE event.notification_preferences (
                id SERIAL PRIMARY KEY,
                subscriber_id integer REFERENCES event.subscriber(id) ON DELETE CASCADE,
                by_email boolean,
                created_at timestamp(0) without time zone DEFAULT NOW(),
                updated_at timestamp(0) without time zone DEFAULT NOW()
            );

            COMMENT ON TABLE event.notification_preferences IS 'This table stores subscribers preferences to send notifications by email, system, etc.';
            COMMENT ON COLUMN event.notification_preferences.by_email IS 'Wheter or not the subscriber wants to get notification by email';
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
        DB::connection()->getPdo()->exec("DROP TABLE event.notification_preferences");
    }
}

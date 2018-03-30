<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec(
            "CREATE TABLE event.notification (
                id SERIAL PRIMARY KEY,
                subscriber_id integer REFERENCES event.subscriber(id) ON DELETE CASCADE,
                event_log_id integer REFERENCES event.event_log(id),
                was_read boolean DEFAULT false,
                delivered_by_email boolean DEFAULT false,
                email_sent boolean DEFAULT false,
                updated_at timestamp(0) without time zone DEFAULT NOW(),
                created_at timestamp(0) without time zone DEFAULT NOW()
            );

            COMMENT ON TABLE event.notification IS 'This table stores subscriber notifications. It is useful to show notifications to subscribers (user or member) when they log-in to the application and an alert shows new notifications. It also get updated when a notification was read by the subscriber.';
            COMMENT ON COLUMN event.notification.event_log_id IS 'The id of the logged event.';
            COMMENT ON COLUMN event.notification.delivered_by_email IS 'Set to true if notification was delivered by email.';
            COMMENT ON COLUMN event.notification.email_sent IS 'Set to true if email was sent. Set to false in case some error.';
            COMMENT ON COLUMN event.notification.was_read IS 'Set to true if notification was read by subscriber using the system interface (alert notification).';
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
        DB::connection()->getPdo()->exec("DROP TABLE event.notification");
    }
}

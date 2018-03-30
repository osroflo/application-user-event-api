<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec(
            "CREATE TABLE event.subscription (
                id SERIAL PRIMARY KEY,
                subscriber_id integer REFERENCES event.subscriber(id) ON DELETE CASCADE,
                event_type_id integer REFERENCES event.event_type(id),
                created_at timestamp(0) without time zone DEFAULT NOW(),
                updated_at timestamp(0) without time zone DEFAULT NOW(),
                UNIQUE (subscriber_id, event_type_id)
            );

            COMMENT ON TABLE event.subscription IS 'This table stores the events that a subscriber is subscribed.';
            COMMENT ON COLUMN event.subscription.subscriber_id IS 'The subscriber identifier.';
            COMMENT ON COLUMN event.subscription.event_type_id IS 'The type of event identifier that a subscriber is subscribed to get notifications. For example: Contact Created';
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
        DB::connection()->getPdo()->exec("DROP TABLE event.subscription");
    }
}

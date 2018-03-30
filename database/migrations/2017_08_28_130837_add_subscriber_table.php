<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubscriberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec(
            "CREATE TABLE event.subscriber (
                id SERIAL PRIMARY KEY,
                application_id integer,
                user_identity integer,
                active boolean DEFAULT true,
                created_at timestamp(0) without time zone DEFAULT NOW(),
                updated_at timestamp(0) without time zone DEFAULT NOW()
            );

            COMMENT ON TABLE event.subscriber IS 'This table stores the event subscribers. The subscriber table also works as a lookup table to solve the current challenge where users are stored in different tables depending on the application. The subscriber is composed by application_id and user_id or member_id. ';
            COMMENT ON COLUMN event.subscriber.application_id IS 'The application where the subscriber comes from: Application, Resource, Website, etc.';
            COMMENT ON COLUMN event.subscriber.user_identity IS 'The user identity  can be an user_id or a member_id. A user id denotes that the user only have ONE identity in the whole application. A member id denotes that the user have MULTIPLE identities or memberships in the same application.';
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
        DB::connection()->getPdo()->exec("DROP TABLE event.subscriber");
    }
}

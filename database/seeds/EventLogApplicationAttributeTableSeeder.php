<?php

use Illuminate\Database\Seeder;

/**
 * Lookup table to tag all placeholders per event type
 */
class EventLogApplicationAttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event.event_log_application_attribute')->insert([
            [
                'application_id' => 1,
                'attribute_id' => 4 // network_id
            ]
        ]);
    }
}

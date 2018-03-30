<?php

use Illuminate\Database\Seeder;

class EventPlaceholderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event.event_placeholder')->insert([
            [
                'label' => 'executor_member_id',
                'description' => 'The identity of the user who executes the action',
                'validation_rules' => 'required|integer',
                'attribute_id' => 2
            ],
            [
                'label' => 'receptor_member_id',
                'description' => 'The identity of the user who receives the action',
                'validation_rules' => 'required|integer',
                'attribute_id' => 2
            ],
            [
                'label' => 'member_id',
                'description' => 'The identity of the user that is involved in some action',
                'validation_rules' => 'required|integer',
                'attribute_id' => 2
            ],
            [
                'label' => 'message',
                'description' => 'A generic message that will be placed in the event type main message',
                'validation_rules' => 'required|string',
                'attribute_id' => 5
            ],
            [
                'label' => 'contact_id',
                'description' => 'The contact ID being affected by the action',
                'validation_rules' => 'required|integer',
                'attribute_id' => 3
            ],
            [
                'label' => 'filename',
                'description' => 'The filename with extension',
                'validation_rules' => 'required|string',
                'attribute_id' => 5
            ],
            [
                'label' => 'survey_label',
                'description' => 'The survey or screening label',
                'validation_rules' => 'required|string',
                'attribute_id' => 5
            ],
            [
                'label' => 'user_role',
                'description' => 'The user role label',
                'validation_rules' => 'required|string',
                'attribute_id' => 5
            ],
            [
                'label' => 'contact_id_2',
                'description' => 'A second contact id',
                'validation_rules' => 'required|integer',
                'attribute_id' => 3
            ],
            [
                'label' => 'relationship_type_1',
                'description' => 'Relationship type',
                'validation_rules' => 'required|string',
                'attribute_id' => 5
            ],
            [
                'label' => 'agency_name',
                'description' => 'Agency Name',
                'validation_rules' => 'required|string',
                'attribute_id' => 5
            ],
            [
                'label' => 'referral_status',
                'description' => 'Referral Status',
                'validation_rules' => 'required|string',
                'attribute_id' => 5
            ],
            [
                'label' => 'relationship_type_2',
                'description' => 'A Second relationship type',
                'validation_rules' => 'required|string',
                'attribute_id' => 5
            ],
            [
                'label' => 'executor_member_fullname',
                'description' => 'The full name of the user who executes the action',
                'validation_rules' => 'required|string',
                'attribute_id' => 5
            ],
            [
                'label' => 'receptor_member_fullname',
                'description' => 'The full name of the user who receives the action',
                'validation_rules' => 'required|string',
                'attribute_id' => 5
            ],
            [
                'label' => 'member_fullname',
                'description' => 'The full name of the user that is involved in some action',
                'validation_rules' => 'required|string',
                'attribute_id' => 5
            ],
        ]);
    }
}

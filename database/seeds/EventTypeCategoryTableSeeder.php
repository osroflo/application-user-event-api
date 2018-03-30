<?php

use Illuminate\Database\Seeder;

class EventTypeCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event.event_type_category')->insert([
           [
               'application_id' => 1,
               'label' => 'Contact Management',
               'description' => 'Group any event related with contacts like: create, assign, release, etc..'
           ],
           [
               'application_id' => 1,
               'label' => 'File Management',
               'description' => 'Group any event related with files like: upload, delete, etc'
           ],
           [
               'application_id' => 1,
               'label' => 'Survey Management',
               'description' => 'Group any event related with surveys actions like: created, updated, disabled, etc'
           ],
           [
               'application_id' => 1,
               'label' => 'Intake Surveys',
               'description' => 'Group any event related with survey being taken by contacts like: survey conducted, updated, printed, etc'
           ],
           [
               'application_id' => 1,
               'label' => 'Case Management',
               'description' => 'Group any event related with contact case notes like: created, updated, deleted, etc'
           ],
           [
               'application_id' => 1,
               'label' => 'User Management',
               'description' => 'Group any event related with user management like: user created, user updated, user deleted, user role added, etc'
           ],
           [
               'application_id' => 1,
               'label' => 'Relationships',
               'description' => 'Group any event related with contact relationships like: relationship added, changed, deleted, etc'
           ],
           [
               'application_id' => 1,
               'label' => 'Referrals',
               'description' => 'Group any event related with contact referrals like: referral made, referral outcome, referral follow-up, etc'
           ],

        ]);
    }
}

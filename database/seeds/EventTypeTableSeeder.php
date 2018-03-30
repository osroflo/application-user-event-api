<?php

use Illuminate\Database\Seeder;

class EventTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event.event_type')->insert([
            [
                'label' => 'Contact Created',
                'message' => 'Contact {contact_id} was created by {executor_member_fullname}',
                'event_type_category_id' => 1,
                'application_id' => 1
            ],
            [
                'label' => 'Contact Assigned',
                'message' => '{executor_member_fullname} assigned contact {contact_id} to {receptor_member_fullname}',
                'event_type_category_id' => 1,
                'application_id' => 1
            ],
            [
                'label' => 'Contact Received',
                'message' => '{executor_member_fullname} assigned the contact {contact_id} to {receptor_member_fullname}',
                'event_type_category_id' => 1,
                'application_id' => 1
            ],
            [
                'label' => 'Contact Re-Assigned',
                'message' => '{executor_member_fullname} re-assigned contact {contact_id} from {member_fullname} to {receptor_member_fullname}',
                'event_type_category_id' => 1,
                'application_id' => 1
            ],
            [
                'label' => 'Contact Release',
                'message' => '{executor_member_fullname} released contact {contact_id} to the Triage page',
                'event_type_category_id' => 1,
                'application_id' => 1
            ],
            [
                'label' => 'Contact Added from Triage Page',
                'message' => '{executor_member_fullname} assigned contact {contact_id} to {receptor_member_fullname} from the Triage page',
                'event_type_category_id' => 1,
                'application_id' => 1
            ],
            [
                'label' => 'Case Status Close',
                'message' => '{executor_member_fullname} updated the case status of contact {contact_id} to Closed',
                'event_type_category_id' => 1,
                'application_id' => 1
            ],
            [
                'label' => 'Case Status Open',
                'message' => '{executor_member_fullname} updated the case status of contact {contact_id} to Open',
                'event_type_category_id' => 1,
                'application_id' => 1
            ],
            [
                'label' => 'File Uploaded',
                'message' => '{executor_member_fullname} uploaded the file {filename} to contact {contact_id}',
                'event_type_category_id' => 2,
                'application_id' => 1
            ],
            [
                'label' => 'File Deleted',
                'message' => '{executor_member_fullname} deleted the file {filename} from contact {contact_id}',
                'event_type_category_id' => 2,
                'application_id' => 1
            ],
            [
                'label' => 'Contact Transferred',
                'message' => '{executor_member_fullname} transferred contact {contact_id} from {member_fullname} to {receptor_member_fullname}',
                'event_type_category_id' => 1,
                'application_id' => 1
            ],
            [
                'label' => 'Survey Created',
                'message' => '{executor_member_fullname} added a new survey {survey_label}',
                'event_type_category_id' => 3,
                'application_id' => 1
            ],
            [
                'label' => 'Survey Updated',
                'message' => '{executor_member_fullname} updated the survey {survey_label}',
                'event_type_category_id' => 3,
                'application_id' => 1
            ],
            [
                'label' => 'Survey Disabled',
                'message' => '{executor_member_fullname} disabled the survey {survey_label}',
                'event_type_category_id' => 3,
                'application_id' => 1
            ],
            [
                'label' => 'Intake Survey Conducted',
                'message' => '{executor_member_fullname} conducted the intake survey: {survey_label} for contact {contact_id}',
                'event_type_category_id' => 4,
                'application_id' => 1
            ],
            [
                'label' => 'Intake Survey Update',
                'message' => '{executor_member_fullname} updated the form {survey_label} for contact {contact_id}',
                'event_type_category_id' => 4,
                'application_id' => 1
            ],
            [
                'label' => 'Intake Survey Printed',
                'message' => '{executor_member_fullname} printed the intake survey: {survey_label} for contact {contact_id}',
                'event_type_category_id' => 4,
                'application_id' => 1
            ],
            [
                'label' => 'Intake Survey Deleted',
                'message' => '{executor_member_fullname} deleted the intake survey: {survey_label} for contact {contact_id}',
                'event_type_category_id' => 4,
                'application_id' => 1
            ],
            [
                'label' => 'Case Note Created ',
                'message' => '{executor_member_fullname} added a case note to contact {contact_id}',
                'event_type_category_id' => 5,
                'application_id' => 1
            ],
            [
                'label' => 'Case Note Deleted ',
                'message' => '{executor_member_fullname} deleted a case note from contact {contact_id}',
                'event_type_category_id' => 5,
                'application_id' => 1
            ],
            [
                'label' => 'Case Note Edited ',
                'message' => '{executor_member_fullname} updated a case note to contact {contact_id}',
                'event_type_category_id' => 5,
                'application_id' => 1
            ],
            [
                'label' => 'User Created',
                'message' => '{executor_member_fullname} created user {member_fullname}',
                'event_type_category_id' => 6,
                'application_id' => 1
            ],
            [
                'label' => 'User Disabled',
                'message' => '{executor_member_fullname} disabled user {member_fullname}',
                'event_type_category_id' => 6,
                'application_id' => 1
            ],
            [
                'label' => 'User Update',
                'message' => '{executor_member_fullname} updated user {member_fullname}',
                'event_type_category_id' => 6,
                'application_id' => 1
            ],
            [
                'label' => 'User Role Added',
                'message' => '{executor_member_fullname} added {user_role} role to {member_fullname}',
                'event_type_category_id' => 6,
                'application_id' => 1
            ],
            [
                'label' => 'User Role Deleted',
                'message' => '{executor_member_fullname} removed the {user_role} role from {member_fullname}',
                'event_type_category_id' => 6,
                'application_id' => 1
            ],
            [
                'label' => 'User Enabled',
                'message' => '{executor_member_fullname} enabled user {member_fullname}',
                'event_type_category_id' => 6,
                'application_id' => 1
            ],
            [
                'label' => 'Relationship Added',
                'message' => '{executor_member_fullname} assigned a new relationship between contact id {contact_id} ({relationship_type_1}) and {contact_id_2} ',
                'event_type_category_id' => 7,
                'application_id' => 1
            ],
            [
                'label' => 'Relationship Changed',
                'message' => '{executor_member_fullname} changed a relationship between contact id {contact_id} ({relationship_type_1}) and {contact_id_2} ({relationship_type_2})',
                'event_type_category_id' => 7,
                'application_id' => 1
            ],
            [
                'label' => 'Relationship Deleted',
                'message' => '{executor_member_fullname} removed a relationship between contact id {contact_id} ({relationship_type_1}) and {contact_id_2} ({relationship_type_2})',
                'event_type_category_id' => 6,
                'application_id' => 1
            ],
            [
                'label' => 'Consent Obtained',
                'message' => '{executor_member_fullname} has obtained consent for contact id {contact_id}',
                'event_type_category_id' => 1,
                'application_id' => 1
            ],
            [
                'label' => 'Consent Revoked',
                'message' => '{executor_member_fullname} has revoked consent for contact id {contact_id}',
                'event_type_category_id' => 1,
                'application_id' => 1
            ],
            [
                'label' => 'Consent Form Printed',
                'message' => '{executor_member_fullname} has printed a consent form for contact id {contact_id}',
                'event_type_category_id' => 1,
                'application_id' => 1
            ],
            [
                'label' => 'Contact Profile Updated',
                'message' => '{executor_member_fullname} updated the contact profile for contact id {contact_id}',
                'event_type_category_id' => 1,
                'application_id' => 1
            ],
            [
                'label' => 'New Contact Referral',
                'message' => '{executor_member_fullname} referred contact id {contact_id} to {agency_name}',
                'event_type_category_id' => 8,
                'application_id' => 1
            ],
            [
                'label' => 'Contact Referral Removed',
                'message' => '{executor_member_fullname} deleted the referral to {agency_name} from contact id {contact_id}',
                'event_type_category_id' => 8,
                'application_id' => 1
            ],
            [
                'label' => 'Contact Referral Status',
                'message' => '{executor_member_fullname} changed the referral status to {REFERRAL_STATUS} for the agency {agency_name} for contact id {contact_id}',
                'event_type_category_id' => 8,
                'application_id' => 1
            ],
            [
                'label' => 'Referral Outcome Updated',
                'message' => '{executor_member_fullname} updated the form {survey_label} for contact {contact_id}',
                'event_type_category_id' => 8,
                'application_id' => 1
            ],
            [
                'label' => 'Referral Follow-up Updated',
                'message' => '{executor_member_fullname} updated the form {survey_label} for contact {contact_id}',
                'event_type_category_id' => 8,
                'application_id' => 1
            ],
            [
                'label' => 'Referral Outcome Deleted',
                'message' => '{executor_member_fullname} deleted a referral outcome from {agency_name} for contact {contact_id}',
                'event_type_category_id' => 8,
                'application_id' => 1
            ]
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

/**
 * Seeds attributes table
 */
class AttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event.attribute')->insert([
            [
                'attribute_category_id' => 1,
                'label' => 'user_id',
                'description' => 'The id for the user.',
                'validation_rules' => 'required|integer'
            ],
            [
                'attribute_category_id' => 1,
                'label' => 'member_id',
                'description' => 'The id for the member.',
                'validation_rules' => 'required|integer'
            ],
            [
                'attribute_category_id' => 2,
                'label' => 'contact_id',
                'description' => 'The id for the contact.',
                'validation_rules' => 'required|integer'
            ],
            [
                'attribute_category_id' => 4,
                'label' => 'network_id',
                'description' => 'The id for the network',
                'validation_rules' => 'required|integer'
            ],
            [
                'attribute_category_id' => 3,
                'label' => 'name',
                'description' => 'A word by which a member, user, survey or thing is known.',
                'validation_rules' => 'required|string'
            ]
        ]);
    }
}

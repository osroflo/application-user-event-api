<?php

use Illuminate\Database\Seeder;

/**
 * Seeds attribute categories table
 */
class AttributeCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event.attribute_category')->insert([
            [
                'label' => 'User Identity',
                'description' => 'This group has attributes that represents user identities. The id will be used to get user profiles.'
            ],
            [
                'label' => 'Contact Identity',
                'description' => 'This group has attributes that represents contact identities. The id may be used to join other tables.'
            ],
            [
                'label' => 'Miscellaneous',
                'description' => 'This group has attributes, that are used as is, like: strings, names, labels, etc.'
            ],
            [
                'label' => 'Network Identity',
                'description' => 'This group has attributes that represents network identities. The id may be used to join other tables.'
            ]
        ]);
    }
}

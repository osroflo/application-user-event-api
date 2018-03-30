<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('AttributeCategoryTableSeeder');
        $this->call('AttributeTableSeeder');
        $this->call('EventTypeCategoryTableSeeder');
        $this->call('EventPlaceholderTableSeeder');
        $this->call('EventTypeTableSeeder');
        $this->call('EventTypePlaceholderTableSeeder');
        $this->call('EventLogApplicationAttributeTableSeeder');
    }
}

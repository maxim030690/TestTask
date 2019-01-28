<?php

use Illuminate\Database\Seeder;
use App\Types;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = new Types();
        $type->name = 'first_type';
        $type->save();

        $type = new Types();
        $type->name = 'second_type';
        $type->save();
    }
}

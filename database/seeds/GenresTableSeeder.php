<?php

use Illuminate\Database\Seeder;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genres')->insert([
            ['name' => 'POPs'],
            ['name' => 'Classic'],
            ['name' => 'BrassBand'],
            ['name' => 'Jazz'],
        ]);
    }
}

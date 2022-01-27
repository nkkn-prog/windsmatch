<?php

use Illuminate\Database\Seeder;

class InstrumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::table('instruments')->insert([
                ['name' => 'トランペット'],
                ['name' => 'トロンボーン'],
                ['name' => 'バストロンボーン'],
                ['name' => 'ホルン'],
                ['name' => 'ユーフォニウム'],
                ['name' => 'チューバ'],
                ['name' => 'クラリネット'],
                ['name' => 'バスクラリネット'],
                ['name' => 'フルート'],
                ['name' => 'サックス'],
                ['name' => 'アルトサックス'],
                ['name' => 'テナーサックス'],
                ['name' => 'バリトンサックス'],
                ['name' => 'パーカッション'],
            ]);
            
            
            
        
    }
}

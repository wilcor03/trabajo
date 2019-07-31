<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Str;

class SectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {    	
        DB::table('sectors')->insert(
        	Self::data()	
        );
    }

    private function data(){
    	$items = [
    		'Agricultura',
    		'Ganadería/Avicultura',
    		'Minería',
    		'Hidrocarburos',
    		'Alimentos',
    		'Tabaco',
    		'Cuero y calzado'
    	];

    	$data = [];
    	foreach($items as $item){
    		array_push($data, ['name' => $item, 'slug' => Str::slug($item)]);
    	}
    	return $data;
    }
}

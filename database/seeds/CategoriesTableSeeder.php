<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Str;


class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
        	['name' => 'Administración', 'slug' => Str::slug('Administración')],
        	['name' => 'Auditoría', 'slug' => Str::slug('Auditoría')],
        	['name' => 'Bodega', 'slug' => Str::slug('Bodega')],    	
        	['name' => 'Compras', 'slug' => Str::slug('Compras')],
        	['name' => 'Contabilidad', 'slug' => Str::slug('Contabilidad')],
        	['name' => 'Costos', 'slug' => Str::slug('Costos')]
        ]);
    }
}

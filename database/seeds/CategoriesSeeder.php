<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name'  =>  'Quêtes Exotiques',
            'slug'  =>  'quetes-exotiques',
            'description'   =>  'Tous les guides pour les quêtes de contenus exotiques',
            'image' =>  'quetes-exotiques-2020-09-25-5f6d3f76acf6f.png',
        ]);
        DB::table('categories')->insert([
            'name'  =>  'Raids',
            'slug'  =>  'raids',
            'description'   =>  'Tous les guides pour les raids',
            'image' =>  'raids-2020-09-25-5f6d3f8c08c1b.jpeg',
        ]);
        DB::table('categories')->insert([
            'name'  =>  'Débuter',
            'slug'  =>  'debuter',
            'description'   =>  'Tous les guides d\'aide aux débutants',
            'image' =>  'debuter-2020-09-25-5f6d3fa8aa0db.jpg',
        ]);
        DB::table('categories')->insert([
            'name'  =>  'Autres',
            'slug'  =>  'autres',
            'description'   =>  'Tous les guides concernant des sujets divers sur Destiny 2',
            'image' =>  'autres-2020-09-25-5f6d400b0443a.jpg',
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name'  =>  'Admin',
            'slug'  =>  'admin',
            'description'   =>  'Administrateur',
        ]);
        DB::table('roles')->insert([
            'name'  =>  'Writer',
            'slug'  =>  'writer',
            'description'   =>  'Editeur',
        ]);
        DB::table('roles')->insert([
            'name'  =>  'Guardian',
            'slug'  =>  'guardian',
            'description'   =>  'Membre du Clan',
        ]);
    }
}

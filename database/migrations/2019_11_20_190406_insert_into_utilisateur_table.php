<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class InsertIntoUtilisateurTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('utilisateur')->insert([
            'nom' => 'admin',
            'prenom' => 'admin',
            'email'=>'space_admin@esi.dz',
            'motpass' => sha1('adminadmin'),
            'type_utilisateur'=>'a'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

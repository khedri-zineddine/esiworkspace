<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToEtudiantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('etudiant', function (Blueprint $table) {
            $table->unsignedBigInteger('utilisateur_idutilisateur');
            $table->foreign('utilisateur_idutilisateur')->references('idutilisateur')->on('utilisateur');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('etudiant', function (Blueprint $table) {
            $table->dropForeign('etudiant_utilisateur_idutilisateur_foreign');
        });
    }
}

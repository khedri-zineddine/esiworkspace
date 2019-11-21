<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToEnseignentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enseignent', function (Blueprint $table) {
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
        Schema::table('enseignent', function (Blueprint $table) {
            $table->dropForeign('enseignent_utilisateur_idutilisateur_foreign');
        });
    }
}

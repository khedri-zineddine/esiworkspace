<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToFilemsgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('filemsg', function (Blueprint $table) {
            $table->unsignedBigInteger('message_idmessage');
            $table->foreign('message_idmessage')->references('idmessage')->on('message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('filemsg', function (Blueprint $table) {
            $table->dropForeign('filemsg_message_idmessage_foreign');
        });
    }
}

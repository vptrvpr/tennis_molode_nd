<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'users', function( Blueprint $table ) {
            $table->string( 'hours' )->default( 2 );
            $table->string( 'bonus_hours' )->default( 0 );
        } );
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'users', function( Blueprint $table ) {
            $table->dropColumn( 'hours' );
            $table->dropColumn( 'bonus_hours' );
        } );
    }
}

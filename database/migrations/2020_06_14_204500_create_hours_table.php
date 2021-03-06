<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'hours', function( Blueprint $table ) {
            $table->id();
            $table->bigInteger( 'user_id' );
            $table->bigInteger( 'court_id' );
            $table->boolean( 'is_reservation' )->default( FALSE );
            $table->boolean( 'is_select' )->default( FALSE );
            $table->boolean( 'show_details' )->default( FALSE );
            $table->integer( 'hour' );
            $table->date( 'date' );
            $table->timestamps();
        } );
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'hours' );
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertDefaultCourtes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::table( 'courts' )->insert( [
                                                                       [ 'name' => 'Корт №1' ],
                                                                       [ 'name' => 'Корт №2' ],
                                                                   ] );
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::table( 'courts' )->where( 'name', 'Корт №1' )
                                      ->orWhere( 'name', 'Корт №2' )
                                      ->delete();
    }
}

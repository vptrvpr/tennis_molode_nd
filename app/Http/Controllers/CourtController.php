<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Hour;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CourtController extends Controller
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function get( Request $request )
    {
        $date   = $request->get( 'date' );
        $courts = Court::with( [ 'hours' => function( $query ) use ( $date ) {
            $query->where( 'date', $date )->with( 'user' );
        } ] )->get()->toArray();

        foreach( $courts as $key => $court ) {
            $newHours = [];
            $hours    = collect( $court[ 'hours' ] )->keyBy( 'hour' );
            for( $h = Hour::HOUR_RANGE[ 0 ]; $h < Hour::HOUR_RANGE[ 1 ]; $h++ ) {
                if( !isset( $hours[ $h ] ) ) {
                    $newHours[ $h ] = [
                        "user_id"        => NULL,
                        "court_id"       => $court[ 'id' ],
                        "is_reservation" => FALSE,
                        "is_select"      => FALSE,
                        "show_details"   => FALSE,
                        "hour"           => $h,
                        "date"           => $date,
                        "user"           => [],
                    ];
                } else {
                    $newHours[ $h ] = $hours[ $h ];
                }
            }
            $courts[ $key ][ 'hours' ] = collect( $newHours )->values()->toArray();
        }

        return $courts;
    }


    public function reservation( Request $request )
    {
        $courts = $request->get( 'courts' );
        $date   = $request->get( 'date' );
        $userId = \Auth::user()->id;

        foreach( $courts as $court ) {
            foreach( $court[ 'hours' ] as $hour ) {
                if( $hour[ 'user_id' ] == $userId ) {
                    $newHour                 = new Hour();
                    $newHour->user_id        = $userId;
                    $newHour->is_reservation = TRUE;
                    $newHour->date           = $date;
                    $newHour->court_id       = $court[ 'id' ];
                    $newHour->hour           = $hour[ 'hour' ];
                    $newHour->save();
                }
            }
        }
    }
}

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
        $date    = $request->get( 'date' );
        $courts  = Court::with( [ 'hours' => function( $query ) use ( $date ) {
            $query->where( 'date', $date )->with( 'user' );
        } ] )->get()->toArray();
        $dayNow  = Carbon::create( $date )->dayOfWeek;
        $hoursBy = $dayNow == 6 || $dayNow == 7 ? 'weekend' : 'weekday';

        foreach( $courts as $key => $court ) {
            $newHours = [];
            $hours    = collect( $court[ 'hours' ] )->keyBy( 'hour' );
            for( $h = Hour::HOUR_RANGE[ $hoursBy ][ 0 ]; $h < Hour::HOUR_RANGE[ $hoursBy ][ 1 ]; $h++ ) {
                if( !isset( $hours[ $h ] ) ) {
                    $newHours[ $h ] = [
                        "court_id"       => $court[ 'id' ],
                        "is_reservation" => FALSE,
                        "user_id"        => NULL,
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

        $headers = [];
        for( $h = Hour::HOUR_RANGE[ $hoursBy ][ 0 ]; $h < Hour::HOUR_RANGE[ $hoursBy ][ 1 ]; $h++ ) {
            $hPlus1 = $h + 1;
            array_push( $headers, $h < 10 ? "0$h-$hPlus1" : "$h-$hPlus1" );
        }

        return [
            'courts'  => $courts,
            'headers' => $headers,
            'test'    => $hoursBy,
        ];
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function reservation( Request $request )
    {
        $code = 1515;


        $courts = $request->get( 'courts' );
        $date   = $request->get( 'date' );
        $userId = $request->get( 'user_id' );

        $this->validate( $request, [
            'courts'  => 'required',
            'date'    => 'required',
            'user_id' => 'required',
            'fio'     => 'required',
            'code'    => 'required',
        ] );

        if( $code != $request->get( 'code' ) ) {
            return response( 'Error code', 422 );
        }

        foreach( $courts as $court ) {
            foreach( $court[ 'hours' ] as $hour ) {
                if( $hour[ 'user_id' ] == $userId ) {
                    $newHour                 = new Hour();
                    $newHour->is_reservation = TRUE;
                    $newHour->user_id        = $userId;
                    $newHour->fio            = $request->get( 'fio' );
                    $newHour->date           = $date;
                    $newHour->court_id       = $court[ 'id' ];
                    $newHour->hour           = $hour[ 'hour' ];
                    $newHour->save();
                }
            }
        }

        return response( 'Success', 200 );
    }
}

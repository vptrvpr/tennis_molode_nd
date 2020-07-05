<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Hour;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use http\Client\Curl\User;
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
        $date  = $request->get( 'date' );
        $weeks = Court::WEEKS;

        $allCourts = Court::all()->toArray();
        $res       = [];

        $courts = Court::with( [ 'hours' => function( $query ) use ( $date ) {
            $query->whereBetween( 'date', $date )->with( 'user' );
        } ] )->get()->keyBy( 'id' )->toArray();


        $carbonPeriod = CarbonPeriod::create( $date[ 0 ], $date[ 1 ] )->toArray();
        foreach( $weeks as $key => $week ) {
            $headers[]                 = [
                'name'   => $week[ 'name' ],
                'courts' => $allCourts,
            ];
            $weeks[ $key ][ 'courts' ] = $allCourts;
            $weeks[ $key ][ 'date' ]   = $carbonPeriod[ $key ];
        }

        foreach( $weeks as $key => $week ) {
            foreach( $week[ 'courts' ] as $keyCourt => $court ) {
                $weeks[ $key ][ 'courts' ][ $keyCourt ][ 'hours' ] = [];

                $date      = $week[ 'date' ];
                $dayOfWeek = $date->dayOfWeek;
                $hoursBy   = $dayOfWeek == 6 || $dayOfWeek == 0 ? 'weekend' : 'weekday';
                $hours     = collect( $courts[ $court[ 'id' ] ][ 'hours' ] )->keyBy( 'hour' );

                for( $h = Hour::HOUR_RANGE[ $hoursBy ][ 0 ]; $h < Hour::HOUR_RANGE[ $hoursBy ][ 1 ]; $h++ ) {
                    $dateForCheck  = $date->hour( $h - 1 );
                    $isReservation = Carbon::now()->gt( $dateForCheck );
                    $hourEmpty     = [
                        "court_id"       => $court[ 'id' ],
                        "is_reservation" => $isReservation,
                        "user_id"        => NULL,
                        "is_select"      => FALSE,
                        "show_details"   => FALSE,
                        "hour"           => $h,
                        "date"           => $date->format( 'Y-m-d' ),
                        "user"           => [],
                    ];


                    if( !isset( $hours[ $h ] ) ) {
                        $newHours[ $h ] = $hourEmpty;
                    } else {

                        if( $date->format( 'Y-m-d' ) == $hours[ $h ][ 'date' ] ) {
                            $newHours[ $h ] = $hours[ $h ];
                        } else {
                            $newHours[ $h ] = $hourEmpty;
                        }

                    }
                    if( Carbon::now()->gt( $dateForCheck ) ) {
                        $newHours[ $h ][ 'user_id' ] = NULL;
                    }
                    $res[ $h ][] = $newHours[ $h ];
                }

                $weeks[ $key ][ 'courts' ][ $keyCourt ][ 'hours' ] = collect( $newHours )->values()->toArray();
            }
        }

        foreach( $res as $key => $re ) {
            if( count( $re ) != 14 ) {
                $res[ $key ] = array_merge( $res[ $key ], [ [], [], [], [] ] );
            }
        }

        return [
            'weeks'   => $weeks,
            'headers' => $headers,
            'hours'   => $res,
        ];
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function reservation( Request $request )
    {
        $hoursData = $request->get( 'hours' );

        $this->validate( $request, [
            'hours' => 'required',
        ] );

        $byDate = [];

        foreach( $hoursData as $hours ) {
            foreach( $hours as $hour ) {
                if( !empty( $hour ) ) {
                    $byDate[ $hour[ 'date' ] ][] = $hour;
                }
            }
        }

        foreach( $byDate as $hoursByDate ) {
            $hoursByDate = collect( $hoursByDate )->where( 'user_id', \Auth::id() )->count();
            if( $hoursByDate > 2 ) {
                return response()->json( [ 'text' => 'Нельзя забронировать больше 2-х часов в день!' ], 422 );
            }
        }

        foreach( $hoursData as $hours ) {
            foreach( $hours as $hour ) {
                if( !empty( $hour ) ) {
                    if( $hour[ 'user_id' ] == \Auth::id() ) {
                        $newHour                 = new Hour();
                        $newHour->is_reservation = TRUE;
                        $newHour->user_id        = \Auth::id();
                        $newHour->date           = $hour[ 'date' ];
                        $newHour->court_id       = $hour[ 'court_id' ];
                        $newHour->hour           = $hour[ 'hour' ];
                        $newHour->save();
                    }
                }
            }
        }

        return response()->json( [ 'text' => 'Вы успешно забронировали корт. Хорошей игры!' ] );
    }


    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelReservation( $id )
    {
        Hour::where( 'id', $id )->delete();
        return response()->json( [ 'text' => 'Бронь отменена' ] );
    }


    public function setActiveUser( $userId )
    {
        $user            = \App\User::where( 'id', $userId )->first();
        $user->is_active = !$user->is_active;
        $user->save();
        dd( $user );
    }
}

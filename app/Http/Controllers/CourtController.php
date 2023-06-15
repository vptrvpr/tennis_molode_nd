<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Hour;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Role;

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

        // updateHours
        $startOfLastWeek = Carbon::now( 'Europe/Moscow' )->startOfWeek()->format( 'Y-m-d' );
        $carbonForNow    = Carbon::now( 'Europe/Moscow' )->format( 'Y-m-d' );
        if( $startOfLastWeek === $carbonForNow ) {
            $updateJson = json_decode( file_get_contents( public_path( '/storage/update_hours.json' ) ), TRUE );
            if( !isset( $updateJson[ $carbonForNow ] ) ) {
                User::where( 'id', '>', 0 )->update( [ 'hours' => 2 ] );
                $updateJson[ $carbonForNow ] = TRUE;
                $updateJson                  = json_encode( $updateJson );
                file_put_contents( public_path( '/storage/update_hours.json' ), $updateJson );
            }
        }


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
                $hours     = collect( $courts[ $court[ 'id' ] ][ 'hours' ] )->groupBy( 'hour' );

                for( $h = Hour::HOUR_RANGE[ $hoursBy ][ 0 ]; $h < Hour::HOUR_RANGE[ $hoursBy ][ 1 ]; $h++ ) {
                    $dateForCheck  = $date->hour( $h - 1 );
                    $isReservation = Carbon::now( 'Europe/Moscow' )->gt( $dateForCheck );
                    $hourEmpty     = [
                        "court_id"        => $court[ 'id' ],
                        "is_reservation"  => $isReservation,
                        "user_id"         => NULL,
                        "time_has_passed" => FALSE,
                        "is_select"       => FALSE,
                        "show_details"    => FALSE,
                        "minutes_left"    => FALSE,
                        "hour"            => $h,
                        "date"            => $date->format( 'Y-m-d' ),
                        "user"            => [],
                    ];


                    if( !isset( $hours[ $h ] ) ) {
                        $newHours[ $h ] = $hourEmpty;
                    } else {
                        $searched = FALSE;
                        foreach( $hours[ $h ] as $hourBy ) {
                            if( $date->format( 'Y-m-d' ) === $hourBy[ 'date' ] ) {
                                $newHours[ $h ] = $hourBy;
                                $searched       = TRUE;
                            }
                        }
                        if( !$searched ) {
                            $newHours[ $h ] = $hourEmpty;
                        }
                    }

                    if( Carbon::now( 'Europe/Moscow' )->gt( $dateForCheck ) ) {
                        $newHours[ $h ][ 'time_has_passed' ] = TRUE;
                    }

                    if( Carbon::now( 'Europe/Moscow' )->addMinutes( 150 )->gt( $date ) ) {
                        $newHours[ $h ][ 'minutes_left' ] = TRUE;
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

        foreach( $byDate as $date => $hoursByDate ) {
            $hoursByDateForCheck = collect( $hoursByDate )->filter( function( $item ) {
                return $item[ 'user_id' ] === \Auth::user()->id || $item[ 'is_select' ] === TRUE;
            } )->count();

            $isSelectHours    = collect( $hoursByDate )->where( 'is_select', TRUE )->first();
            $isSelectHoursAll = collect( $hoursByDate )->where( 'is_select', TRUE );

            if( $isSelectHours ) {
                $carbonDateCourtString = $date . ' ' . ( (int)$isSelectHours[ 'hour' ] ) . ':00:00';
                $carbonHowMuchMinutes  = Carbon::now( 'Europe/Moscow' )->diffInMinutes( $carbonDateCourtString );
            } else {
                $carbonHowMuchMinutes = 20;
            }


            if( $carbonHowMuchMinutes > 15 && $hoursByDateForCheck > 2 && !\Auth::user()->checkRole( 1 ) ) {
                return response()->json( [ 'text' => 'Нельзя забронировать больше 2-х часов в день!' ], 422 );
            }


            $hoursByAllCourts = collect( $hoursByDate );


            $hoursByCourtSelect = collect( $hoursByAllCourts )->filter( function( $item ) {
                return $item[ 'is_select' ] || ( $item[ 'is_reservation' ] && $item[ 'user_id' ] === \Auth::user()->id );
            } );

            $hoursByCourtSelectForBan = $hoursByCourtSelect->filter( function( $item ) {
                $carbonDate = Carbon::create( $item[ 'date' ] );
                return $item[ 'hour' ] >= 16 && $item[ 'hour' ] <= 21 && !$carbonDate->isWeekend();
            } );


            if( $carbonHowMuchMinutes > 15 && $hoursByCourtSelectForBan->count() > 1 && !\Auth::user()->checkRole( 1 ) ) {
                return response()->json( [ 'text' => 'Нельзя забронировать больше 1 часа в будний день с 17 до 22' ], 422 );
            }


            // hours
            if( $carbonHowMuchMinutes > 15 && !\Auth::user()->checkRole( 1 ) ) {
                $user     = \Auth::user();
                $allHours = $user->hours + $user->bonus_hours;
                if( $allHours < $isSelectHoursAll->count() ) {
                    return response()->json( [ 'text' => 'На вашем балансе недостаточно часов' ], 422 );
                } else {
                    $minusHours  = $isSelectHoursAll->count();
                    $user->hours = $user->hours - $minusHours;
                    if( $user->hours < 0 ) {
                        $user->bonus_hours = $user->bonus_hours + $user->hours;
                        $user->hours       = 0;
                    }
                    $user->save();
                }
            }

        }

        foreach( $hoursData as $hours ) {
            foreach( $hours as $hour ) {
                if( !empty( $hour ) ) {
                    if( $hour[ 'user_id' ] == \Auth::id() && $hour && $hour[ 'is_select' ] ) {
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
    public
    function cancelReservation( $id )
    {
        $user        = \Auth::user();
        $user->hours = $user->hours + 1;
        $user->save();
        Hour::where( 'id', $id )->delete();

        return response()->json( [ 'text' => 'Бронь отменена' ] );
    }


    public
    function setActiveUser( $userId )
    {
        $user            = \App\User::where( 'id', $userId )->first();
        $user->is_active = !$user->is_active;
        $user->save();

        $text = $user->is_active ? 'активный' : 'неактивный';
        return response()->json( [ 'text' => "Пользователь изменен на {$text}" ] );
    }
}

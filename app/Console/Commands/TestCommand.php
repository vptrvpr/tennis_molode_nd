<?php

namespace App\Console\Commands;

use App\Mail\NewUserMail;
use App\Models\Court;
use App\Models\Hour;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use http\Client\Curl\User;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = \App\User::first();
        \Mail::queue( new NewUserMail( $user ) );
//        $date  = [ '2020-06-29', '2020-07-05' ];
//        $weeks = Court::WEEKS;
//        $res   = [];
//
//        $allCourts = Court::all()->toArray();
//
//        $courts = Court::with( [ 'hours' => function( $query ) use ( $date ) {
//            $query->whereBetween( 'date', $date )->with( 'user' );
//        } ] )->get()->keyBy( 'id' )->toArray();
//
//
//        $carbonPeriod = CarbonPeriod::create( $date[ 0 ], $date[ 1 ] )->toArray();
//        foreach( $weeks as $key => $week ) {
//            $weeks[ $key ][ 'courts' ] = $allCourts;
//            $weeks[ $key ][ 'date' ]   = $carbonPeriod[ $key ];
//        }
//
//        foreach( $weeks as $key => $week ) {
//            foreach( $week[ 'courts' ] as $keyCourt => $court ) {
//                $weeks[ $key ][ 'courts' ][ $keyCourt ][ 'hours' ] = [];
//
//                $date      = $week[ 'date' ];
//                $dayOfWeek = $date->dayOfWeek;
//                $hoursBy   = $dayOfWeek == 6 || $dayOfWeek == 0 ? 'weekend' : 'weekday';
//                $hours     = collect( $courts[ $court[ 'id' ] ][ 'hours' ] )->keyBy( 'hour' );
//                for( $h = Hour::HOUR_RANGE[ $hoursBy ][ 0 ]; $h < Hour::HOUR_RANGE[ $hoursBy ][ 1 ]; $h++ ) {
//                    $hourEmpty = [
//                        "court_id"       => $court[ 'id' ],
//                        "is_reservation" => FALSE,
//                        "user_id"        => NULL,
//                        "is_select"      => FALSE,
//                        "show_details"   => FALSE,
//                        "hour"           => $h,
//                        "date"           => $date->format( 'Y-m-d' ),
//                        "user"           => [],
//                    ];
//
//
//                    if( !isset( $hours[ $h ] ) ) {
//                        $newHours[ $h ] = $hourEmpty;
//                    } else {
//                        if( $date->format( 'Y-m-d' ) == $hours[ $h ][ 'date' ] ) {
//                            $newHours[ $h ] = $hours[ $h ];
//                        } else {
//                            $newHours[ $h ] = $hourEmpty;
//                        }
//                    }
//                }
//
//                $res[ $h ][] = $newHours[ $h ];
//                $weeks[ $key ][ 'courts' ][ $keyCourt ][ 'hours' ] = collect( $newHours )->values()->toArray();
//            }
//        }
//        dd( $res );
//
//        return [
//            'weeks'   => $weeks,
//            'headers' => $headers,
//        ];
    }
}

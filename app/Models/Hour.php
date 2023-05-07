<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Hour
 *
 * @property int                             $id
 * @property int                             $user_id
 * @property int                             $court_id
 * @property bool                            $is_reservation
 * @property int                             $hour
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereCourtId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereHour( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereIsReservation( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereUserId( $value )
 * @mixin \Eloquent
 * @property bool                            $is_select
 * @property string                          $date
 * @property-read \App\User                  $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereDate( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereIsSelect( $value )
 * @property string                          $fio
 * @property bool                            $show_details
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereFio( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereShowDetails( $value )
 */
class Hour extends Model
{
    const HOUR_RANGE = [
        'weekday' => [ 9, 23 ],
        'weekend' => [ 9, 23 ],
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo( User::class, 'user_id', 'id' );
    }
}

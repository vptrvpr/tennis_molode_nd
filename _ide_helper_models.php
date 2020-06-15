<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $photo_url
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\OAuthProvider[] $oauthProviders
 * @property-read int|null $oauth_providers_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent implements \Tymon\JWTAuth\Contracts\JWTSubject {}
}

namespace App\Models{
/**
 * App\Models\Court
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Hour[] $hours
 * @property-read int|null $hours_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Court newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Court newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Court query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Court whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Court whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Court whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Court whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Court extends \Eloquent {}
}

namespace App\Models{
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
 * @property bool $is_select
 * @property string $date
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereIsSelect($value)
 * @property bool $show_details
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hour whereShowDetails($value)
 */
	class Hour extends \Eloquent {}
}

namespace App{
/**
 * App\OAuthProvider
 *
 * @property int $id
 * @property int $user_id
 * @property string $provider
 * @property string $provider_user_id
 * @property string|null $access_token
 * @property string|null $refresh_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OAuthProvider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OAuthProvider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OAuthProvider query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OAuthProvider whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OAuthProvider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OAuthProvider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OAuthProvider whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OAuthProvider whereProviderUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OAuthProvider whereRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OAuthProvider whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OAuthProvider whereUserId($value)
 * @mixin \Eloquent
 */
	class OAuthProvider extends \Eloquent {}
}


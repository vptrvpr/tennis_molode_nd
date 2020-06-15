<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
class OAuthProvider extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'oauth_providers';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'access_token', 'refresh_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
class Court extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hours()
    {
        return $this->hasMany( Hour::class, 'court_id', 'id' );
    }
}

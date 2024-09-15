<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $district_id
 * @property string|null $name
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\District $district
 *
 * @method static \Database\Factories\PostalCodeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PostalCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostalCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostalCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostalCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostalCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostalCode whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostalCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostalCode whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostalCode whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class PostalCode extends Model
{
    use HasFactory;

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
}

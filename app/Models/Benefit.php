<?php

namespace App\Models;

use App\Http\Resources\BenefitCollection;
use App\Http\Resources\BenefitResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

/**
 * App\Models\Benefit
 *
 * @property int $id
 * @property string $title
 * @property string|null $title_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $main_svega_id
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit query()
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit whereMainSvegaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit whereTitleDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Benefit extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $guarded = [];

    protected $hidden = ['main_id'];

    public $resource_full = BenefitResource::class;
    public $resourceCollection = BenefitCollection::class;

    public function main() {
        return $this->belongsTo(Main::class);
    }
}

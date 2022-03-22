<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\ActivityCollection;
use App\Http\Resources\ActivityFullResource;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\ActivityFullCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Activity
 *
 * @property int $id
 * @property string $title
 * @property string|null $subtitle
 * @property string|null $section_titles
 * @property string|null $section_descriptions
 * @property int $main_svega_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deteled_at
 * @property string|null $image
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity query()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereDeteledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereMainSvegaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereSectionDescriptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereSectionTitles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Activity extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $guarded = [];

    protected $hidden = ['main_id'];

    protected $with = ['tags'];

    public $resource = ActivityResource::class;
    public $resource_full = ActivityFullResource::class;
    public $resourceCollection = ActivityCollection::class;

    const PLAINTEXT = "plain";
    const LISTTEXT = "list";

    public function main() {
        return $this->belongsTo(Main::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function getSectionDescription1Attribute($value) {
        if ($value === 'null') {
            return null;
        }
        return $value;
    }

    public function getSectionDescription2Attribute($value) {
        if ($value === 'null') {
            return null;
        }
        return $value;
    }

    public function getSectionDescription3Attribute($value) {
        if ($value === 'null') {
            return null;
        }
        return $value;
    }

    public function getSectionTitle1Attribute($value) {
        if ($value === 'null') {
            return null;
        }
        return $value;
    }

    public function getSectionTitle2Attribute($value) {
        if ($value === 'null') {
            return null;
        }
        return $value;
    }

    public function getSectionTitle3Attribute($value) {
        if ($value === 'null') {
            return null;
        }
        return $value;
    }

}

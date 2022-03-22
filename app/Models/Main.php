<?php

namespace App\Models;

use App\Models\Contact;
use Laravel\Scout\Searchable;
use App\Http\Resources\MainResource;
use App\Http\Resources\MainCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Main
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Main newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Main newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Main query()
 * @mixin \Eloquent
 */
class Main extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $guarded = [];

    public $resource_full = MainResource::class;
    public $resourceCollection = MainCollection::class;

    public function activities() {
        return $this->hasMany(Activity::class);
    }

    public function sections() {
        return $this->hasMany(Section::class);
    }

    public function offers() {
        return $this->hasMany(Offer::class);
    }

    public function benefits() {
        return $this->hasMany(Benefit::class);
    }

    public function blogs() {
        return $this->hasMany(Blog::class);
    }

    public function contacts() {
        return $this->hasMany(Contact::class);
    }
}

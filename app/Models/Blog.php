<?php

namespace App\Models;

use App\Filters\QueryFilter;
use App\Http\Resources\BlogResource;
use App\Http\Resources\BlogCollection;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

/**
 * App\Models\Blog
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog query()
 * @mixin \Eloquent
 */
class Blog extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $guarded = [];

    protected $hidden = ['main_id', 'pivot'];

    public $resource_full = BlogResource::class;
    public $resourceCollection = BlogCollection::class;

    protected $with = ['categories'];

    public function scopeFilter(Builder $builder, QueryFilter $filters) {
        return $filters->apply($builder);
    }

    public function main() {
        return $this->belongsTo(Main::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function setDateAttribute($value) {
        $this->attributes['date'] = new Carbon($value);
    }

    public function getDateAttribute($value) {
        return (new Carbon($value))->format('Y-m-d');
    }
}

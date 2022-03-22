<?php

namespace App\Models;

use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS = ['new', 'processing', 'processed'];

    protected $guarded = [];

    protected $hidden = ['main_id'];

    public $resource_full = ContactResource::class;
    public $resourceCollection = ContactCollection::class;

    public function main() {
        return $this->belongsTo(Main::class);
    }


}

<?php

namespace App\Http\Controllers\Activity;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class ActivityCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Activity $activity)
    {
        $categories = $activity->main()->with('blogs.categories')->get()
            ->pluck('blogs')->collapse()
            ->pluck('categories')->collapse()
            ->sortBy('id')->unique('id')->values();

        return $this->showAll($categories, Response::HTTP_OK);
    }
}

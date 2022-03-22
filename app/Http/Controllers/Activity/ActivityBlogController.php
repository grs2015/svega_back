<?php

namespace App\Http\Controllers\Activity;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class ActivityBlogController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Activity $activity)
    {
        $blogs = $activity->main()->with('blogs')->get()
            ->pluck('blogs')->collapse();

        return $this->showAll($blogs, Response::HTTP_OK);
    }
}

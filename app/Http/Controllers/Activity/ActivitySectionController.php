<?php

namespace App\Http\Controllers\Activity;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class ActivitySectionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Activity $activity)
    {
        $sections = $activity->main()->with('sections')->get()
            ->pluck('sections')->collapse();

        return $this->showAll($sections, Response::HTTP_OK);
    }
}

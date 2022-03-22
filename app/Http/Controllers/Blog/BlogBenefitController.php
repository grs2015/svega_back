<?php

namespace App\Http\Controllers\Blog;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class BlogBenefitController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Blog $blog)
    {
        $benefits = $blog->main()->with('benefits')->get()
            ->pluck('benefits')->collapse();

        return $this->showAll($benefits, Response::HTTP_OK);
    }
}

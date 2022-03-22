<?php

namespace App\Http\Controllers\Main;

use App\Models\Blog;
use App\Models\Main;
use App\Filters\BlogFilter;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\Response;

class MainBlogController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BlogFilter $filters, Main $main)
    {
        // $blogs = $main->withCount('blogs')->get();

        $blogs = \Cache::remember(
            $this->cacheResponse(),
            $this->cacheTime(),
            function() use ($filters){
                return Blog::with('categories')->filter($filters)->get();
        });

        return $this->showAll($blogs, Response::HTTP_OK, true);
    }

    public function show(Main $main, Blog $blog)
    {
        $blog = $main->blogs()->findOrFail($blog->id);

        return $this->showOne($blog, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request, Main $main)
    {
        if ($request->user()->cannot('create', Blog::class)) {
            return response()->json(['error' => 'This action is unauthorized.', 'code' => 403], Response::HTTP_FORBIDDEN);
        }

        $blogData = $request->safe()->except(['category', 'image']);
        $blogData['main_id'] = $main->id;

        $blog = Blog::create($blogData);

        if ($request->has('category')) {
            $catID = $request->input('category');
            $blog->categories()->sync($catID);
        }

        return $this->showOne($blog, Response::HTTP_CREATED);

    }
}

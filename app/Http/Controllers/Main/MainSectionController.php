<?php

namespace App\Http\Controllers\Main;

use App\Models\Main;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class MainSectionController extends ApiController
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
    public function index(Main $main)
    {
        $sections = $main->sections;

        return $this->showAll($sections, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionRequest $request, Main $main)
    {
        if ($request->user()->cannot('create', Section::class)) {
            return response()->json(['error' => 'This action is unauthorized.', 'code' => 403], Response::HTTP_FORBIDDEN);
        }

        $sectionData = $request->validated();
        $sectionData['main_id'] = $main->id;

        $section = Section::create($sectionData);

        return $this->showOne($section, Response::HTTP_CREATED);
    }
}

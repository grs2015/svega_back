<?php

namespace App\Http\Controllers\Section;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class SectionController extends ApiController
{
    public function __construct()
    {
        $this->authorizeResource(Section::class, 'section');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();

        return $this->showAll($sections, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        return $this->showOne($section, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SectionRequest $request, Section $section)
    {
        $section->fill($request->validated()) ;

        // if ($section->isClean()) {
        //     return response()->json(['message' => 'You need to specify difference values to update'], Response::HTTP_UNPROCESSABLE_ENTITY);
        // }

        $section->save();

        return $this->showOne($section, Response::HTTP_OK);
    }

}

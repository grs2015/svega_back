<?php

namespace App\Http\Controllers\Benefit;

use App\Models\Benefit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BenefitRequest;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class BenefitController extends ApiController
{
    public function __construct()
    {
        $this->authorizeResource(Benefit::class, 'benefit');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $benefits = Benefit::all();

        return $this->showAll($benefits, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Benefit $benefit)
    {
        return $this->showOne($benefit, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BenefitRequest $request, Benefit $benefit)
    {
        $benefit->fill($request->validated()) ;

        // if ($benefit->isClean()) {
        //     return response()->json(['message' => 'You need to specify difference values to update'], Response::HTTP_UNPROCESSABLE_ENTITY);
        // }

        $benefit->save();

        return $this->showOne($benefit, Response::HTTP_OK);
    }

    public function destroy(Benefit $benefit)
    {
        $benefit->delete();

        return $this->showOne($benefit, Response::HTTP_OK);
    }
}

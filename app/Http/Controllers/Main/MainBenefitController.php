<?php

namespace App\Http\Controllers\Main;

use App\Models\Main;
use App\Models\Benefit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BenefitRequest;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class MainBenefitController extends ApiController
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
        $benefits = $main->benefits;

        return $this->showAll($benefits, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BenefitRequest $request, Main $main)
    {
        if ($request->user()->cannot('create', Benefit::class)) {
            return response()->json(['error' => 'This action is unauthorized.', 'code' => 403], Response::HTTP_FORBIDDEN);
        }

        $benefitData = $request->validated();
        $benefitData['main_id'] = $main->id;

        $benefit = Benefit::create($benefitData);

        return $this->showOne($benefit, Response::HTTP_CREATED);
    }
}

<?php

namespace App\Http\Controllers\Main;

use App\Models\Main;
use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Requests\OfferRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class MainOfferController extends ApiController
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
        $offers = $main->offers;

        return $this->showAll($offers, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OfferRequest $request, Main $main)
    {
        if ($request->user()->cannot('create', Offer::class)) {
            return response()->json(['error' => 'This action is unauthorized.', 'code' => 403], Response::HTTP_FORBIDDEN);
        }

        $offerData = $request->validated();
        $offerData['main_id'] = $main->id;

        $offer = Offer::create($offerData);

        return $this->showOne($offer, Response::HTTP_CREATED);
    }
}

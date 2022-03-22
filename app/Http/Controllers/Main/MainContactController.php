<?php

namespace App\Http\Controllers\Main;

use App\Models\Main;
use App\Models\Contact;
use App\Models\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class MainContactController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request, Main $main)
    {

        $contactData = $request->validated();
        $contactData['main_id'] = $main->id;

        $contact = Contact::create($contactData);


        return $this->showOne($contact, Response::HTTP_CREATED);
    }

}

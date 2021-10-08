<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBusinessRequest;
use App\Models\Business;
use App\Repositories\BusinessRepository;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    protected BusinessRepository $repository;
    public function __construct(BusinessRepository $repository)
    {
        $this->repository=$repository;
    }
    public function create()
    {
        return view('business.create');
    }

    public function store(StoreBusinessRequest $request)
    {
        $this->repository->create($request->all());

        return redirect(route('businesses.index'))->with('created','Business was registered successfully!');
    }
}

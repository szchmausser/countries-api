<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStateRequest;
use App\Http\Requests\UpdateStateRequest;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Response;

class StateController extends Controller
{
    public function store(StoreStateRequest $request)
    {
        $state = new State();
        $state->fill($request->validated());
        $state->save();

        return response()->json($state, Response::HTTP_CREATED);
    }

    public function show(State $state)
    {
        return response()->json($state, Response::HTTP_OK);
    }

    public function update(State $state, UpdateStateRequest $request)
    {
        $state->update($request->validated());

        return response()->json($state, Response::HTTP_OK);
    }

    public function destroy(State $state)
    {
        $state->delete();

        return response()->json($state, Response::HTTP_NO_CONTENT);
    }

    public function listStatesByCountry(Country $country)
    {
        $states = $country->states()->get();

        return response()->json($states, Response::HTTP_OK);
    }
}

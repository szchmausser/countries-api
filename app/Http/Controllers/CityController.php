<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Response;

class CityController extends Controller
{
    public function store(StoreCityRequest $request)
    {
        $city = new City();
        $city->fill($request->validated());
        $city->save();

        return response()->json($city, Response::HTTP_CREATED);
    }

    public function show(City $city)
    {
        return response()->json($city, Response::HTTP_OK);
    }

    public function update(City $city, UpdateCityRequest $request)
    {
        $city->update($request->validated());

        return response()->json($city, Response::HTTP_OK);
    }

    public function destroy(City $city)
    {
        $city->delete();

        return response()->json($city, Response::HTTP_NO_CONTENT);
    }

    public function listCitiesByState(State $state)
    {
        $cities = $state->cities()->get();

        return response()->json($cities, Response::HTTP_OK);
    }
}

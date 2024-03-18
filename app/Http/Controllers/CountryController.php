<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCountryRequest;
use App\Models\Country;
use Illuminate\Http\Response;
use App\Http\Requests\StoreCountryRequest;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();

        return response()->json($countries, Response::HTTP_OK);
    }

    public function countriesSelect()
    {
        $countries = Country::all()->select('id', 'name');

        return response()->json($countries, Response::HTTP_OK);
    }

    public function store(StoreCountryRequest $request)
    {
        $country = new Country();
        $country->fill($request->validated());
        $country->save();

        return response()->json($country, Response::HTTP_CREATED);
    }

    public function show(Country $country)
    {
        return response()->json($country, Response::HTTP_OK);
    }

    public function update(Country $country, UpdateCountryRequest $request)
    {
        $country->update($request->validated());

        return response()->json($country, Response::HTTP_OK);
    }

    public function destroy(Country $country)
    {
        $country->delete();

        return response()->json($country, Response::HTTP_NO_CONTENT);
    }

    public function allData()
    {
        $countries = Country::with(['states' => function ($query) {
            $query->select('id', 'name', 'country_id'); // Asumiendo que 'country_id' es la FK en 'states'
        }, 'states.cities' => function ($query) {
            $query->select('id', 'name', 'state_id'); // Asumiendo que 'state_id' es la FK en 'cities'
        }])->get(['id', 'name']);

        return response()->json($countries, Response::HTTP_OK);
    }
}

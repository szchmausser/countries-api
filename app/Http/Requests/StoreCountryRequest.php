<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Aquí puedes determinar si el usuario tiene autorización para hacer esta petición.
        // Por defecto es falso, cámbialo a verdadero para permitir el acceso.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['nullable', 'string', 'unique:countries,name'],
            'iso3' => ['nullable', 'string'],
            'iso2' => ['nullable', 'string'],
            'numeric_code' => ['nullable', 'string'],
            'phone_code' => ['nullable', 'string'],
            'capital' => ['nullable', 'string'],
            'currency' => ['required', 'string'],
            'currency_name' => ['required', 'string'],
            'currency_symbol' => ['required', 'string'],
            'tld' => ['nullable', 'string'],
            'native' => ['nullable', 'string'],
            'region' => ['nullable', 'string'],
            'region_id' => ['nullable', 'string'],
            'subregion' => ['nullable', 'string'],
            'subregion_id' => ['nullable', 'string'],
            'nationality' => ['nullable', 'string'],
            'latitude' => ['nullable', 'string'],
            'longitude' => ['nullable', 'string'],
            'emoji' => ['nullable', 'string'],
            'emojiU' => ['nullable', 'string'],
        ];
    }
}

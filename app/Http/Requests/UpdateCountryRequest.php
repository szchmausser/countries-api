<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {
        return [
            'name' => ['nullable', 'string', 'unique:countries,name,' . $this->country->id],
            'iso3' => ['nullable', 'string'],
            'iso2' => ['nullable', 'string'],
            'numeric_code' => ['nullable', 'string'],
            'phone_code' => ['nullable', 'string'],
            'capital' => ['nullable', 'string'],
            'currency' => ['nullable', 'string'],
            'currency_name' => ['nullable', 'string'],
            'currency_symbol' => ['nullable', 'string'],
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

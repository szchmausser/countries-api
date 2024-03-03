<?php

namespace App\Http\Requests;

use App\Models\City;
use App\Rules\PreventDuplicateRecordIntoSameEntityRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
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
        $instance = $this->instance();
        $foreignKey = 'state_id';
        $method = $this->method();
        $class = City::class;

        return [
            'state_id' => ['required', 'exists:states,id'],
            'name' => ['required', 'string', new PreventDuplicateRecordIntoSameEntityRule($instance, $foreignKey, $method, $class)],
            'latitude' => ['nullable', 'string'],
            'longitude' => ['nullable', 'string'],
        ];
    }
}

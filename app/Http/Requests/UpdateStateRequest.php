<?php

namespace App\Http\Requests;

use App\Models\State;
use App\Rules\PreventDuplicateRecordIntoSameEntityRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStateRequest extends FormRequest
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
        $instance = $this->route('state');
        $foreignKey = 'country_id';
        $method = $this->method();
        $class = State::class;

        return [
            'name' => ['nullable', 'string', new PreventDuplicateRecordIntoSameEntityRule($instance, $foreignKey, $method, $class)],
            'state_code' => ['nullable', 'string',],
            'latitude' => ['nullable', 'string'],
            'longitude' => ['nullable', 'string'],
            'type' => ['nullable', 'string'],
        ];
    }
}

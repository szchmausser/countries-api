<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PreventDuplicateRecordIntoSameEntityRule implements ValidationRule
{
    private $instance;
    private $foreignKey;
    private $method;
    private $modelClass;

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function __construct($instance, $foreignKey, $method, $modelClass)
    {
        $this->instance = $instance;
        $this->foreignKey = $foreignKey;
        $this->method = $method;
        $this->modelClass = $modelClass;
    }

    public function validate(string $attribute, mixed $value, Closure $fail) : void
    {
        if ($this->method === 'PATCH' || $this->method === 'PUT') {

            $recordExists = $this->modelClass::where($attribute, $value)
                ->where($this->foreignKey, $this->instance->{$this->foreignKey})
                ->first();

            if ($recordExists && $recordExists->id != $this->instance->id) {
                $fail('No se puede editar atributo ' . $attribute . ' con el valor ' . $value . ' porque ya ha sido registrado anteriormente.');
            }
        }

        if ($this->method === 'POST') {

            $recordExists = $this->modelClass::where($attribute, $value)
                ->where($this->foreignKey, $this->instance->{$this->foreignKey})
                ->exists();

            if ($recordExists) {
                $fail('No se puede crear el registro ' . $value . ' porque ya ha sido registrado anteriormente.');
            }
        }
    }

    //https://www.laravelia.com/post/laravel-10-custom-validation-rule-example
    //https://stackoverflow.com/a/35167648
    //$this->instance es la instancia del modelo, el registro que existe en la base de datos del modelo que estamos editando
    //$this->foreignKey es el nombre de la llave foranea del modelo
    //$this->method es para identificar el metodo http de la peticion entrante, de tipo GET, POST, PUT, PATCH, DELETE, etc.
    //$this->modelClass es para identificar el nombre de la clase del modelo que estamos consultando
    //$attribute = es el nombre del campo donde se aplica la regla, por ejm el campo "name"
    //$value = es el valor del campo donde se aplica la regla, en este en el campo name que es igual a "San Fernando de Apure"
    //$fail = es la accion de validación, en este caso llamamos al metodo message que es el que informa al usuario el error
}

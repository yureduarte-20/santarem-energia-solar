<?php
namespace App\Actions\App;

use Illuminate\Support\Facades\Validator;

abstract class AbstractCrudAction
{
    public function rules()
    {
        return [];
    }
    public function messages()
    {
        return [];
    }
    public function attributes()
    {
        return [];
    }
    public function validate($input)
    {
        return $this->validator($input)->validate();
    }
    public function validator($input, $rules = null, $messages = null, $attributes = null)
    {
        $rules ?: $rules = $this->rules();
        $messages ?: $messages = $this->messages();
        $attributes ?: $attributes = $this->attributes();
        return Validator::make($input, $rules, $messages, $attributes);
    }
}

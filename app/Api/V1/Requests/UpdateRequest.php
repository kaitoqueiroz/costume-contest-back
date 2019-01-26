<?php

namespace App\Api\V1\Requests;

use Config;
use Dingo\Api\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules()
    {
        return Config::get('boilerplate.update.validation_rules');
    }

    public function authorize()
    {
        return true;
    }
}

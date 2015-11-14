<?php

namespace App\Auth\Http\Requests;

use App\Auth\Controllers\Api\v1\AuthenticationController;
use App\Core\Requests\Request;

class RegisterUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !$this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return AuthenticationController::getValidatorRules();
    }
}

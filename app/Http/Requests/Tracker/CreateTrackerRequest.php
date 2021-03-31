<?php

namespace App\Http\Requests\Tracker;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreateTrackerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * We do not want to do authorization here, so just return true.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'metric' => 'required|string|max:80',
            'description' => 'required|string|max:400',
            'display_units' => 'required|string|max:20',
            'goal_value' => 'nullable|string|size:20|numeric',
            'goal_timestamp' => 'nullable|date',
        ];
    }
}

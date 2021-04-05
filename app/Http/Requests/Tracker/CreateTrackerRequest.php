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
            'units' => 'required|string|max:20',
            'description' => 'nullable|string|max:400',
            'goal_value' => 'nullable|numeric',
            'goal_date' => 'nullable|date',
        ];
    }
}

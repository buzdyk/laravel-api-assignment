<?php

namespace App\Http\Requests;

use App\Enums\PlayerPosition;
use App\Enums\PlayerSkill;
use App\Rules\UniqueFieldInArray;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateOrUpdatePlayer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:20',
            'position' => ['required', new Enum(PlayerPosition::class)],
            'playerSkills' => ['required', 'min:1', new UniqueFieldInArray('skill')],
            'playerSkills.*.skill' => ['required', 'string', new Enum(PlayerSkill::class)],
            'playerSkills.*.value' => 'required|numeric|min:1|max:100',
        ];
    }
}

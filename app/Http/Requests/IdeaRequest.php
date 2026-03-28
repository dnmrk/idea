<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\IdeaStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class IdeaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::enum(IdeaStatus::class)],
            'links' => ['nullable', 'array'],
            'links.*' => ['url', 'max:255'],
            'steps' => ['nullable', 'array'],
            'steps.*.description' => ['string', 'max:255'],
            'steps.*.completed' => ['boolean'],
            'image' => ['nullable', 'image', 'max:5120'],
        ];
    }

    #[Override]
    protected function prepareForValidation(): void
    {
        if ($this->has('steps')) {
            $steps = [];
            foreach ($this->steps as $index => $step) {
                $steps[$index]['description'] = $step['description'];
                $steps[$index]['completed'] = filter_var($step['completed'], FILTER_VALIDATE_BOOLEAN);
            }

            $this->merge([
                'steps' => $steps,
            ]);
        }
    }
}

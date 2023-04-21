<?php

declare(strict_types=1);

namespace Training\UI\Web\AddMetricRecord;

use Illuminate\Foundation\Http\FormRequest;
use Training\Application\Command\AddMetricRecord\AddMetricRecordInput;

class AddMetricRecordRequest extends FormRequest
{
    /**
     * @return array<array-key, string[]>
     */
    public function rules(): array
    {
        return [
            'values' => ['required', 'array'],
            'values.*' => ['required', 'integer'],
            'date' => ['required', 'date'],
        ];
    }

    public function toInput(): AddMetricRecordInput
    {
        return new AddMetricRecordInput(
            trainingId: (string) $this->route('training'),
            date: $this->get('date'),
            values: array_map(
                callback: static fn (string $value) => (int) $value,
                array: $this->get('values'),
            ),
        );
    }
}

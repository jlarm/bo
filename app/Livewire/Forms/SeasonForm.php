<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\Season;
use Livewire\Form;

final class SeasonForm extends Form
{
    public string $season = '';

    public string $year = '';

    public function rules(): array
    {
        return [
            'season' => ['required', 'string'],
            'year' => ['required', 'string', 'date_format:Y'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->createSeasonName(),
        ];

        Season::create($data);
    }

    private function createSeasonName(): string
    {
        return $this->season.' '.$this->year;
    }
}

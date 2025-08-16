<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\Season;
use Livewire\Form;
use Str;

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

    public function messages(): array
    {
        return [
            'season_name_unique' => 'This season and year combination already exists.',
        ];
    }

    public function save(): bool
    {
        $this->validate();

        $seasonName = $this->createSeasonName();

        // Check if season name already exists
        if (Season::where('name', $seasonName)->exists()) {
            $this->addError('season', 'This season already exists.');

            return false;
        }

        $data = [
            'name' => $seasonName,
        ];

        Season::create($data);

        $this->reset(['season', 'year']);

        return true;
    }

    private function createSeasonName(): string
    {
        return Str::title($this->season).' '.$this->year;
    }
}

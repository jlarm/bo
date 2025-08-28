<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\Team;
use Livewire\Form;

final class TeamForm extends Form
{
    public string $name = '';

    public string $division = '';

    public int $seasonId;

    public function rules(): array
    {
        return [
            'seasonId' => 'required|exists:seasons,id',
            'name' => 'required|string|min:3|max:255',
            'division' => 'required|string|min:3|max:255',
        ];
    }

    public function save(int $seasonId): bool
    {
        $this->seasonId = $seasonId;
        $this->validate();

        if (Team::query()
            ->where('season_id', $seasonId)
            ->where('name', $this->name)
            ->where('division', $this->division)->exists()) {
            $this->addError('team', 'Team name already exists.');

            return false;
        }

        $data = [
            'season_id' => $seasonId,
            'name' => $this->name,
            'division' => $this->division,
        ];

        Team::create($data);

        $this->reset(['name', 'division']);

        return true;
    }
}

<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\Season;
use App\Models\Team;
use Livewire\Form;

final class TeamForm extends Form
{
    public string $name = '';

    public string $division = '';

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'division' => 'required|string|min:3|max:255',
        ];
    }

    public function save(Season $season): bool
    {
        $this->validate();

        if (Team::where('name', $this->name)->exists()) {
            $this->addError('team', 'Team name already exists.');

            return false;
        }

        $data = [
            'name' => $this->name,
            'division' => $this->division,
        ];

        $season->teams()->create($data);

        $this->reset(['name', 'division']);

        return true;
    }
}

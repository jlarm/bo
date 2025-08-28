<?php

declare(strict_types=1);

namespace App\Livewire\Team;

use App\Livewire\Forms\TeamForm;
use App\Models\Season;
use Flux\Flux;
use Illuminate\View\View;
use Livewire\Component;

final class CreateModal extends Component
{
    public Season $season;

    public TeamForm $form;

    public function save(): void
    {
        if (! $this->form->save($this->season->id)) {
            $this->addError('form.name', 'This team already exists in this season.');

            return;
        }

        $this->dispatch('team.create');

        Flux::modal('create-team')->close();

        Flux::toast(
            text: 'The new team created successfully.',
            heading: 'New Team Created',
            variant: 'success'
        );
    }

    public function render(): View
    {
        return view('livewire.team.create-modal');
    }
}

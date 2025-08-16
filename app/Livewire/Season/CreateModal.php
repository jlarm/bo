<?php

declare(strict_types=1);

namespace App\Livewire\Season;

use App\Livewire\Forms\SeasonForm;
use Flux\Flux;
use Illuminate\View\View;
use Livewire\Component;

final class CreateModal extends Component
{
    public SeasonForm $form;

    public function save(): void
    {
        if (! $this->form->save()) {
            return;
        }

        $this->dispatch('season.created');

        Flux::modal('create-season')->close();

        Flux::toast(
            text: 'The new season created successfully.',
            heading: 'New Season Created',
            variant: 'success',
        );
    }

    public function render(): View
    {
        return view('livewire.season.create-modal');
    }
}

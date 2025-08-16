<?php

declare(strict_types=1);

namespace App\Livewire\Season;

use App\Models\Season;
use Flux\Flux;
use Illuminate\View\View;
use Livewire\Component;

final class IndexItem extends Component
{
    public Season $season;

    public function archive(): void
    {
        $this->season->delete();

        $this->dispatch('season.archived');

        Flux::toast(
            text: 'The season was archived successfully.',
            heading: 'Season Archived',
            variant: 'success',
        );
    }

    public function render(): View
    {
        return view('livewire.season.index-item');
    }
}

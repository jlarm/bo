<?php

declare(strict_types=1);

namespace App\Livewire\Season;

use App\Models\Season;
use Illuminate\View\View;
use Livewire\Component;

final class Show extends Component
{
    public Season $season;

    public function render(): View
    {
        return view('livewire.season.show')
            ->title($this->season->name);
    }
}

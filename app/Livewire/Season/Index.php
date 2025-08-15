<?php

declare(strict_types=1);

namespace App\Livewire\Season;

use App\Models\Season;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Index extends Component
{
    #[On('season.created')]
    public function render(): View
    {
        return view('livewire.season.index', [
            'seasons' => Season::all(),
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Season;
use Str;

final class SeasonObserver
{
    public function creating(Season $season): void
    {
        $season->uuid = (string) Str::uuid();
    }
}

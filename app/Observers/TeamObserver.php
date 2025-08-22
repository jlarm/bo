<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Team;
use Str;

final class TeamObserver
{
    public function creating(Team $team): void
    {
        $team->uuid = (string) Str::uuid();
    }
}

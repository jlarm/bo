<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Organization;
use Str;

final class OrganizationObserver
{
    public function creating(Organization $organization): void
    {
        $organization->uuid = (string) Str::uuid();
    }
}

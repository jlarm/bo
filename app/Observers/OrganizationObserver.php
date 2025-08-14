<?php

namespace App\Observers;

use App\Models\Organization;
use Str;

class OrganizationObserver
{
    public function creating(Organization $organization): void
    {
        $organization->uuid = (string) Str::uuid();
    }
}

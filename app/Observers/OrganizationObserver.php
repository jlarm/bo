<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Organization;
use Str;

final class OrganizationObserver
{
    public function creating(Organization $organization): bool
    {
        // Prevent creating more than one organization
        if (Organization::count() > 0) {
            return false;
        }

        $organization->uuid = (string) Str::uuid();

        return true;
    }
}

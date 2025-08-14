<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\OrganizationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(OrganizationObserver::class)]
final class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'address',
        'city',
        'state',
        'zip_code',
        'logo_path',
    ];

    protected function casts(): array
    {
        return [
            'uuid' => 'string',
        ];
    }
}

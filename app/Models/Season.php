<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\SeasonObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(SeasonObserver::class)]
final class Season extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'archived',
    ];

    protected function casts(): array
    {
        return [
            'uuid' => 'string',
            'archived' => 'boolean',
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

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

    public function scopeOrderBySeasonAndYear($query)
    {
        return $query->orderBy('archived')
            ->orderByRaw('CAST(SUBSTR(name, -4) AS INTEGER)')
            ->orderByRaw("
            CASE
                WHEN INSTR(LOWER(name), 'spring') > 0 THEN 1
                WHEN INSTR(LOWER(name), 'summer') > 0 THEN 2
                WHEN INSTR(LOWER(name), 'fall') > 0 THEN 3
                WHEN INSTR(LOWER(name), 'winter') > 0 THEN 4
                ELSE 5
            END
        ");
    }

    protected function casts(): array
    {
        return [
            'uuid' => 'string',
            'archived' => 'boolean',
        ];
    }
}

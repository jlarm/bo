<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Season;
use Illuminate\Database\Seeder;

final class SeasonSeeder extends Seeder
{
    private array $seasons = [
        ['name' => 'Fall 2024', 'archived' => true],
        ['name' => 'Summer 2025', 'archived' => true],
        ['name' => 'Fall 2025', 'archived' => false],
        ['name' => 'Summer 2026', 'archived' => false],
    ];

    public function run(): void
    {
        foreach ($this->seasons as $season) {
            Season::create($season);
        }
    }
}

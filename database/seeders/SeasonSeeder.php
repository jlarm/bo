<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Season;
use Illuminate\Database\Seeder;

final class SeasonSeeder extends Seeder
{
    private array $seasons = [
        ['name' => 'Fall 2024'],
        ['name' => 'Summer 2025'],
        ['name' => 'Fall 2025'],
        ['name' => 'Summer 2026'],
    ];

    public function run(): void
    {
        $createdSeasons = [];

        foreach ($this->seasons as $season) {
            $createdSeasons[] = Season::create($season);
        }

        $lastTwoSeasons = array_slice($createdSeasons, -2);
        foreach ($lastTwoSeasons as $season) {
            $season->delete();
        }
    }
}

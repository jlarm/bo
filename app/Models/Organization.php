<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\OrganizationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public static function current(): ?self
    {
        return self::first();
    }

    public static function currentOrDefault(): self
    {
        return self::current() ?? self::create([
            'name' => config('app.name', 'Baseball Organization'),
            'address' => '',
            'city' => '',
            'state' => '',
            'zip_code' => '',
            'logo_path' => '',
        ]);
    }

    public static function createOrUpdate(array $data): self
    {
        $organization = self::current();

        if ($organization instanceof self) {
            $organization->update($data);

            return $organization;
        }

        return self::create($data);
    }

    public function getLogoUrlAttribute(): ?string
    {
        if (! $this->logo_path) {
            return null;
        }

        return Storage::url($this->logo_path);
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->name ?: config('app.name', 'Baseball Organization');
    }

    protected function casts(): array
    {
        return [
            'uuid' => 'string',
        ];
    }
}

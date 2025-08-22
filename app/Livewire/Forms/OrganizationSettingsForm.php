<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\Organization;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Form;

final class OrganizationSettingsForm extends Form
{
    public ?Organization $organization = null;

    #[Validate('required|string|min:3|max:255')]
    public string $name = '';

    #[Validate('nullable|string|min:3|max:255')]
    public string $address = '';

    #[Validate('nullable|string|min:3|max:255')]
    public string $city = '';

    #[Validate('nullable|string|min:2|max:255')]
    public string $state = '';

    #[Validate('nullable|string|min:3|max:255')]
    public string $zip_code = '';

    #[Validate('nullable|image|mimes:jpg,jpeg,png|max:2048')]
    public ?UploadedFile $logo_path = null;

    public function loadFromModel(): void
    {
        $this->organization = Organization::current();

        if ($this->organization instanceof Organization) {
            $this->fill([
                'name' => $this->organization->name,
                'address' => $this->organization->address,
                'city' => $this->organization->city,
                'state' => $this->organization->state,
                'zip_code' => $this->organization->zip_code,
            ]);
        }
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
        ];

        if ($this->logo_path instanceof UploadedFile) {
            $data['logo_path'] = $this->handleLogoUpload();
        }

        $this->organization = Organization::createOrUpdate($data);

        $this->logo_path = null;
    }

    private function handleLogoUpload(): string
    {
        if ($this->organization?->logo_path) {
            Storage::delete($this->organization->logo_path);
        }

        return $this->logo_path->store('logos', 'public');
    }
}

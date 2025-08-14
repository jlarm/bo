<?php

declare(strict_types=1);

namespace App\Livewire\Organization;

use App\Livewire\Forms\OrganizationSettingsForm;
use Flux\Flux;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

final class SettingsForm extends Component
{
    use WithFileUploads;

    public OrganizationSettingsForm $form;

    public function mount(): void
    {
        $this->form->loadFromModel();
    }

    public function save(): void
    {
        $this->form->save();

        Flux::toast(
            text: 'Your settings have been saved.',
            heading: 'Organization Settings',
            variant: 'success',
        );
    }

    #[On('logo-uploaded')]
    public function handleLogoUpload(): void
    {
        $this->form->validate(['logo_path']);
    }

    public function render(): View
    {
        return view('livewire.organization.settings-form');
    }
}

<x-layouts.app :title="__('Organization Settings')">
    <div container class="mx-auto max-w-7xl">
        <flux:heading size="lg">Organization Settings</flux:heading>
        <flux:separator variant="subtle" class="my-8" />
        <div class="mx-auto max-w-2xl">
            <livewire:organization.settings-form />
        </div>
    </div>
</x-layouts.app>

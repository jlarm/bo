<x-layouts.app :title="__('Seasons')">
    <div container class="mx-auto max-w-7xl">
        <div class="flex justify-between items-center">
            <flux:heading size="lg">Seasons</flux:heading>
            <livewire:season.create-modal />
        </div>
        <flux:separator variant="subtle" class="my-8" />
        <div class="mx-auto max-w-2xl">
            <livewire:season.index />
        </div>
    </div>
</x-layouts.app>

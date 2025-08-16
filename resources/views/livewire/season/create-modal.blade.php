<div>
    <flux:modal.trigger name="create-season">
        <flux:button size="sm" variant="primary">Add Season</flux:button>
    </flux:modal.trigger>

    <flux:modal name="create-season" class="md:w-96">
        <form wire:submit.prevent="save">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Add Season</flux:heading>
                </div>

                <flux:field>
                    <flux:radio.group wire:model="form.season" variant="buttons" class="w-full *:flex-1">
                        @foreach(\App\Enums\Seasons::cases() as $season)
                            <flux:radio value="{{ $season->value }}" icon="{{ $season->iconName() }}">{{ $season->label() }}</flux:radio>
                        @endforeach
                    </flux:radio.group>
                </flux:field>

                <flux:field>
                    <flux:input wire:model="form.year" placeholder="Year (e.g. 2025)"/>
                    <flux:error name="form.year" />
                </flux:field>

                <flux:error name="form.season" />

                <div class="flex">
                    <flux:spacer/>

                    <flux:button type="submit" variant="primary">Create</flux:button>
                </div>
            </div>
        </form>
    </flux:modal>
</div>

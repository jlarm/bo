<div>
    <flux:modal.trigger name="create-team">
        <flux:button size="sm" variant="primary">Add team</flux:button>
    </flux:modal.trigger>

    <flux:modal name="create-team" class="md:w-96">
        <form wire:submit.prevent="save">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Add Team</flux:heading>
                </div>

                <flux:field>
                    <flux:input wire:model="form.name" placeholder="Team Name"/>
                    <flux:error name="form.year" />
                </flux:field>

                <flux:radio.group wire:model="form.division" label="Division" variant="pills">
                    @foreach(\App\Enums\Division::cases() as $division)
                        <flux:radio value="{{ $division }}" label="{{ $division }}" />
                    @endforeach
                </flux:radio.group>

                <flux:error name="form.season" />

                <div class="flex">
                    <flux:spacer/>

                    <flux:button type="submit" variant="primary">Create</flux:button>
                </div>
            </div>
        </form>
    </flux:modal>
</div>

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

                <flux:radio.group wire:model="form.season" variant="buttons" class="w-full *:flex-1">
                    <flux:radio value="Spring" icon="flower">Spring</flux:radio>
                    <flux:radio value="Summer" icon="sun">Summer</flux:radio>
                    <flux:radio value="Fall" icon="leaf">Fall</flux:radio>
                    <flux:radio value="Winter" icon="snowflake">Winter</flux:radio>
                </flux:radio.group>

                <flux:input wire:model="form.year" placeholder="Year (e.g. 2025)" />

                <div class="flex">
                    <flux:spacer />

                    <flux:button type="submit" variant="primary">Create</flux:button>
                </div>
            </div>
        </form>
    </flux:modal>
</div>

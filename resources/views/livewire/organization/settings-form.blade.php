<div>
    <form wire:submit="save" class="space-y-6">
        <!-- Name field -->
        <flux:field>
            <flux:label>Organization Name</flux:label>
            <flux:input wire:model="form.name" placeholder="Enter organization name" />
            <flux:error name="form.name" />
        </flux:field>

        <!-- Address field -->
        <flux:field>
            <flux:label>Address</flux:label>
            <flux:input wire:model="form.address" placeholder="Street address" />
            <flux:error name="form.address" />
        </flux:field>

        <div class="grid grid-cols-3 gap-6">
            <!-- City field -->
            <flux:field>
                <flux:label>City</flux:label>
                <flux:input wire:model="form.city" placeholder="City" />
                <flux:error name="form.city" />
            </flux:field>

            <!-- State field -->
            <flux:field>
                <flux:label>State</flux:label>
                <flux:input wire:model="form.state" placeholder="State" />
                <flux:error name="form.state" />
            </flux:field>

            <!-- Zip Code field -->
            <flux:field>
                <flux:label>Zip Code</flux:label>
                <flux:input wire:model="form.zip_code" placeholder="12345" />
                <flux:error name="form.zip_code" />
            </flux:field>
        </div>

        <!-- Logo upload -->
        <flux:field>
            <flux:label>Logo {{ $form->organization ? '(Upload new to replace)' : '' }}</flux:label>
            <flux:input type="file" wire:model="form.logo_path" accept="image/*" />
            <flux:error name="form.logo_path" />

            <div wire:loading wire:target="form.logo_path" class="text-sm text-gray-500 mt-1">
                Uploading...
            </div>
        </flux:field>
        <!-- Show current logo if exists -->
        @if($form->organization?->logo_url)
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Current Logo</label>
                <img src="{{ $form->organization->logo_url }}" alt="Current Logo" class="w-20 h-20 object-cover rounded">
            </div>
        @endif


        <!-- Submit button -->
        <flux:button class="w-full" type="submit" variant="primary" wire:loading.attr="disabled">
              <span wire:loading.remove wire:target="save">
                  {{ $form->organization ? 'Update Organization' : 'Create Organization' }}
              </span>
            <span wire:loading wire:target="save">
                  Saving...
              </span>
        </flux:button>
    </form>
</div>

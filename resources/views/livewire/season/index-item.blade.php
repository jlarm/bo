<flux:table.row>
    <flux:table.cell>
        <div class="flex items-center gap-1">
            {{ $season->name }}
            @if($season->archived)
                <flux:badge size="sm" color="amber">Archived</flux:badge>
            @endif
        </div>
    </flux:table.cell>
    <flux:table.cell align="end">
        <flux:dropdown>
            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>
            <flux:menu>
                <flux:menu.item
                    wire:click="{{ $season->archived ? 'reactivate' : 'archive' }}"
                    wire:confirm="{{ $season->archived ? 'Are you sure you want to reactivate this season?' : 'Are you sure you want to archive this season?' }}"
                    icon="{{ $season->archived ? 'arrow-up-circle' : 'trash' }}"
                    variant="{{ $season->archived ? 'default' : 'danger' }}"
                >
                    {{ $season->archived ? 'Reactivate' : 'Archive' }}
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:table.cell>
</flux:table.row>

<flux:table.row>
    <flux:table.cell>
        <div class="flex items-center gap-1">
            {{ $season->name }}
        </div>
    </flux:table.cell>
    <flux:table.cell align="end">
        <flux:dropdown>
            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>
            <flux:menu>
                <flux:menu.item
                    href="{{ route('season.show', $season->uuid) }}"
                    icon="eye"
                >View</flux:menu.item>
                <flux:menu.item
                    wire:click="archive"
                    wire:confirm="Are you sure you want to archive this season?"
                    icon="trash"
                    variant="danger"
                >Archive</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:table.cell>
</flux:table.row>

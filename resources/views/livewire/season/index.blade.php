<div>
    <flux:table>
        <flux:table.rows>
            @foreach($seasons as $season)
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
                        <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>

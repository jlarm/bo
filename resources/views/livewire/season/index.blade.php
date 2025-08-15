<div>
    <flux:table>
        <flux:table.rows>
            @foreach($seasons as $season)
                <livewire:season.index-item :$season :key="$season->uuid" />
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>

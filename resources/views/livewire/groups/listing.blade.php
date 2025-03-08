<div>
    <div
        class="max-w-7xl px-6 sm:px-8 py-3 mx-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-2">
        <div class="flex items-baseline gap-3">
            <flux:heading size="xl" level="1">{{ __('Groups') }}</flux:heading>
            <flux:subheading size="lg" class="mb-6">{{ __('Manage your groups and invitations') }}</flux:subheading>
        </div>
        <flux:spacer />
        <flux:button icon="pencil-square">{{ __('New group') }}</flux:button>
    </div>

    <flux:separator variant="subtle" />

    <flux:table :paginate="$groups">
        <flux:table.columns>
            <flux:table.column>{{ __('Type') }}</flux:table.column>
            <flux:table.column>{{ __('Name') }}</flux:table.column>
            <flux:table.column>{{ __('Description') }}</flux:table.column>
            <flux:table.column>{{ __('Creation') }}</flux:table.column>
            <flux:table.column>{{ __('Actions') }}</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>

            @foreach ($groups as $group)
                <flux:table.row :key="$group->id">
                    <flux:table.cell>
                        <flux:badge color="{{ $group->group_type->getColor() }}">{{ $group->group_type->getLabel() }}
                        </flux:badge>
                    </flux:table.cell>
                    <flux:table.cell variant="strong">{{ $group->name }}</flux:table.cell>
                    <flux:table.cell>{{ $group->description }}</flux:table.cell>
                    <flux:table.cell>{{ $group->created_at->diffForHumans() }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:button.group>
                            <flux:button icon="pencil" size="sm"></flux:button>
                            <flux:button icon="trash" variant="danger" size="sm"></flux:button>
                        </flux:button.group>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
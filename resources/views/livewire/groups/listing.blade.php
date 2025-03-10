<div>
    <div
        class="max-w-7xl px-6 sm:px-8 py-3 mx-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-2">
        <div class="flex items-baseline gap-3">
            <flux:heading size="xl" level="1">{{ __('Groups') }}</flux:heading>
            <flux:subheading size="lg" class="mb-6">{{ __('Manage your groups') }}</flux:subheading>
        </div>
        <flux:spacer />
        <flux:modal.trigger name="create-group">
            <flux:button icon="pencil-square" variant="filled">{{ __('New group') }}</flux:button>
        </flux:modal.trigger>

        <livewire:groups.create />
        <livewire:groups.edit />

        <flux:modal name="delete-group" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Delete group?</flux:heading>

                    <flux:subheading>
                        <p>You're about to delete this group.</p>
                        <p>This action cannot be reversed.</p>
                    </flux:subheading>
                </div>

                <div class="flex gap-2">
                    <flux:spacer />

                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>

                    <flux:button wire:click="destroy()" type="submit" variant="danger">Delete group</flux:button>
                </div>
            </div>
        </flux:modal>

    </div>

    <flux:separator variant="subtle" />

    <flux:table>
        <flux:table.columns>
            <flux:table.column>{{ __('Type') }}</flux:table.column>
            <flux:table.column>{{ __('Role') }}</flux:table.column>
            <flux:table.column>{{ __('Name') }}</flux:table.column>
            <flux:table.column>{{ __('Description') }}</flux:table.column>
            <flux:table.column>{{ __('Member(s)') }}</flux:table.column>
            <flux:table.column>{{ __('Actions') }}</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>

            @foreach ($groups as $group)
                <flux:table.row :key="$group->id">
                    <flux:table.cell>
                        <flux:badge size="sm" color="{{ $group->group_type->getColor() }}">
                            {{ $group->group_type->getLabel() }}
                        </flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:badge size="sm" color="{{ $group->my_role()->getColor() }}">
                            {{ $group->my_role()->getLabel() }}
                        </flux:badge>
                    </flux:table.cell>
                    <flux:table.cell variant="strong">{{ $group->name }}</flux:table.cell>
                    <flux:table.cell>{{ $group->description }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge as="button" variant="pill" icon="user" size="sm">{{ $group->users_count }}</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:button.group>
                            @can('update', $group)
                                <flux:button wire:click="edit({{ $group->id }})" icon="pencil" size="sm" variant="filled">
                                </flux:button>
                            @endcan
                            @can('delete', $group)
                                <flux:button wire:click="delete({{ $group->id }})" icon="trash" variant="danger" size="sm">
                                </flux:button>
                            @endcan
                        </flux:button.group>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
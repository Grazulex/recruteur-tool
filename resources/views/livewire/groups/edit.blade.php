<div>
    <flux:modal name="edit-group" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Edit group') }}</flux:heading>
                <flux:subheading>{{ __('Edit your group') }}</flux:subheading>
            </div>

            <flux:radio.group wire:model="form.group_type" label="{{ __('Type of group') }}">
                @foreach ($groupTypes as $groupType)
                    <flux:radio value="{{ $groupType }}" label="{{ $groupType->getLabel() }}" />
                @endforeach
            </flux:radio.group>

            <flux:input wire:model="form.name" label="{{ __('Name') }}" placeholder="Name of your new group" />

            <flux:textarea wire:model="form.description" label="{{ __('Description') }}"
                placeholder="Description of your new group" />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" wire:click="update" variant="primary">Save changes</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
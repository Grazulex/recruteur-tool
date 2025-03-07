<div>
    <flux:heading size="lg" level="2">{{ __('Last groups') }}</flux:heading>
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        @foreach ($groups as $group)
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                {{ $group->name }}
                {{ $group->created_at }}
            </div>
        @endforeach
    </div>
</div>
<div class="space-y-4">
    @forelse ($answers as $answer)
        <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
            <div class="mb-2 flex items-center justify-between">
                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                    {{ $answer->user?->name ?? __('Unknown') }}
                </span>
                <span class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $answer->created_at->format('d M Y H:i') }}
                </span>
            </div>
            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $answer->body }}</p>
        </div>
    @empty
        <p class="text-center text-sm text-gray-500 dark:text-gray-400">
            {{ __('No answers yet.') }}
        </p>
    @endforelse
</div>

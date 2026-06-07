<div class="flex flex-col h-[70vh] bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
    @if(!$isMember)
        <div class="flex-1 flex flex-col items-center justify-center text-gray-400 dark:text-gray-500 p-8">
            <x-filament::icon name="heroicon-o-lock-closed" class="h-16 w-16 mb-4" />
            <p class="text-lg font-medium text-gray-900 dark:text-white">Join this chat room to participate</p>
            <p class="text-sm mt-1 text-gray-500 dark:text-gray-400">You must be a member to view and send messages</p>
            <x-filament::button
                wire:click="joinChatRoom"
                icon="heroicon-m-arrow-right-start-on-rectangle"
                class="mt-6"
            >
                Join Chat Room
            </x-filament::button>
        </div>
    @else
        <div class="flex items-center justify-between px-6 py-3 border-b border-gray-200 dark:border-gray-800 shrink-0">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-sm font-semibold shrink-0">
                    {{ strtoupper(substr($chatRoom->title, 0, 1)) }}
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $chatRoom->title }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $chatRoom->members()->count() }} members
                    </p>
                </div>
            </div>
            <x-filament::button
                wire:click="leaveChatRoom"
                color="gray"
                size="xs"
                outlined
            >
                Leave
            </x-filament::button>
        </div>

        <div class="flex-1 overflow-y-auto px-6 py-4 space-y-3" id="chatroom-messages" x-init="$nextTick(() => $el.scrollTop = $el.scrollHeight)" x-on:new-message.window="$nextTick(() => $el.scrollTop = $el.scrollHeight)">
            @forelse($messages as $message)
                @php $isMine = $message['user_id'] === auth()->id(); @endphp
                <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                    <div class="group max-w-[70%]">
                        <div class="flex items-end gap-2 {{ $isMine ? 'flex-row-reverse' : '' }}">
                            <div class="h-7 w-7 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-xs font-semibold shrink-0">
                                {{ strtoupper(substr($message['user']['name'] ?? '?', 0, 1)) }}
                            </div>
                            <div class="px-3 py-2 rounded-2xl {{ $isMine ? 'bg-emerald-500 text-white rounded-br-md' : 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-bl-md' }}">
                                @if(!$isMine)
                                    <p class="text-xs font-semibold mb-0.5 text-emerald-600 dark:text-emerald-400">
                                        {{ $message['user']['name'] ?? 'Unknown' }}
                                    </p>
                                @endif
                                <p class="text-sm leading-relaxed">{{ $message['content'] }}</p>
                                <p class="text-[10px] mt-1 {{ $isMine ? 'text-emerald-100' : 'text-gray-400 dark:text-gray-500' }}">
                                    {{ \Carbon\Carbon::parse($message['created_at'])->format('g:i A') }}
                                </p>
                            </div>
                        </div>

                        @if($isMine)
                            <div class="flex justify-end gap-1 mt-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <x-filament::button
                                    wire:click="openEditModal({{ $message['id'] }})"
                                    size="xs"
                                    color="gray"
                                    icon="heroicon-m-pencil-square"
                                    outlined
                                />
                                <x-filament::button
                                    wire:click="openDeleteMessageModal({{ $message['id'] }})"
                                    size="xs"
                                    color="danger"
                                    icon="heroicon-m-trash"
                                    outlined
                                />
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center h-full text-gray-400 dark:text-gray-500">
                    <x-filament::icon name="heroicon-o-chat-bubble-left-right" class="h-12 w-12 mb-3" />
                    <p class="text-sm">No messages yet</p>
                    <p class="text-xs mt-1">Be the first to say something</p>
                </div>
            @endforelse
        </div>

        <div class="border-t border-gray-200 dark:border-gray-800 px-6 py-4 shrink-0">
            <div class="flex items-center gap-3">
                <input
                    type="text"
                    x-on:keydown.enter="$wire.newMessage($el.value); $el.value = ''"
                    placeholder="Type your message..."
                    class="flex-1 rounded-xl border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 py-2.5 px-4 text-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"
                >
                <x-filament::button
                    x-on:click="$wire.newMessage($el.closest('div').querySelector('input').value); $el.closest('div').querySelector('input').value = ''"
                    icon="heroicon-m-paper-airplane"
                    size="sm"
                >
                    Send
                </x-filament::button>
            </div>
        </div>
    @endif

    <x-filament::modal id="edit-message-modal" width="md">
        <x-slot name="heading">Edit Message</x-slot>
        <div class="space-y-4">
            <input
                wire:model="editingMessageContent"
                type="text"
                x-on:keydown.enter="$wire.saveEditedMessage()"
                class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 px-3 py-2 text-sm"
            >
            <div class="flex justify-end gap-2">
                <x-filament::button
                    x-on:click="$dispatch('close-modal', { id: 'edit-message-modal' })"
                    color="gray"
                >
                    Cancel
                </x-filament::button>
                <x-filament::button
                    wire:click="saveEditedMessage"
                >
                    Save Changes
                </x-filament::button>
            </div>
        </div>
    </x-filament::modal>

    <x-filament::modal id="delete-message-modal" width="sm">
        <x-slot name="heading">Delete Message</x-slot>
        <p class="text-sm text-gray-600 dark:text-gray-400">Are you sure you want to delete this message? This action cannot be undone.</p>
        <div class="mt-6 flex justify-end gap-2">
            <x-filament::button
                x-on:click="$dispatch('close-modal', { id: 'delete-message-modal' })"
                color="gray"
            >
                Cancel
            </x-filament::button>
            <x-filament::button
                wire:click="confirmDeleteMessage"
                color="danger"
            >
                Delete
            </x-filament::button>
        </div>
    </x-filament::modal>
</div>

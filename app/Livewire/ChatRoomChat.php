<?php

namespace App\Livewire;

use App\Events\NewMessage;
use App\Models\ChatRoom;
use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\Locked;

class ChatRoomChat extends Component
{
    #[Locked]
    public ChatRoom $chatRoom;

    public array $messages = [];

    public ?int $editingMessageId = null;

    public string $editingMessageContent = '';

    public ?int $deletingMessageId = null;

    public function mount(ChatRoom $chatRoom)
    {
        $this->chatRoom = $chatRoom;
        $this->loadMessages();
    }

    public function getListeners()
    {
        return [
            'echo:chat-room.'.$this->chatRoom->id.',.new-message' => 'handleNewMessage',
        ];
    }

    public function handleNewMessage($data)
    {
        $this->loadMessages();
    }

    public function loadMessages(): void
    {
        $this->messages = $this->chatRoom->messages()
            ->with('user')
            ->latest()
            ->take(100)
            ->get()
            ->reverse()
            ->values()
            ->toArray();
    }

    public function joinChatRoom()
    {
        if ($this->chatRoom->members()->where('user_id', auth()->id())->doesntExist()) {
            $this->chatRoom->members()->attach(auth()->id(), ['role' => 'member']);
        }

        $this->dispatch('$refresh');
    }

    public function leaveChatRoom()
    {
        $this->chatRoom->members()->detach(auth()->id());

        $this->dispatch('$refresh');
    }

    public function newMessage($text)
    {
        if (empty(trim($text))) {
            return;
        }

        $message = Message::create([
            'chat_room_id' => $this->chatRoom->id,
            'user_id' => auth()->id(),
            'content' => $text,
        ]);

        $message->load('user');

        $this->messages[] = $message->toArray();

        NewMessage::dispatch($message);
    }

    public function editMessage($messageId, $newText)
    {
        $message = Message::find($messageId);

        if ($message && $message->user_id === auth()->id()) {
            $message->update(['content' => $newText]);

            foreach ($this->messages as $key => $msg) {
                if ($msg['id'] === $messageId) {
                    $this->messages[$key]['content'] = $newText;

                    break;
                }
            }

            NewMessage::dispatch($message);
        }
    }

    public function deleteMessage($messageId)
    {
        $message = Message::find($messageId);

        if ($message && $message->user_id === auth()->id()) {
            $this->messages = array_values(array_filter(
                $this->messages,
                fn ($msg) => $msg['id'] !== $messageId,
            ));

            NewMessage::dispatch($message);
            $message->delete();
        }
    }

    public function openEditModal(int $messageId): void
    {
        $this->editingMessageId = $messageId;

        foreach ($this->messages as $msg) {
            if ($msg['id'] === $messageId) {
                $this->editingMessageContent = $msg['content'];

                break;
            }
        }

        $this->dispatch('open-modal', id: 'edit-message-modal');
    }

    public function saveEditedMessage(): void
    {
        if ($this->editingMessageId && ! empty(trim($this->editingMessageContent))) {
            $this->editMessage($this->editingMessageId, $this->editingMessageContent);
        }

        $this->dispatch('close-modal', id: 'edit-message-modal');
        $this->editingMessageId = null;
        $this->editingMessageContent = '';
    }

    public function openDeleteMessageModal(int $messageId): void
    {
        $this->deletingMessageId = $messageId;
        $this->dispatch('open-modal', id: 'delete-message-modal');
    }

    public function confirmDeleteMessage(): void
    {
        if ($this->deletingMessageId) {
            $this->deleteMessage($this->deletingMessageId);
        }

        $this->dispatch('close-modal', id: 'delete-message-modal');
        $this->deletingMessageId = null;
    }

    public function render()
    {
        $isMember = $this->chatRoom->members()->where('user_id', auth()->id())->exists();

        return view('livewire.chat-room-chat', [
            'isMember' => $isMember,
        ]);
    }
}

<?php

namespace App\Livewire;

use App\Models\Conversation;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]

class Chat extends Component
{
    public string $messagetext;

    public array $myconversations;

    public int $activeconversationid;

    public function mount()
    {
        $this->myconversations = Conversation::where('user_one', auth()->user()->id)
            ->orwhere('user_two', auth()->user()->id)
            ->with('otheruser')->get()->toarray();

    }

    public function render()
    {
        return view('livewire.chat');
    }
}

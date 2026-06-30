<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use Livewire\Component;
use App\Models\Conversation;

class Chat extends Component
{
    public $query;
    public $selectedConversation;

    public function render()
    {
        return view('livewire.chat.chat')->layout($this->getDynamicLayout());;
    }

    public function mount() {
        $this->selectedConversation= Conversation::findOrFail($this->query);

        // Tandai pesan kepada penerima sebagai dibaca
        Message::where('conversation_id', $this->selectedConversation->id)
            ->where('receiver_id',auth()->id())
            ->whereNull('read_at')
            ->update(['read_at'=>now()]);
    }

    protected function getDynamicLayout()
    {
        if (auth()->user()?->role === 'admin') {
            return 'layouts.admin';
        }

        return 'layouts.app';
    }
}
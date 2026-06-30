<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Redirect;

class ChatUsers extends Component
{
    public function render()
    {
        return view('livewire.chat-users', ['users'=>User::where('id','!=',auth()->id())->get()])->layout($this->getLayout());
    }

    protected function getLayout()
    {
        return auth()->user()->role === 'admin'
            ? 'layouts.admin'
            : 'layouts.app';
    }

    public function message($userId)
    {
        $authenticatedUserId = auth()->id();

        // Cek percakapan yang ada
        $existingConversation = Conversation::where(function ($query) use ($authenticatedUserId, $userId) {
            $query->where('sender_id', $authenticatedUserId)
                  ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($authenticatedUserId, $userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', $authenticatedUserId);
        })->first();

        if ($existingConversation) {
            return redirect()->route('chat', ['query' => $existingConversation->id]);
        }

        $createdConversation = Conversation::create([
          'sender_id' => $authenticatedUserId,
          'receiver_id' => $userId,
        ]);

        return redirect()->route('chat', ['query' => $createdConversation->id]);
    }
}
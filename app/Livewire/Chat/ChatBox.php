<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Message;
use App\Notifications\MessageSent;
use App\Notifications\MessageRead;
use Livewire\Livewire;

class ChatBox extends Component
{
    public $body;
    public $loadedMessages;
    public $selectedConversation;
    public $paginate_var=10;
    protected $listeners=[
        'loadMore'
    ];

    public function getListeners() {
        $auth_id= auth()->user()->id;
        return [
            'loadMore',
            "echo-private:users.{$auth_id},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated"=>'broadcastedNotifications',
        ];
    }

    public function broadcastedNotifications($event) {
        if($event['type']== MessageSent::class) {
            if($event['conversation_id']==$this->selectedConversation->id) {
                $this->dispatch('scroll-bottom');

                $newMessage= Message::find($event['message_id']);

                // Push Message
                $this->loadedMessages->push($newMessage);

                // Menandakan pesan sebagai sudah dibaca
                $newMessage->read_at= now();
                $newMessage->save();

                #Broadcast
                $this->selectedConversation->getReceiver()
                    ->notify(new MessageRead($this->selectedConversation->id) );

            }
        }
    }

    public function loadMore() : void {

        $this->paginate_var += 10;

        $this->loadMessages();

        $this->js(<<<'JS'
            window.dispatchEvent(new CustomEvent('update-chat-height'));
        JS);

    }

    public function loadMessages() {
        $count= Message::where('conversation_id', $this->selectedConversation->id)->count();
        $this->loadedMessages=Message::where('conversation_id', $this->selectedConversation->id)
        ->skip(max(0, $count - $this->paginate_var))
        ->take($this->paginate_var)
        ->get();

        return $this->loadedMessages;
    }

    public function sendMessage() {
        $this->validate([
            'body'=>'required|string'
        ]);

        $createdMessage= Message::create([
            'conversation_id'=>$this->selectedConversation->id,
            'sender_id'=>auth()->id(),
            'receiver_id'=>$this->selectedConversation->getReceiver()->id,
            'body'=>$this->body,
        ]);

        $this->reset('body');

        // $this->dispatch('scroll-bottom');

        $this->js(<<<'JS'
            window.dispatchEvent(new CustomEvent('scroll-bottom'));
        JS);

        // Kirim Pesannya
        $this->loadedMessages->push($createdMessage);

        // update conversation model
        $this->selectedConversation->updated_at= now();
        $this->selectedConversation->save();

        // Refresh inbox
        $this->dispatch('refresh')->to('chat.inbox');

        #Broadcast
        $this->selectedConversation->getReceiver()
            ->notify(new MessageSent(
                Auth()->User(),
                $createdMessage,
                $this->selectedConversation,
                $this->selectedConversation->getReceiver()->id
            ));
    }

    public function mount() {
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
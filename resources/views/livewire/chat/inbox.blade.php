<div x-data="{type:'all',query:@entangle('query')}"
    x-init="setTimeout(()=>{
    conversationElement = document.getElementById('conversation-'+query);

    // Scroll ke elemen
    if(conversationElement){
        conversationElement.scrollIntoView({'behavior':'smooth'})
    }
    }
    ,200);
    
    Echo.private('users.{{Auth()->User()->id}}')
        .notification((notification)=>{
            if(notification['type']=='App\\Notifications\\MessageRead'||notification['type']=='App\\Notifications\\MessageSent'){
                window.Livewire.emit('refresh');
            }g
        });"
    class="flex flex-col transition-all h-full overflow-hidden">
    <header class="sticky z-10 w-full px-3 py-2 top-0 bg-white">
        <div class="justify-between flex items-center border-b">
            <div class="flex items-center gap-2">
                <h5 class="font-extrabold text-2xl">Chats</h5>
            </div>
            <button>
                <svg class="size-7" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24" >
                    <!--Boxicons v3.0 https://boxicons.com | License  https://docs.boxicons.com/free-->
                    <path d="M3 6H21V8H3z"></path><path d="M6 11H18V13H6z"></path><path d="M9 16H15V18H9z"></path>
                </svg>
            </button>
        </div>

        {{-- Filters --}}
        <div class="flex items-center gap-3 p-2 bg-white">
            <button @click="type='all'" :class="{'bg-blue-100 border-0 text-black':type=='all'}" class="inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1 lg:py-2.5 border">
                All
            </button>
        </div>
    </header>

    <main class="relative overflow-hidden grow h-full" style="contain:content">
        {{-- chatlist --}}
        <ul class="grid space-y-2 p-2 w-full">
            @if($conversations)

            @foreach($conversations as $conversation)
            <li
            id="conversation-{{$conversation->id}}" wire:key="{{$conversation->id}}"
            class="flex relative cursor-pointer py-3 hover:bg-gray-100 rounded-2xl dark:hover:bg-gray-700/70 transition-colors duration-150 gap-3 w-full px-2 {{$conversation->id==$selectedConversation?->id ? 'bg-gray-100/70':''}}">
                <a href="#" class="shrink-0">
                    <x-avatar/>
                </a>
                <aside class="grid grid-cols-12 w-full">
                    <a href="{{route('chat', $conversation->id)}}" class="relative col-span-11 border-b pb-2 border-gray-200 overflow-hidden truncate flex-nowrap leading-5 w-full p-1">
                        {{-- name and date --}}
                        <div class="flex justify-between w-full items-center">
                            <h6 class="truncate font-medium tracking-wider text-gray-800">
                                {{$conversation->getReceiver()->name}}
                            </h6>
                            <small class="text-gray-700">{{$conversation->messages?->last()?->created_at?->shortAbsoluteDiffForHumans()}}</small>
                        </div>
                        {{-- message --}}
                        <div class="flex gap-x-2 items-center">
                            @if($conversation->messages?->last()?->sender_id==auth()->id())

                            @if($conversation->isLastMessageReadByUser())
                            {{-- double tick --}}
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-all" viewBox="0 0 16 16">
                                    <path d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486z"/>
                                </svg>
                            </span>
                            @else
                                {{-- single tick --}}
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                                    </svg>
                                </span>
                            @endif
                            @endif

                            <p class="grow truncate text-sm font-[100]">
                                {{$conversation->messages?->last()?->body??''}}
                            </p>

                            @if($conversation->unreadMessagesCount()>0)
                            <span class="font-bold p-px px-2 text-xs shrink-0 rounded-full bg-blue-500 text-white">
                                {{$conversation->unreadMessagesCount()}}
                            </span>
                            @endif
                        </div>
                    </a>

                    {{-- Dropdown --}}
                    <div class="col-span-1 flex flex-col text-center my-auto">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical size-7 text-gray-700" viewBox="0 0 16 16">
                                        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-full p-1">
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </aside>
            </li>
            @endforeach

            @endif

        </ul>
    </main>
</div>
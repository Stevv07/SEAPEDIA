@push('title', 'Inbox')

<section class="relative size-full items-center px-3 sm:px-6 mt-6 p-6 md:shadow-md rounded-lg min-h-[550px] bg-white ">
    <div class="hidden lg:flex absolute overflow-y-hidden shrink-0 inset-y-0 left-0 w-1/3 shadow-md rounded-lg min-h-[320px] border">
        <livewire:chat.inbox :selectedConversation="$selectedConversation" :query="$query" />
    </div>
    <div class="absolute md:inset-y-0 md:right-0 overflow-y-auto md:grid min-h-[500px] md:w-2/3 w-full border rounded-lg" style="contain:content">
        <livewire:chat.chat-box :selectedConversation="$selectedConversation" />
    </div>
</section>
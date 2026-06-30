@push('title', 'Inbox')

<section class="relative size-full items-center px-3 mt-6 py-6 md:shadow-md rounded-lg min-h-[550px] bg-white">
    <div class="absolute overflow-y-hidden shrink-0 md:inset-y-0 md:left-0 md:w-1/3 w-full shadow-md rounded-lg min-h-[500px] border">
        <livewire:chat.inbox/>
    </div>
    <div class="hidden md:absolute inset-y-0 right-0 overflow-y-auto md:grid min-h-[500px] md:w-2/3 w-full border rounded-lg" style="contain:content">
        <div class="flex flex-col gap-3 m-auto text-center justify-center">
            <h4 class="font-medium text-lg">Choose a conversation to start chatting</h4>
        </div>
    </div>
</section>
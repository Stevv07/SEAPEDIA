@push('title', 'Chat - User')

<div class="max-w-6xl mx-auto my-16">
    <h5 class="text-center text-5xl font-bold py-3">
        Users
    </h5>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 p-2">
        @foreach($users as $user)

        {{-- Child --}}
        <div class="w-full border border-gray-200 rounded-lg p-5 shadow">
            <div class="flex flex-col items-center pb-10">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle size-24 rounded-lg mb-2.5 shadow-lg" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>
                <h5 class="mb-1 font-medium text-xl text-gray-900">
                    {{$user->name}}
                </h5>
                <span class="text-sm text-gray-500">
                    {{$user->email}}
                </span>
                <div class="flex mt-4 space-x-3 md:mt-6">
                    <x-primary-button wire:click="message({{$user->id}})">
                        Message
                    </x-primary-button>
                </div>
            </div>
        </div>

        @endforeach
    </div>
</div>
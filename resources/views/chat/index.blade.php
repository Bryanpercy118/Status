<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div style="height: 400px; overflow-y: auto;">
            @foreach ($messages as $message)
                <div class="flex rounded-lg p-r mb-4 @if($message['role']=='assistant') bg-green-200 flex-reverse @else bg-blue-200 @endif">
                    <div class="ml-4">
                        <div class="text-lg">
                            @if($message['role']==='assistant')
                                <a href="#" class="font-medium text-gray-900">Laravel Chat GPT</a>
                            @else
                                <a href="#" class="font-medium text-gray-900">{{ Auth::user()->name }}</a>
                            @endif
                        </div>
                        <div class="mt-1">
                            <p class="text-gray-600">
                                {!! \Illuminate\Mail\Markdown::parse($message['content']) !!}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 20px;">
            <form class="p-4 flex space-x-4 justify-center items-center" action="/Auth/User/Chat/OpenAI" method='POST'>
                @csrf
                <label for="message">Chat GPT by Bryan Percy</label>
                <input id="message" type="text" name="message" autocomplete="off" class="border rounded-md p-2 flex-1" placeholder="Envía un mensaje">
                <a class="bg-gray-800 text-white p-2 rounded-md" href="{{ route('chat.reset') }}">Limpiar Chat</a>
            </form>
        </div>

    </div>
</x-app-layout>

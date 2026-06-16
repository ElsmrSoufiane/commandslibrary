<div class="grid grid-cols-12">
    <div class="col-span-4 border-1">
        @foreach($this->conversations as $conversation)
            <div class="text-center p-2 border-2">
                <span class="p-2 bg-gray-600 text-white rounded-[50%]">
                    {{ $conversation['username'][0] }}
                </span>
                {{ $conversation['username'] }}
            </div>
        @endforeach
    </div>
    <div class="col-span-8 border-1"></div>
</div>

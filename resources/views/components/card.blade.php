{{-- make a card component, we should be able to merge in custom class elements --}}
<div {{ $attributes->merge(['class' => 'w-1/3 m-5 bg-white rounded-lg shadow-lg']) }}>

    {{-- make a header with the title passed in --}}
    <div class="bg-gray-200 px-4 py-2 rounded-t-lg">
        {{-- make a flex row so we can have the title on the left and the buttons on the right --}}
        <div class="flex flex-row justify-between">
            {{-- make a header with the title passed in --}}
            {{ $header }}

            {{-- make a slot for the buttons --}}
            @if(isset($buttons))
                {{ $buttons }}
            @endif
        </div>

    </div>

    {{-- make a body with the body slot --}}
    {{ $body }}
</div>




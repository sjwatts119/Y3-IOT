{{-- we are making a card component. this is going to be used to store information such as whether the heater is on
    It needs an internal slot for the card contents, and a title slot for the card title.
    It should be 30% width, and have 20px margin on left and right. It should have a height of 175px --}}

{{-- make a card component, we should be able to merge in custom class elements --}}
<div {{ $attributes->merge(['class' => 'w-1/3 m-5 bg-white rounded-lg shadow-lg']) }}>
    {{-- make a header with the title passed in --}}
    <div class="bg-gray-200 px-4 py-2 rounded-t-lg">
        {{ $header }}
    </div>
    {{-- make a body with the body slot --}}
    <div class="p-10">
        {{ $body }}
    </div>
</div>




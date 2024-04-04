<div x-data="{ open: true }" x-show="open" role="alert" {{ $attributes->merge(['class' => 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative']) }}>
    <strong class="font-bold">Warning!</strong>
    <span class="block sm:inline">{{ $warning }}</span>
    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
        <svg @click="open = false" class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1 1 0 0 1-1.497 1.32l-2.851-2.679-2.852 2.68a1 1 0 1 1-1.497-1.32l2.852-2.68-2.852-2.679a1 1 0 1 1 1.497-1.32l2.852 2.68 2.851-2.68a1 1 0 0 1 1.497 1.32l-2.851 2.679 2.851 2.68a1 1 0 0 1 0 1.32z"/></svg>
    </span>
</div>

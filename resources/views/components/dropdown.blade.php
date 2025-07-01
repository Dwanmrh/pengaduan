@props([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-[#C5B358] text-black'
])

@php
    $alignmentClasses = [
        'left' => 'origin-top-left left-0',
        'top' => 'origin-top',
        'right' => 'origin-top-right right-0',
    ][$align];

    $widthClass = [
        '48' => 'w-48',
    ][$width];
@endphp

<div class="relative">
    <div @click.away="open = false" @close.stop="open = false" x-data="{ open: false }" class="relative">
        <div @click="open = ! open">
            {{ $trigger }}
        </div>

        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute z-50 mt-2 {{ $widthClass }} {{ $alignmentClasses }}"
            style="display: none;"
        >
            <div class="rounded-md ring-1 ring-black ring-opacity-5 custom-dropdown">
                {{ $content }}
            </div>
        </div>
    </div>
</div>

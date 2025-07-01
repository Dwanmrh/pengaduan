<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => '
        inline-flex items-center px-4 py-2
        bg-[#C5B358] text-black
        font-semibold text-sm rounded-md shadow
        hover:bg-yellow-600
        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#C5B358]
        transition ease-in-out duration-150
    ']) }}>
    {{ $slot }}
</button>

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'd-inline-flex justify-content-center px-4 py-2 bg-secondary border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>

<button type="submit"
    {{ $attributes->merge(['class' => 'w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500']) }}>
    {{ $slot }}
</button>

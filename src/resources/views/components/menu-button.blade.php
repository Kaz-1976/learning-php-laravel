<a
    {{ $attributes->merge(['class' => 'flex w-full basis-16 m-auto rounded text-lg md:text-2xl text-center font-bold bg-sky-500 dark:bg-sky-300']) }}>
    <span class="m-auto flex">{{ $slot }}</span>
</a>

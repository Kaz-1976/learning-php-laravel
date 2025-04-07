{{--  --}}
@props([
    'loop' => false,
    'flag' => true,
    'type' => '',
])
{{--  --}}
<div
    class="{{ $loop ? 'border-t-2' : '' }} {{ $flag ? ($type === '' ? 'bg-sky-300 dark:bg-sky-800' : 'bg-sky-400 dark:bg-sky-700') : 'bg-sky-200 dark:bg-sky-900' }} flex w-full basis-full flex-col gap-2 border-b-2 border-sky-50 p-4 md:flex-row">
    {{ $slot }}
</div>

@switch($linkType)
    @case('link')
        <a
            {{ $attributes->merge([
                'class' => 'flex p-2 rounded bg-sky-900 dark:bg-sky-100',
                'href' => url($linkTo, null, app()->isProduction()),
            ]) }}>
            <span class="text-md m-auto font-bold text-sky-50 md:text-xl dark:text-sky-950">{{ $slot }}</span>
        </a>
    @break

    @case('form')
        <form
            {{ $attributes->merge([
                'class' => 'flex rounded bg-sky-900 dark:bg-sky-100',
                'method' => 'POST',
                'action' => url($linkTo, null, app()->isProduction()),
            ]) }}>
            @csrf
            <input name="{{ $linkInputName }}" type="hidden" value="{{ $linkInputValue }}">
            <button class="h-full w-full p-2" name="{{ $linkButtonName }}" type="submit">
                <span class="text-md text-center font-bold text-sky-50 md:text-xl dark:text-sky-950">{{ $slot }}</span>
            </button>
        </form>
    @break
@endswitch

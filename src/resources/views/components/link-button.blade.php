@switch($linkType)
    @case('link')
        <a
            {{ $attributes->merge([
                'class' => 'flex p-2 rounded bg-sky-900 dark:bg-sky-100',
                'href' => url($linkTo, null, app()->isProduction()),
            ]) }}>
            <span class="m-auto text-xl font-bold text-sky-50 dark:text-sky-950">{{ $slot }}</span>
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
            <input type="hidden" name="{{ $linkInputName }}" value="{{ $linkInputValue }}">
            <button class="w-full h-full p-2" type="submit" name="{{ $linkButtonName }}">
                <span class="text-center text-xl font-bold text-sky-50 dark:text-sky-950">{{ $slot }}</span>
            </button>
        </form>
    @break
@endswitch

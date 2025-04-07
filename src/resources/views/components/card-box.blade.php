{{--  --}}
@php
    switch ($direction) {
        case 'col':
            $flexDirection = 'flex-col' . ($responsive ? ' md:flex-row' : '');
            break;
        case 'row':
            $flexDirection = 'flex-row' . ($responsive ? ' md:flex-col' : '');
            break;
        case 'col-reverse':
            $flexDirection = 'flex-col-reverse' . ($responsive ? ' md:flex-row-reverse' : '');
            break;
        case 'row-reverse':
            $flexDirection = 'flex-row-reverse' . ($responsive ? ' md:flex-col-reverse' : '');
            break;
        default:
            $flexDirection = '';
    }
@endphp
{{--  --}}
<div {{ $attributes->merge(['class' => 'flex ' . $flexDirection . ' gap-2']) }}>
    {{ $slot }}
</div>

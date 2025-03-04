{{-- 前処理 --}}
@php
    $imageSrc = empty($imageType) ? '' : 'data:' . $imageType . ';base64,' . $imageData;
@endphp
{{-- 画像ボックス表示 --}}
<div {{ $attributes->merge(['class' => 'flex flex-col grow-0 shrink-0 m-auto']) }}>
    <img class="m-auto object-cover" id="{{ $imageId }}" src="{{ $imageSrc }}" alt="{{ $imageAlt }}"
        title="{{ $imageTitle }}" />
</div>

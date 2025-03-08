{{-- 画像ボックス表示 --}}
<div {{ $attributes->merge(['class' => 'flex flex-col grow-0 shrink-0 m-auto']) }}>
    <img class="m-auto object-cover" name="image-box" id="{{ $imageId }}" src="{{ $imageUrl }}"
        alt="{{ $imageAlt }}" title="{{ $imageTitle }}" />
</div>

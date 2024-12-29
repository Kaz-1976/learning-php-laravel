{{-- 前処理 --}}
@php
    $classBorder = $border ? ' border-solid border-2 border-sky-950 dark:border-sky-50' : '';
    $imageSrc = empty($imageType) ? '' : 'data:' . $imageType . ';base64,' . $imageData;
@endphp
{{-- 画像ボックス表示 --}}
<div {{ $attributes->merge(['class' => 'flex flex-col grow-0 shrink-0 m-auto']) }}>
    <div {{ $attributes->merge(['class' => 'flex' . $classBorder]) }}>
        <img class="block w-full h-hull object-cover" id={{ $imageId }} src={{ $imageSrc }}>
    </div>
</div>

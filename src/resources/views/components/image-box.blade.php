{{-- 画像ボックス表示 --}}
<div {{ $attributes->merge(['class' => 'flex flex-col grow-0 shrink-0 m-auto']) }}>
    <img class="m-auto object-cover" name="image-box" id="{{ $imageId }}" src="{{ $imageUrl }}"
        alt="{{ $imageAlt }}" title="{{ $imageTitle }}" />
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 画像ボックス
        const imageBox = document.getElementById('{{ $imageId }}');

        // 画像URL
        const imageUrl = imageBox.src;

        // 保護されたAPIから画像を取得して表示する関数
        const fetchProtectedImage = async (url, box) => {
            try {
                // アクセストークン取得
                const accessToken = localStorage.getItem("apiAccessToken");

                // CSRF対策処理
                common.csrf();

                // APIから画像を取得
                const response = await fetch(url, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                    },
                });

                if (!response.ok) {
                    console.error('Failed to fetch image:', response.statusText);
                    return;
                }

                const blob = await response.blob();
                const imageUrl = URL.createObjectURL(blob);
                box.src = imageUrl;

            } catch (error) {
                console.error('Error fetching image:', error);
            }
        };

        // 初期表示時に保護されたAPIから画像を取得
        if (imageUrl) {
            fetchProtectedImage(imageUrl, imageBox);
        }

        // フォーム関連処理
        const form = imageBox.closest('form');
        if (form) {
            // フォームリセット時の画像クリア処理
            form.addEventListener('reset', (event) => {
                imageBox.src = "{{ $imageUrl }}";
            });

            // ファイルが選択されたときの処理
            const inputFile = form.querySelector('input[type="file"]');
            if (inputFile) {
                inputFile.addEventListener('change', (event) => {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            imageBox.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        imageBox.src = "{{ $imageUrl }}";
                    }
                });
            };
        };

    });
</script>

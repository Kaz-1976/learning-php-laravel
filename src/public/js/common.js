// ------------------------------------------------------------
// 画像表示関数
// ------------------------------------------------------------
const loadImage = (idFile, idImage) => {
    const file = document.getElementById(idFile);
    file.addEventListener("change", (e) => {
        const file = e.target.files[0];
        const reader = new FileReader();
        const image = document.getElementById(idImage);
        reader.addEventListener(
            "load",
            () => {
                image.src = reader.result;
            },
            false
        );
        // ファイルが存在するなら読み込む
        if (file) {
            reader.readAsDataURL(file);
        }
    });
};
// ------------------------------------------------------------
// 商品管理フォームリセット処理
// ------------------------------------------------------------
const productFormReset = (idForm, image) => {
    const form = document.forms[idForm];
    form.addEventListener(
        "reset",
        (e) => {
            const preview = document.getElementById(idForm + "-image-preview");
            if (image == "") {
                preview.removeAttribute("src");
            } else {
                preview.setAttribute("src", image);
            }
        },
        false
    );
};

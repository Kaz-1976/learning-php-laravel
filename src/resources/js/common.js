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
const resetProductForm = (idForm, image) => {
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
// ------------------------------------------------------------
// 住所検索処理
// ------------------------------------------------------------
const getAddress = (event) => {
    // フォームの値を取得
    const form = event.target.closest("form");
    const code = form.querySelector('input[name="zip"]').value;
    //fetchでAPIからJSON文字列を取得する
    fetch("/api/address/" + code)
        .then((data) => data.json())
        .then((obj) => {
            // 取得したデータをフォームにセット
            form.querySelector('select[name="pref"]')
                .querySelector('option[value="' + obj.pref_code + '"]')
                .setAttribute("selected", true);
            form.querySelector('input[name="address1"]').value = obj.area_name;
        });
};

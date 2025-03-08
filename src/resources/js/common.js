// ------------------------------------------------------------
// 画像表示関数
// ------------------------------------------------------------
window.loadProductImage = (event) => {
    const form = event.target.closest("form");
    const file = form.querySelector('input[type="file"]');
    const image = form.querySelector('img[name="image-box"]');
    const reader = new FileReader();
    reader.addEventListener(
        "load",
        () => {
            image.setAttribute("src", reader.result);
        },
        false
    );
    // ファイルが存在するなら読み込む
    if (file.files[0]) {
        reader.readAsDataURL(file.files[0]);
    }
};
// ------------------------------------------------------------
// 商品管理フォームリセット処理
// ------------------------------------------------------------
window.resetProductImage = (event) => {
    const form = event.target.closest("form");
    form.addEventListener(
        "reset",
        (e) => {
            const id = form.querySelector('input[name="id"]');
            const preview = form.querySelector('img[name="image-box"]');
            if (id) {
                preview.setAttribute("src", "/api/product-image/" + id.value);
            } else {
                preview.removeAttribute("src");
            }
        },
        false
    );
};
// ------------------------------------------------------------
// リストボックス初期化処理
// ------------------------------------------------------------
window.initListBox = (event) => {
    // フォームを取得
    const form = event.target.closest("form");
    // フォーム内のリストボックスを取得
    const lists = form.querySelectorAll("select");
    // リストボックスの選択を初期化
    lists.forEach((list) => {
        // リストボックスの初期値を取得
        const value = list.getAttribute("data-default");
        // リストボックス内の選択肢を取得
        const options = list.querySelectorAll("option");
        // リストボックス内の選択を初期化
        options.forEach((option) => {
            if (option.value === value) {
                option.setAttribute("selected", true);
            } else {
                option.removeAttribute("selected");
            }
        });
    });
};
// ------------------------------------------------------------
// 郵便番号情報検索処理
// ------------------------------------------------------------
window.getZipInfo = (event) => {
    // フォームの値を取得
    const form = event.target.closest("form");
    const code = form.querySelector('input[name="zip"]').value;
    // 郵便番号から住所を取得
    fetch("/api/zip/" + code)
        .then((data) => data.json())
        .then((obj) => {
            // 取得したデータをフォームにセット
            form.querySelector('select[name="pref"]')
                .querySelector('option[value="' + obj.pref_code + '"]')
                .setAttribute("selected", true);
            form.querySelector('input[name="address1"]').value = obj.area_name;
        });
};
// ------------------------------------------------------------
// 配送先情報検索処理
// ------------------------------------------------------------
window.getAddressInfo = (event) => {
    // フォームの値を取得
    const form = event.target.closest("form");
    const id = form.querySelector('select[name="id"]').value;
    // 郵便番号から住所を取得
    fetch("/api/address/" + id)
        .then((data) => data.json())
        .then((obj) => {
            // 取得したデータをフォームにセット
            form.querySelector('input[name="zip"]').value = obj.zip;
            form.querySelector('input[name="pref"]').value = obj.ec_prefs.name;
            form.querySelector('input[name="address1"]').value = obj.address1;
            form.querySelector('input[name="address2"]').value = obj.address2;
        });
};

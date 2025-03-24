// インポート定義
import axios from "axios";

// ------------------------------------------------------------
// CSRF対策関数
// ------------------------------------------------------------
export const csrf = async () => {
    await axios.get("/sanctum/csrf-cookie");
};
// ------------------------------------------------------------
// ログアウト処理 for フロントエンド
// ------------------------------------------------------------
export const logout = () => {
    // アクセストークン削除
    localStorage.removeItem("apiAccessToken");
    return true;
};
// ------------------------------------------------------------
// リストボックス初期化処理
// ------------------------------------------------------------
export const initListBox = (event) => {
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
export const getZipInfo = (event) => {
    // フォームの値を取得
    const form = event.target.closest("form");
    const code = form.querySelector('input[name="zip"]').value;
    // アクセストークン取得
    const accessToken = localStorage.getItem("apiAccessToken");
    // CSRF対策処理
    common.csrf();
    // 郵便番号から住所を取得
    axios
        .get("/api/zip/" + code, {
            headers: {
                Authorization: "Bearer " + accessToken,
            },
        })
        .then((response) => response.data)
        .then((obj) => {
            // 取得したデータをフォームにセット
            form.querySelector('select[name="pref"]')
                .querySelector('option[value="' + obj.pref_code + '"]')
                .setAttribute("selected", true);
            form.querySelector('input[name="address1"]').value = obj.area_name;
        })
        .catch((error) => {
            console.log(error);
        });
};
// ------------------------------------------------------------
// 配送先情報検索処理
// ------------------------------------------------------------
export const getAddressInfo = (event, user) => {
    // フォームの値を取得
    const form = event.target.closest("form");
    const id = form.querySelector('select[name="id"]').value;
    // アクセストークン取得
    const accessToken = localStorage.getItem("apiAccessToken");
    // CSRF対策処理
    common.csrf();
    // 郵便番号から住所を取得
    axios
        .get("/api/address/" + user + "/" + id, {
            headers: {
                Authorization: "Bearer " + accessToken,
            },
        })
        .then((response) => response.data)
        .then((obj) => {
            // 取得したデータをフォームにセット
            form.querySelector('input[name="zip"]').value = obj.zip;
            form.querySelector('input[name="pref"]').value = obj.ec_prefs.name;
            form.querySelector('input[name="address1"]').value = obj.address1;
            form.querySelector('input[name="address2"]').value = obj.address2;
        })
        .catch((error) => {
            console.log(error);
        });
};

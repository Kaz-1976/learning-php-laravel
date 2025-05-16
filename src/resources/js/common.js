// インポート定義
import axios from 'axios';

// ------------------------------------------------------------
// CSRF対策関数
// ------------------------------------------------------------
export const csrf = async () => {
    await axios.get('/sanctum/csrf-cookie');
};
// ------------------------------------------------------------
// ログアウト処理 for フロントエンド
// ------------------------------------------------------------
export const logout = () => {
    // アクセストークン削除
    localStorage.removeItem('apiAccessToken');
    return true;
};
// ------------------------------------------------------------
// リストボックス初期化処理
// ------------------------------------------------------------
export const initListBox = event => {
    // フォームを取得
    const form = event.target.closest('form');
    // フォーム内のリストボックスを取得
    const lists = form.querySelectorAll('select');
    // リストボックスの選択を初期化
    lists.forEach(list => {
        // リストボックスの初期値を取得
        const value = list.getAttribute('data-default');
        // リストボックス内の選択肢を取得
        const options = list.querySelectorAll('option');
        // リストボックス内の選択を初期化
        options.forEach(option => {
            if (option.value === value) {
                option.setAttribute('selected', true);
            } else {
                option.removeAttribute('selected');
            }
        });
    });
};
// ------------------------------------------------------------
// 郵便番号情報検索処理
// ------------------------------------------------------------
export const getZipInfo = event => {
    // フォームの値を取得
    const form = event.target.closest('form');
    const code = form.querySelector('input[name="zip"]').value;
    // アクセストークン取得
    const accessToken = localStorage.getItem('apiAccessToken');
    // CSRF対策処理
    common.csrf();
    // 郵便番号から住所を取得
    axios
        .get('/api/zip/' + code, {
            headers: {
                Authorization: 'Bearer ' + accessToken
            }
        })
        .then(response => response.data)
        .then(obj => {
            // 取得したデータをフォームにセット
            form.querySelector('select[name="pref"]')
                .querySelector('option[value="' + obj.pref_code + '"]')
                .setAttribute('selected', true);
            form.querySelector('input[name="address1"]').value = obj.area_name;
        })
        .catch(error => {
            console.log(error);
        });
};
// ------------------------------------------------------------
// 配送先情報フォーム設定処理
// ------------------------------------------------------------
export const setShippingForm = event => {
    // 変数定義
    let div;
    let innerDiv;
    let outerDiv;
    // フォームの値を取得
    const form = event.target.closest('form');
    const id = form.querySelector('select[name="id"]').value;
    // フォーム設定
    switch (id) {
        case '0':
            // フォーム設定：配送先名
            innerDiv = form.querySelector('input[name="name"]').parentElement.closest('div');
            outerDiv = innerDiv.parentElement ? innerDiv.parentElement.closest('div') : null;
            outerDiv.classList.remove('hidden');
            outerDiv.classList.add('flex');
            form.querySelector('input[name="name"]').value = '';
            form.querySelector('input[name="name"]').removeAttribute('disabled');
            form.querySelector('input[name="name"]').removeAttribute('readonly');
            // フォーム設定：郵便番号
            form.querySelector('input[name="zip"]').closest('div').style.display = 'flex';
            form.querySelector('input[name="zip"]').closest('div').setAttribute('width', '30%');
            form.querySelector('input[name="zip"]').value = '';
            form.querySelector('input[name="zip"]').removeAttribute('disabled');
            form.querySelector('input[name="zip"]').removeAttribute('readonly');
            // フォーム設定：住所検索ボタン
            div = form.querySelector('button[name="search"]').parentElement.closest('div');
            div.classList.remove('hidden');
            div.classList.add('flex');
            // フォーム設定：都道府県（表示）
            form.querySelector('input[name="pref"]').classList.remove('flex');
            form.querySelector('input[name="pref"]').classList.add('hidden');
            form.querySelector('input[name="pref"]').value = '';
            form.querySelector('input[name="pref"]').removeAttribute('disabled');
            form.querySelector('input[name="pref"]').removeAttribute('readonly');
            // フォーム設定：都道府県（リスト）
            form.querySelector('select[name="pref"]').classList.remove('hidden');
            form.querySelector('select[name="pref"]').classList.add('flex');
            form.querySelector('select[name="pref"]').removeAttribute('disabled');
            form.querySelector('select[name="pref"]').removeAttribute('readonly');
            // フォーム設定：住所１
            form.querySelector('input[name="address1"]').value = '';
            form.querySelector('input[name="address1"]').removeAttribute('disabled');
            form.querySelector('input[name="address1"]').removeAttribute('readonly');
            // フォーム設定：住所２
            form.querySelector('input[name="address2"]').value = '';
            form.querySelector('input[name="address2"]').removeAttribute('disabled');
            form.querySelector('input[name="address2"]').removeAttribute('readonly');
            break;
        default:
            // フォーム設定：配送先名
            innerDiv = form.querySelector('input[name="name"]').parentElement.closest('div');
            outerDiv = innerDiv.parentElement ? innerDiv.parentElement.closest('div') : null;
            outerDiv.classList.remove('flex');
            outerDiv.classList.add('hidden');
            form.querySelector('input[name="name"]').setAttribute('disabled', true);
            form.querySelector('input[name="name"]').setAttribute('readonly', true);
            // フォーム設定：郵便番号
            form.querySelector('input[name="zip"]').setAttribute('disabled', true);
            form.querySelector('input[name="zip"]').setAttribute('readonly', true);
            form.querySelector('input[name="zip"]').setAttribute('width', '100%');
            // フォーム設定：住所検索ボタン
            div = form.querySelector('button[name="search"]').parentElement.closest('div');
            div.classList.remove('flex');
            div.classList.add('hidden');
            // フォーム設定：都道府県（表示）
            form.querySelector('input[name="pref"]').classList.remove('hidden');
            form.querySelector('input[name="pref"]').classList.add('flex');
            form.querySelector('input[name="pref"]').setAttribute('disabled', true);
            form.querySelector('input[name="pref"]').setAttribute('readonly', true);
            // フォーム設定：都道府県（リスト）
            form.querySelector('select[name="pref"]').classList.remove('flex');
            form.querySelector('select[name="pref"]').classList.add('hidden');
            form.querySelector('select[name="pref"]').setAttribute('disabled', true);
            form.querySelector('select[name="pref"]').setAttribute('readonly', true);
            // フォーム設定：住所１
            form.querySelector('input[name="address1"]').setAttribute('disabled', true);
            form.querySelector('input[name="address1"]').setAttribute('readonly', true);
            // フォーム設定：住所２
            form.querySelector('input[name="address2"]').setAttribute('disabled', true);
            form.querySelector('input[name="address2"]').setAttribute('readonly', true);
            break;
    }
};

// ------------------------------------------------------------
// 配送先情報検索処理
// ------------------------------------------------------------
export const getAddressInfo = (event, user) => {
    // フォームの値を取得
    const form = event.target.closest('form');
    const id = form.querySelector('select[name="id"]').value;
    // 新規作成のときはリターン
    if (id === '0') {
        return;
    }
    // アクセストークン取得
    const accessToken = localStorage.getItem('apiAccessToken');
    // CSRF対策処理
    common.csrf();
    // 郵便番号から住所を取得
    axios
        .get('/api/address/' + user + '/' + id, {
            headers: {
                Authorization: 'Bearer ' + accessToken
            }
        })
        .then(response => response.data)
        .then(obj => {
            // 取得したデータをフォームにセット
            form.querySelector('input[name="name"]').value = obj.name;
            form.querySelector('input[name="zip"]').value = obj.zip;
            form.querySelector('input[name="pref"]').value = obj.ec_prefs.name;
            form.querySelector('input[name="address1"]').value = obj.address1;
            form.querySelector('input[name="address2"]').value = obj.address2;
        })
        .catch(error => {
            console.log(error);
        });
};

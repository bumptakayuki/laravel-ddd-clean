import axios from 'axios';

const api = axios.create({
    baseURL: '/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    },
});

// CSRFトークンの設定
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    api.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

/**
 * 購入を確定する
 * @param {string} orderId - 注文ID
 * @returns {Promise} 購入確定結果
 */
export const confirmPurchase = async (orderId) => {
    const response = await api.post('/purchases/confirm', {
        order_id: orderId,
    });
    return response.data;
};

/**
 * 購入情報を取得する
 * @param {string} purchaseId - 購入ID
 * @returns {Promise} 購入情報
 */
export const getPurchase = async (purchaseId) => {
    const response = await api.get(`/purchases/${purchaseId}`);
    return response.data;
};

/**
 * 購入一覧を取得する
 * @param {string} memberId - 会員ID
 * @returns {Promise} 購入一覧
 */
export const getPurchases = async (memberId) => {
    const response = await api.get('/purchases', {
        params: { member_id: memberId },
    });
    return response.data;
};



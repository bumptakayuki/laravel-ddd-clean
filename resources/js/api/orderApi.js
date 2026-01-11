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
 * 注文一覧を取得する
 * @param {string} memberId - 会員ID
 * @returns {Promise} 注文一覧
 */
export const getOrders = async (memberId) => {
    const response = await api.get('/orders', {
        params: { member_id: memberId },
    });
    return response.data;
};

/**
 * 注文を作成する
 * @param {Object} orderData - 注文データ
 * @param {string} orderData.member_id - 会員ID
 * @param {string} orderData.store_id - 店舗ID
 * @param {Array} orderData.items - 注文明細
 * @returns {Promise} 作成された注文
 */
export const createOrder = async (orderData) => {
    const response = await api.post('/orders', orderData);
    return response.data;
};

/**
 * 決済を実行する
 * @param {string} orderId - 注文ID
 * @param {Object} paymentData - 決済データ
 * @param {string} paymentData.method - 決済手段
 * @param {string|null} paymentData.transaction_id - 取引ID
 * @returns {Promise} 決済結果
 */
export const createPayment = async (orderId, paymentData) => {
    const response = await api.post(`/orders/${orderId}/payment`, paymentData);
    return response.data;
};

/**
 * 注文を受注する
 * @param {string} orderId - 注文ID
 * @returns {Promise} 受注結果
 */
export const createAcceptance = async (orderId) => {
    const response = await api.post(`/orders/${orderId}/acceptance`);
    return response.data;
};

/**
 * 購入を確定する
 * @param {string} orderId - 注文ID
 * @returns {Promise} 購入確定結果
 */
export const createPurchase = async (orderId) => {
    const response = await api.post(`/orders/${orderId}/purchase`);
    return response.data;
};


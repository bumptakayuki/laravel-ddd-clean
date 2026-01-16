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
 * エリア一覧を取得する
 * @returns {Promise} エリア一覧
 */
export const getAreas = async () => {
    const response = await api.get('/areas');
    return response.data;
};

/**
 * エリアの詳細を取得する
 * @param {string} areaId - エリアID
 * @returns {Promise} エリア詳細
 */
export const getArea = async (areaId) => {
    const response = await api.get(`/areas/${areaId}`);
    return response.data;
};



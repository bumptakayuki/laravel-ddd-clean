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
 * 店舗のBox Lunch一覧を取得する
 * @param {string} storeId - 店舗ID
 * @returns {Promise} Box Lunch一覧
 */
export const getBoxLunches = async (storeId) => {
    const response = await api.get('/box-lunches', {
        params: { store_id: storeId },
    });
    return response.data;
};

/**
 * Box Lunchの詳細を取得する（オプション含む）
 * @param {string} boxLunchId - 弁当ID
 * @returns {Promise} Box Lunch詳細
 */
export const getBoxLunchDetail = async (boxLunchId) => {
    const response = await api.get(`/box-lunches/${boxLunchId}`);
    return response.data;
};

/**
 * Box Lunch構成を作成する
 * @param {Object} configurationData - 構成データ
 * @param {string} configurationData.box_lunch_id - 弁当ID
 * @param {string} configurationData.availability_status - 提供可否状態
 * @param {Array} configurationData.selections - オプション選択
 * @returns {Promise} 作成された構成
 */
export const createBoxLunchConfiguration = async (configurationData) => {
    const response = await api.post('/box-lunches/configuration', configurationData);
    return response.data;
};



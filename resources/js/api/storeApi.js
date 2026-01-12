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
 * 店舗一覧を取得する
 * @returns {Promise} 店舗一覧
 */
export const getStores = async () => {
    const response = await api.get('/stores');
    return response.data;
};

/**
 * 店舗詳細を取得する
 * @param {string} storeId - 店舗ID
 * @returns {Promise} 店舗詳細
 */
export const getStore = async (storeId) => {
    const response = await api.get(`/stores/${storeId}`);
    return response.data;
};

/**
 * 店舗を作成する
 * @param {Object} storeData - 店舗データ
 * @param {string} storeData.name - 店舗名
 * @param {string} storeData.address - 住所
 * @param {boolean} storeData.is_open - 営業中フラグ
 * @returns {Promise} 作成された店舗
 */
export const createStore = async (storeData) => {
    const response = await api.post('/stores', storeData);
    return response.data;
};

/**
 * 店舗を更新する
 * @param {string} storeId - 店舗ID
 * @param {Object} storeData - 店舗データ
 * @param {string|null} storeData.name - 店舗名
 * @param {string|null} storeData.address - 住所
 * @param {boolean|null} storeData.is_open - 営業中フラグ
 * @returns {Promise} 更新された店舗
 */
export const updateStore = async (storeId, storeData) => {
    const response = await api.put(`/stores/${storeId}`, storeData);
    return response.data;
};

/**
 * 店舗の弁当提供情報を作成する
 * @param {string} storeId - 店舗ID
 * @param {Object} storeBoxLunchData - 店舗弁当データ
 * @param {string} storeBoxLunchData.box_lunch_id - 弁当ID
 * @param {boolean} storeBoxLunchData.is_available - 提供可フラグ
 * @returns {Promise} 作成された店舗弁当情報
 */
export const createStoreBoxLunch = async (storeId, storeBoxLunchData) => {
    const response = await api.post(`/stores/${storeId}/store-box-lunch`, storeBoxLunchData);
    return response.data;
};

/**
 * 店舗の弁当提供情報を更新する
 * @param {string} storeId - 店舗ID
 * @param {string} boxLunchId - 弁当ID
 * @param {Object} storeBoxLunchData - 店舗弁当データ
 * @param {boolean} storeBoxLunchData.is_available - 提供可フラグ
 * @returns {Promise} 更新された店舗弁当情報
 */
export const updateStoreBoxLunch = async (storeId, boxLunchId, storeBoxLunchData) => {
    const response = await api.put(`/stores/${storeId}/store-box-lunch/${boxLunchId}`, storeBoxLunchData);
    return response.data;
};

/**
 * 店舗の配達可能エリア情報を作成する
 * @param {string} storeId - 店舗ID
 * @param {Object} storeAreaData - 店舗エリアデータ
 * @param {string} storeAreaData.area_id - エリアID
 * @param {boolean} storeAreaData.is_deliverable - 配達可フラグ
 * @returns {Promise} 作成された店舗エリア情報
 */
export const createStoreArea = async (storeId, storeAreaData) => {
    const response = await api.post(`/stores/${storeId}/store-area`, storeAreaData);
    return response.data;
};

/**
 * 店舗の配達可能エリア情報を更新する
 * @param {string} storeId - 店舗ID
 * @param {string} areaId - エリアID
 * @param {Object} storeAreaData - 店舗エリアデータ
 * @param {boolean} storeAreaData.is_deliverable - 配達可フラグ
 * @returns {Promise} 更新された店舗エリア情報
 */
export const updateStoreArea = async (storeId, areaId, storeAreaData) => {
    const response = await api.put(`/stores/${storeId}/store-area/${areaId}`, storeAreaData);
    return response.data;
};


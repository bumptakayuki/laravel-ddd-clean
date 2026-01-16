<template>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">店舗一覧</h1>
            <p class="text-gray-600 mt-2">登録されている店舗を確認できます</p>
        </div>

        <div v-if="loading" class="text-center py-8">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <p class="text-gray-600 mt-4">読み込み中...</p>
        </div>

        <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            <p>{{ error }}</p>
        </div>

        <div v-else-if="stores.length === 0" class="text-center py-8">
            <p class="text-gray-600">店舗が見つかりませんでした</p>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                v-for="store in stores"
                :key="store.store_id"
                class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow cursor-pointer"
                @click="goToStoreDetail(store.store_id)"
            >
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">
                                    {{ store.name }}
                                </h2>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ store.address }}
                                </p>
                            </div>
                        </div>
                        <span
                            :class="store.is_open ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                            class="px-3 py-1 rounded-full text-xs font-medium"
                        >
                            {{ store.is_open ? '営業中' : '閉店中' }}
                        </span>
                    </div>

                    <div class="flex items-center text-sm text-gray-600 mt-4">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>店舗ID: {{ store.store_id }}</span>
                    </div>

                    <div class="mt-4 pt-4 border-t">
                        <button class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
                            詳細を見る
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { getStores } from '../api/storeApi';

export default {
    name: 'StoreList',
    data() {
        return {
            stores: [],
            loading: false,
            error: null,
        };
    },
    mounted() {
        this.fetchStores();
    },
    methods: {
        async fetchStores() {
            this.loading = true;
            this.error = null;
            try {
                this.stores = await getStores();
            } catch (err) {
                this.error = err.response?.data?.message || '店舗一覧の取得に失敗しました';
                console.error('Error fetching stores:', err);
                this.stores = [];
            } finally {
                this.loading = false;
            }
        },
        goToStoreDetail(storeId) {
            this.$emit('store-selected', storeId);
        },
    },
};
</script>



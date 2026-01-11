<template>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">弁当一覧</h1>
        </div>

        <!-- 店舗ID入力フォーム -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex gap-4 items-end">
                <div class="flex-1">
                    <label for="storeId" class="block text-sm font-medium text-gray-700 mb-2">
                        店舗ID
                    </label>
                    <input
                        id="storeId"
                        v-model="storeId"
                        type="text"
                        placeholder="例: store-001"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        @keyup.enter="fetchBoxLunches"
                    />
                </div>
                <button
                    @click="fetchBoxLunches"
                    :disabled="loading || !storeId"
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors"
                >
                    検索
                </button>
            </div>
        </div>

        <div v-if="loading" class="text-center py-8">
            <p class="text-gray-600">読み込み中...</p>
        </div>

        <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            <p>{{ error }}</p>
        </div>

        <div v-else-if="boxLunches.length === 0 && storeId" class="text-center py-8">
            <p class="text-gray-600">該当する弁当が見つかりませんでした</p>
        </div>

        <div v-else-if="!storeId" class="text-center py-8">
            <p class="text-gray-600">店舗IDを入力して検索してください</p>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                v-for="boxLunch in boxLunches"
                :key="boxLunch.box_lunch_id"
                class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow cursor-pointer"
                @click="goToBoxLunchDetail(boxLunch.box_lunch_id)"
            >
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-xl font-semibold text-gray-900">
                            {{ boxLunch.name }}
                        </h2>
                        <span
                            v-if="boxLunch.is_active"
                            class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium"
                        >
                            販売中
                        </span>
                        <span
                            v-else
                            class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium"
                        >
                            販売停止
                        </span>
                    </div>

                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                        {{ boxLunch.description || '説明なし' }}
                    </p>

                    <div class="flex justify-between items-center pt-4 border-t">
                        <span class="text-gray-600">基本価格:</span>
                        <span class="text-2xl font-bold text-gray-900">
                            ¥{{ formatPrice(boxLunch.base_price) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { getBoxLunches } from '../api/boxLunchApi';

export default {
    name: 'BoxLunchList',
    data() {
        return {
            boxLunches: [],
            loading: false,
            error: null,
            storeId: 'store-001', // デフォルト値
        };
    },
    mounted() {
        // デフォルトで店舗IDが設定されている場合は自動検索
        if (this.storeId) {
            this.fetchBoxLunches();
        }
    },
    methods: {
        async fetchBoxLunches() {
            if (!this.storeId) {
                this.error = '店舗IDを入力してください';
                return;
            }

            this.loading = true;
            this.error = null;
            try {
                this.boxLunches = await getBoxLunches(this.storeId);
            } catch (err) {
                this.error = err.response?.data?.message || '弁当一覧の取得に失敗しました';
                console.error('Error fetching box lunches:', err);
                this.boxLunches = [];
            } finally {
                this.loading = false;
            }
        },
        goToBoxLunchDetail(boxLunchId) {
            this.$emit('box-lunch-selected', boxLunchId);
        },
        formatPrice(price) {
            return Number(price).toLocaleString('ja-JP');
        },
    },
};
</script>


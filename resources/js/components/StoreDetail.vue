<template>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <button
                @click="$emit('back')"
                class="flex items-center text-gray-600 hover:text-gray-900 mb-4 transition-colors"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                一覧に戻る
            </button>
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">店舗詳細</h1>
                <button
                    @click="$emit('edit')"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors"
                >
                    編集
                </button>
            </div>
        </div>

        <div v-if="loading" class="text-center py-8">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <p class="text-gray-600 mt-4">読み込み中...</p>
        </div>

        <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            <p>{{ error }}</p>
        </div>

        <div v-else-if="!store" class="text-center py-8">
            <p class="text-gray-600">店舗が見つかりませんでした</p>
        </div>

        <div v-else class="space-y-6">
            <!-- 店舗基本情報 -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mr-6">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ store.name }}</h2>
                            <span
                                :class="store.is_open ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                class="px-3 py-1 rounded-full text-sm font-medium"
                            >
                                {{ store.is_open ? '営業中' : '閉店中' }}
                            </span>
                        </div>
                    </div>

                    <div class="border-t pt-6 mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">店舗情報</h3>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">店舗ID</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ store.store_id }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">店舗名</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ store.name }}</dd>
                            </div>
                            <div class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">住所</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ store.address }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">営業状態</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span
                                        :class="store.is_open ? 'text-green-600' : 'text-red-600'"
                                        class="font-medium"
                                    >
                                        {{ store.is_open ? '営業中' : '閉店中' }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- 提供可能な弁当 -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">提供可能な弁当</h3>
                    <div v-if="store.store_box_lunches && store.store_box_lunches.length > 0" class="space-y-2">
                        <div
                            v-for="storeBoxLunch in store.store_box_lunches"
                            :key="storeBoxLunch.box_lunch_id"
                            class="flex items-center justify-between p-4 bg-gray-50 rounded-md"
                        >
                            <div>
                                <span class="font-medium text-gray-900">弁当ID: {{ storeBoxLunch.box_lunch_id }}</span>
                            </div>
                            <span
                                :class="storeBoxLunch.is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                class="px-3 py-1 rounded-full text-xs font-medium"
                            >
                                {{ storeBoxLunch.is_available ? '提供可能' : '提供不可' }}
                            </span>
                        </div>
                    </div>
                    <div v-else class="text-center py-4 text-gray-500">
                        提供可能な弁当がありません
                    </div>
                </div>
            </div>

            <!-- 配達可能エリア -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">配達可能エリア</h3>
                    <div v-if="store.store_areas && store.store_areas.length > 0" class="space-y-2">
                        <div
                            v-for="storeArea in store.store_areas"
                            :key="storeArea.area_id"
                            class="flex items-center justify-between p-4 bg-gray-50 rounded-md"
                        >
                            <div>
                                <span class="font-medium text-gray-900">エリアID: {{ storeArea.area_id }}</span>
                            </div>
                            <span
                                :class="storeArea.is_deliverable ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                class="px-3 py-1 rounded-full text-xs font-medium"
                            >
                                {{ storeArea.is_deliverable ? '配達可能' : '配達不可' }}
                            </span>
                        </div>
                    </div>
                    <div v-else class="text-center py-4 text-gray-500">
                        配達可能エリアがありません
                    </div>
                </div>
            </div>

            <div class="flex space-x-4">
                <button
                    @click="$emit('back')"
                    class="px-6 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors"
                >
                    一覧に戻る
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { getStore } from '../api/storeApi';

export default {
    name: 'StoreDetail',
    props: {
        storeId: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            store: null,
            loading: false,
            error: null,
        };
    },
    watch: {
        storeId: {
            immediate: true,
            handler() {
                this.fetchStore();
            },
        },
    },
    methods: {
        async fetchStore() {
            if (!this.storeId) {
                return;
            }

            this.loading = true;
            this.error = null;
            try {
                this.store = await getStore(this.storeId);
            } catch (err) {
                this.error = err.response?.data?.message || '店舗詳細の取得に失敗しました';
                console.error('Error fetching store:', err);
                this.store = null;
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>



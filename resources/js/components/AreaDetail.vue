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
            <h1 class="text-3xl font-bold text-gray-900">エリア詳細</h1>
        </div>

        <div v-if="loading" class="text-center py-8">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <p class="text-gray-600 mt-4">読み込み中...</p>
        </div>

        <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            <p>{{ error }}</p>
        </div>

        <div v-else-if="!area" class="text-center py-8">
            <p class="text-gray-600">エリアが見つかりませんでした</p>
        </div>

        <div v-else class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-8">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mr-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ area.name }}</h2>
                        <p class="text-gray-600">エリアID: {{ area.area_id }}</p>
                    </div>
                </div>

                <div class="border-t pt-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">エリア情報</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">エリアID</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ area.area_id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">エリア名</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ area.name }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="mt-8 flex space-x-4">
                    <button
                        @click="$emit('back')"
                        class="px-6 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors"
                    >
                        一覧に戻る
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { getArea } from '../api/areaApi';

export default {
    name: 'AreaDetail',
    props: {
        areaId: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            area: null,
            loading: false,
            error: null,
        };
    },
    watch: {
        areaId: {
            immediate: true,
            handler() {
                this.fetchArea();
            },
        },
    },
    methods: {
        async fetchArea() {
            if (!this.areaId) {
                return;
            }

            this.loading = true;
            this.error = null;
            try {
                this.area = await getArea(this.areaId);
            } catch (err) {
                this.error = err.response?.data?.message || 'エリア詳細の取得に失敗しました';
                console.error('Error fetching area:', err);
                this.area = null;
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>



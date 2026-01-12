<template>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">エリア一覧</h1>
            <p class="text-gray-600 mt-2">配達可能なエリアを確認できます</p>
        </div>

        <div v-if="loading" class="text-center py-8">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <p class="text-gray-600 mt-4">読み込み中...</p>
        </div>

        <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            <p>{{ error }}</p>
        </div>

        <div v-else-if="areas.length === 0" class="text-center py-8">
            <p class="text-gray-600">エリアが見つかりませんでした</p>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                v-for="area in areas"
                :key="area.area_id"
                class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow cursor-pointer"
                @click="goToAreaDetail(area.area_id)"
            >
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-900">
                                {{ area.name }}
                            </h2>
                        </div>
                    </div>

                    <div class="flex items-center text-sm text-gray-600 mt-4">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>エリアID: {{ area.area_id }}</span>
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
import { getAreas } from '../api/areaApi';

export default {
    name: 'AreaList',
    data() {
        return {
            areas: [],
            loading: false,
            error: null,
        };
    },
    mounted() {
        this.fetchAreas();
    },
    methods: {
        async fetchAreas() {
            this.loading = true;
            this.error = null;
            try {
                this.areas = await getAreas();
            } catch (err) {
                this.error = err.response?.data?.message || 'エリア一覧の取得に失敗しました';
                console.error('Error fetching areas:', err);
                this.areas = [];
            } finally {
                this.loading = false;
            }
        },
        goToAreaDetail(areaId) {
            this.$emit('area-selected', areaId);
        },
    },
};
</script>


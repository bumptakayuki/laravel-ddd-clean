<template>
    <div class="min-h-screen bg-gray-50">
        <nav class="bg-white shadow-md">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center h-16">
                    <h1 class="text-xl font-bold text-gray-900">エリア管理システム</h1>
                    <div class="flex space-x-4">
                        <button
                            @click="currentView = 'list'"
                            :class="currentView === 'list' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-gray-900'"
                            class="px-4 py-2 font-medium transition-colors"
                        >
                            エリア一覧
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <AreaList
                v-if="currentView === 'list'"
                @area-selected="handleAreaSelected"
            />
            <AreaDetail
                v-else-if="currentView === 'detail'"
                :area-id="selectedAreaId"
                @back="currentView = 'list'"
            />
        </main>
    </div>
</template>

<script>
import AreaList from './AreaList.vue';
import AreaDetail from './AreaDetail.vue';

export default {
    name: 'AreaApp',
    components: {
        AreaList,
        AreaDetail,
    },
    data() {
        return {
            currentView: 'list',
            selectedAreaId: null,
        };
    },
    methods: {
        handleAreaSelected(areaId) {
            this.selectedAreaId = areaId;
            this.currentView = 'detail';
        },
    },
};
</script>



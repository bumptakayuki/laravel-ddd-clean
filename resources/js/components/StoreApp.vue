<template>
    <div class="min-h-screen bg-gray-50">
        <nav class="bg-white shadow-md">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center h-16">
                    <h1 class="text-xl font-bold text-gray-900">店舗管理システム</h1>
                    <div class="flex space-x-4">
                        <button
                            @click="currentView = 'list'"
                            :class="currentView === 'list' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-gray-900'"
                            class="px-4 py-2 font-medium transition-colors"
                        >
                            店舗一覧
                        </button>
                        <button
                            @click="currentView = 'create'"
                            :class="currentView === 'create' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-gray-900'"
                            class="px-4 py-2 font-medium transition-colors"
                        >
                            店舗作成
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <StoreList
                v-if="currentView === 'list'"
                @store-selected="handleStoreSelected"
            />
            <StoreCreate
                v-else-if="currentView === 'create'"
                @store-created="handleStoreCreated"
                @cancel="currentView = 'list'"
            />
            <StoreDetail
                v-else-if="currentView === 'detail'"
                :store-id="selectedStoreId"
                @back="currentView = 'list'"
                @store-updated="handleStoreUpdated"
                @edit="handleEdit"
            />
            <StoreEdit
                v-else-if="currentView === 'edit'"
                :store-id="selectedStoreId"
                @store-updated="handleStoreUpdated"
                @cancel="currentView = 'detail'"
            />
        </main>
    </div>
</template>

<script>
import StoreList from './StoreList.vue';
import StoreCreate from './StoreCreate.vue';
import StoreDetail from './StoreDetail.vue';
import StoreEdit from './StoreEdit.vue';

export default {
    name: 'StoreApp',
    components: {
        StoreList,
        StoreCreate,
        StoreDetail,
        StoreEdit,
    },
    data() {
        return {
            currentView: 'list',
            selectedStoreId: null,
        };
    },
    methods: {
        handleStoreSelected(storeId) {
            this.selectedStoreId = storeId;
            this.currentView = 'detail';
        },
        handleStoreCreated(storeId) {
            this.selectedStoreId = storeId;
            this.currentView = 'detail';
        },
        handleStoreUpdated() {
            // 店舗が更新された場合の処理
            if (this.currentView === 'edit') {
                this.currentView = 'detail';
            }
        },
        handleEdit() {
            this.currentView = 'edit';
        },
    },
};
</script>



<template>
    <div class="min-h-screen bg-gray-50">
        <nav class="bg-white shadow-md">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center h-16">
                    <h1 class="text-xl font-bold text-gray-900">購入管理システム</h1>
                    <div class="flex space-x-4">
                        <button
                            @click="currentView = 'list'"
                            :class="currentView === 'list' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-gray-900'"
                            class="px-4 py-2 font-medium transition-colors"
                        >
                            購入一覧
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <PurchaseList
                v-if="currentView === 'list'"
                @purchase-selected="handlePurchaseSelected"
            />
            <PurchaseDetail
                v-else-if="currentView === 'detail'"
                :purchase-id="selectedPurchaseId"
                @back="currentView = 'list'"
            />
        </main>
    </div>
</template>

<script>
import PurchaseList from './PurchaseList.vue';
import PurchaseDetail from './PurchaseDetail.vue';

export default {
    name: 'PurchaseApp',
    components: {
        PurchaseList,
        PurchaseDetail,
    },
    data() {
        return {
            currentView: 'list',
            selectedPurchaseId: null,
        };
    },
    methods: {
        handlePurchaseSelected(purchaseId) {
            this.selectedPurchaseId = purchaseId;
            this.currentView = 'detail';
        },
    },
};
</script>


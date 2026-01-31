<template>
    <div class="min-h-screen bg-gray-50">
        <nav class="bg-white shadow-md">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center h-16">
                    <h1 class="text-xl font-bold text-gray-900">弁当注文システム</h1>
                    <div class="flex space-x-4">
                        <button
                            @click="currentView = 'list'"
                            :class="currentView === 'list' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-gray-900'"
                            class="px-4 py-2 font-medium transition-colors"
                        >
                            注文一覧
                        </button>
                        <button
                            @click="currentView = 'create'"
                            :class="currentView === 'create' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-gray-900'"
                            class="px-4 py-2 font-medium transition-colors"
                        >
                            注文作成
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <OrderList
                v-if="currentView === 'list'"
                @order-selected="handleOrderSelected"
            />
            <OrderCreate
                v-else-if="currentView === 'create'"
                @order-created="handleOrderCreated"
            />
            <OrderDetail
                v-else-if="currentView === 'detail'"
                :order-id="selectedOrderId"
                @back="currentView = 'list'"
                @order-updated="handleOrderUpdated"
            />
        </main>
    </div>
</template>

<script>
import OrderList from './OrderList.vue';
import OrderCreate from './OrderCreate.vue';
import OrderDetail from './OrderDetail.vue';

export default {
    name: 'OrderApp',
    components: {
        OrderList,
        OrderCreate,
        OrderDetail,
    },
    data() {
        return {
            currentView: 'list',
            selectedOrderId: null,
        };
    },
    methods: {
        handleOrderSelected(orderId) {
            this.selectedOrderId = orderId;
            this.currentView = 'detail';
        },
        handleOrderCreated(orderId) {
            this.selectedOrderId = orderId;
            this.currentView = 'detail';
        },
        handleOrderUpdated() {
            // 注文が更新された場合の処理
            // 必要に応じて一覧を再読み込みする
        },
    },
};
</script>




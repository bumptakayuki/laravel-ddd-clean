<template>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">注文一覧</h1>
        </div>

        <div v-if="loading" class="text-center py-8">
            <p class="text-gray-600">読み込み中...</p>
        </div>

        <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            <p>{{ error }}</p>
        </div>

        <div v-else-if="orders.length === 0" class="text-center py-8">
            <p class="text-gray-600">注文履歴がありません</p>
        </div>

        <div v-else class="space-y-4">
            <div
                v-for="order in orders"
                :key="order.order_id"
                class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow cursor-pointer"
                @click="goToOrderDetail(order.order_id)"
            >
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">
                            注文ID: {{ order.order_id }}
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            注文日時: {{ formatDateTime(order.ordered_at) }}
                        </p>
                    </div>
                    <span
                        :class="getStatusClass(order.status)"
                        class="px-3 py-1 rounded-full text-sm font-medium"
                    >
                        {{ getStatusLabel(order.status) }}
                    </span>
                </div>

                <div class="border-t pt-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-600">店舗ID:</span>
                        <span class="font-medium">{{ order.store_id }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-600">明細数:</span>
                        <span class="font-medium">{{ order.items.length }}件</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">合計金額:</span>
                        <span class="text-2xl font-bold text-gray-900">
                            ¥{{ formatPrice(order.total_amount) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { getOrders } from '../api/orderApi';

export default {
    name: 'OrderList',
    data() {
        return {
            orders: [],
            loading: false,
            error: null,
            memberId: 'member-001', // TODO: 実際の認証から取得
        };
    },
    mounted() {
        this.fetchOrders();
    },
    methods: {
        async fetchOrders() {
            this.loading = true;
            this.error = null;
            try {
                this.orders = await getOrders(this.memberId);
            } catch (err) {
                this.error = err.response?.data?.message || '注文一覧の取得に失敗しました';
                console.error('Error fetching orders:', err);
            } finally {
                this.loading = false;
            }
        },
        goToOrderDetail(orderId) {
            // ルーティングを使用する場合は this.$router.push(`/orders/${orderId}`)
            // ここでは親コンポーネントにイベントを発火
            this.$emit('order-selected', orderId);
        },
        formatDateTime(dateTime) {
            if (!dateTime) return '-';
            const date = new Date(dateTime);
            return date.toLocaleString('ja-JP', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
            });
        },
        formatPrice(price) {
            return Number(price).toLocaleString('ja-JP');
        },
        getStatusLabel(status) {
            const statusMap = {
                'pending': '未決済',
                'paid': '決済済み',
                'accepted': '受注済み',
                'purchased': '購入確定',
                'cancelled': 'キャンセル',
            };
            return statusMap[status] || status;
        },
        getStatusClass(status) {
            const classMap = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'paid': 'bg-blue-100 text-blue-800',
                'accepted': 'bg-green-100 text-green-800',
                'purchased': 'bg-purple-100 text-purple-800',
                'cancelled': 'bg-red-100 text-red-800',
            };
            return classMap[status] || 'bg-gray-100 text-gray-800';
        },
    },
};
</script>


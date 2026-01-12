<template>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">購入一覧</h1>
        </div>

        <div v-if="loading" class="text-center py-8">
            <p class="text-gray-600">読み込み中...</p>
        </div>

        <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            <p>{{ error }}</p>
        </div>

        <div v-else-if="purchases.length === 0" class="text-center py-8">
            <p class="text-gray-600">購入履歴がありません</p>
        </div>

        <div v-else class="space-y-4">
            <div
                v-for="purchase in purchases"
                :key="purchase.purchaseId"
                class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow cursor-pointer"
                @click="goToPurchaseDetail(purchase.purchaseId)"
            >
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">
                            購入ID: {{ purchase.purchaseId }}
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            確定日時: {{ formatDateTime(purchase.confirmedAt) }}
                        </p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                        購入確定済み
                    </span>
                </div>

                <div class="border-t pt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">注文ID:</span>
                        <span class="font-medium">{{ purchase.orderId }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { getPurchases } from '../api/purchaseApi';

export default {
    name: 'PurchaseList',
    data() {
        return {
            purchases: [],
            loading: false,
            error: null,
            memberId: 'member-001', // TODO: 実際の認証から取得
        };
    },
    mounted() {
        this.fetchPurchases();
    },
    methods: {
        async fetchPurchases() {
            this.loading = true;
            this.error = null;
            try {
                this.purchases = await getPurchases(this.memberId);
            } catch (err) {
                this.error = err.response?.data?.message || '購入一覧の取得に失敗しました';
                console.error('Error fetching purchases:', err);
            } finally {
                this.loading = false;
            }
        },
        goToPurchaseDetail(purchaseId) {
            this.$emit('purchase-selected', purchaseId);
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
    },
};
</script>


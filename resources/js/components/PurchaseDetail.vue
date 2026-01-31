<template>
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="mb-6">
            <button
                @click="$emit('back')"
                class="mb-4 text-blue-500 hover:text-blue-700 flex items-center"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                一覧に戻る
            </button>
            <h1 class="text-3xl font-bold text-gray-900">購入詳細</h1>
        </div>

        <div v-if="loading" class="text-center py-8">
            <p class="text-gray-600">読み込み中...</p>
        </div>

        <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            <p>{{ error }}</p>
        </div>

        <div v-else-if="purchase" class="space-y-6">
            <!-- 購入基本情報 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">購入情報</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-gray-600">購入ID:</span>
                        <span class="ml-2 font-medium">{{ purchase.purchaseId }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">注文ID:</span>
                        <span class="ml-2 font-medium">{{ purchase.orderId }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">確定日時:</span>
                        <span class="ml-2 font-medium">{{ formatDateTime(purchase.confirmedAt) }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">状態:</span>
                        <span class="ml-2 px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                            購入確定済み
                        </span>
                    </div>
                </div>
            </div>

            <!-- メッセージ表示 -->
            <div v-if="message" :class="messageType === 'error' ? 'bg-red-50 border-red-200 text-red-700' : 'bg-green-50 border-green-200 text-green-700'" class="border px-4 py-3 rounded">
                <p>{{ message }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import { getPurchase } from '../api/purchaseApi';

export default {
    name: 'PurchaseDetail',
    props: {
        purchaseId: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            purchase: null,
            loading: false,
            error: null,
            message: null,
            messageType: 'success',
        };
    },
    mounted() {
        this.fetchPurchase();
    },
    methods: {
        async fetchPurchase() {
            this.loading = true;
            this.error = null;
            try {
                this.purchase = await getPurchase(this.purchaseId);
            } catch (err) {
                this.error = err.response?.data?.message || '購入情報の取得に失敗しました';
                console.error('Error fetching purchase:', err);
            } finally {
                this.loading = false;
            }
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




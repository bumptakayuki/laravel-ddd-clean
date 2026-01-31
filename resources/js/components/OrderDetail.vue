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
            <h1 class="text-3xl font-bold text-gray-900">注文詳細</h1>
        </div>

        <div v-if="loading" class="text-center py-8">
            <p class="text-gray-600">読み込み中...</p>
        </div>

        <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            <p>{{ error }}</p>
        </div>

        <div v-else-if="order" class="space-y-6">
            <!-- 注文基本情報 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">注文情報</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-gray-600">注文ID:</span>
                        <span class="ml-2 font-medium">{{ order.order_id }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">状態:</span>
                        <span
                            :class="getStatusClass(order.status)"
                            class="ml-2 px-3 py-1 rounded-full text-sm font-medium"
                        >
                            {{ getStatusLabel(order.status) }}
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-600">会員ID:</span>
                        <span class="ml-2 font-medium">{{ order.member_id }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">店舗ID:</span>
                        <span class="ml-2 font-medium">{{ order.store_id }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">注文日時:</span>
                        <span class="ml-2 font-medium">{{ formatDateTime(order.ordered_at) }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">合計金額:</span>
                        <span class="ml-2 text-2xl font-bold text-gray-900">
                            ¥{{ formatPrice(order.total_amount) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- 注文明細 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">注文明細</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    構成ID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    単価
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    数量
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    小計
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="item in order.items" :key="item.order_item_id">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ item.configuration_id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ¥{{ formatPrice(item.unit_price) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ item.quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    ¥{{ formatPrice(item.line_amount) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- アクション -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">操作</h2>

                <!-- 決済 -->
                <div v-if="order.status === 'pending'" class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">決済を実行</h3>
                    <form @submit.prevent="handlePayment" class="space-y-4">
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                                決済手段 <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="payment_method"
                                v-model="paymentForm.method"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            >
                                <option value="">選択してください</option>
                                <option value="credit_card">クレジットカード</option>
                                <option value="bank_transfer">銀行振込</option>
                                <option value="cash_on_delivery">代金引換</option>
                            </select>
                        </div>
                        <div>
                            <label for="transaction_id" class="block text-sm font-medium text-gray-700 mb-2">
                                取引ID（任意）
                            </label>
                            <input
                                id="transaction_id"
                                v-model="paymentForm.transaction_id"
                                type="text"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="transaction-001"
                            />
                        </div>
                        <button
                            type="submit"
                            :disabled="paymentLoading"
                            class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
                        >
                            <span v-if="paymentLoading">処理中...</span>
                            <span v-else>決済を実行</span>
                        </button>
                    </form>
                </div>

                <!-- 受注 -->
                <div v-if="order.status === 'paid'" class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">注文を受注</h3>
                    <button
                        @click="handleAcceptance"
                        :disabled="acceptanceLoading"
                        class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
                    >
                        <span v-if="acceptanceLoading">処理中...</span>
                        <span v-else>受注する</span>
                    </button>
                </div>

                <!-- 購入確定 -->
                <div v-if="order.status === 'accepted'">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">購入を確定</h3>
                    <button
                        @click="handlePurchase"
                        :disabled="purchaseLoading"
                        class="px-6 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-600 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
                    >
                        <span v-if="purchaseLoading">処理中...</span>
                        <span v-else>購入を確定</span>
                    </button>
                </div>

                <div v-if="order.status === 'purchased'" class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    <p>この注文は購入確定済みです。</p>
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
import { getOrders, createPayment, createAcceptance, createPurchase } from '../api/orderApi';

export default {
    name: 'OrderDetail',
    props: {
        orderId: {
            type: String,
            required: true,
        },
        memberId: {
            type: String,
            default: 'member-001',
        },
    },
    data() {
        return {
            order: null,
            loading: false,
            error: null,
            paymentLoading: false,
            acceptanceLoading: false,
            purchaseLoading: false,
            paymentForm: {
                method: '',
                transaction_id: '',
            },
            message: null,
            messageType: 'success',
        };
    },
    mounted() {
        this.fetchOrder();
    },
    methods: {
        async fetchOrder() {
            this.loading = true;
            this.error = null;
            try {
                const orders = await getOrders(this.memberId);
                this.order = orders.find(o => o.order_id === this.orderId);
                if (!this.order) {
                    this.error = '注文が見つかりませんでした';
                }
            } catch (err) {
                this.error = err.response?.data?.message || '注文の取得に失敗しました';
                console.error('Error fetching order:', err);
            } finally {
                this.loading = false;
            }
        },
        async handlePayment() {
            this.paymentLoading = true;
            this.message = null;
            try {
                const response = await createPayment(this.orderId, this.paymentForm);
                this.showMessage(`決済が完了しました。決済ID: ${response.payment_id}`, 'success');
                this.paymentForm = { method: '', transaction_id: '' };
                // 注文情報を再取得
                await this.fetchOrder();
                this.$emit('order-updated');
            } catch (err) {
                this.showMessage(err.response?.data?.message || '決済の実行に失敗しました', 'error');
                console.error('Error creating payment:', err);
            } finally {
                this.paymentLoading = false;
            }
        },
        async handleAcceptance() {
            this.acceptanceLoading = true;
            this.message = null;
            try {
                const response = await createAcceptance(this.orderId);
                this.showMessage(`受注が完了しました。受注ID: ${response.acceptance_id}`, 'success');
                // 注文情報を再取得
                await this.fetchOrder();
                this.$emit('order-updated');
            } catch (err) {
                this.showMessage(err.response?.data?.message || '受注の実行に失敗しました', 'error');
                console.error('Error creating acceptance:', err);
            } finally {
                this.acceptanceLoading = false;
            }
        },
        async handlePurchase() {
            this.purchaseLoading = true;
            this.message = null;
            try {
                const response = await createPurchase(this.orderId);
                this.showMessage(`購入が確定しました。購入ID: ${response.purchase_id}`, 'success');
                // 注文情報を再取得
                await this.fetchOrder();
                this.$emit('order-updated');
            } catch (err) {
                this.showMessage(err.response?.data?.message || '購入確定の実行に失敗しました', 'error');
                console.error('Error creating purchase:', err);
            } finally {
                this.purchaseLoading = false;
            }
        },
        showMessage(text, type = 'success') {
            this.message = text;
            this.messageType = type;
            setTimeout(() => {
                this.message = null;
            }, 5000);
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




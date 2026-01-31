<template>
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">注文を作成</h1>
        </div>

        <form @submit.prevent="handleSubmit" class="bg-white rounded-lg shadow-md p-6">
            <div class="mb-6">
                <label for="member_id" class="block text-sm font-medium text-gray-700 mb-2">
                    会員ID <span class="text-red-500">*</span>
                </label>
                <input
                    id="member_id"
                    v-model="form.member_id"
                    type="text"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="member-001"
                />
            </div>

            <div class="mb-6">
                <label for="store_id" class="block text-sm font-medium text-gray-700 mb-2">
                    店舗ID <span class="text-red-500">*</span>
                </label>
                <input
                    id="store_id"
                    v-model="form.store_id"
                    type="text"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="store-001"
                />
            </div>

            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                        注文明細 <span class="text-red-500">*</span>
                    </label>
                    <button
                        type="button"
                        @click="addItem"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors"
                    >
                        + 明細を追加
                    </button>
                </div>

                <div v-if="form.items.length === 0" class="text-center py-8 text-gray-500">
                    明細を追加してください
                </div>

                <div v-else class="space-y-4">
                    <div
                        v-for="(item, index) in form.items"
                        :key="index"
                        class="border border-gray-200 rounded-lg p-4"
                    >
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="font-medium text-gray-900">明細 {{ index + 1 }}</h3>
                            <button
                                type="button"
                                @click="removeItem(index)"
                                class="text-red-500 hover:text-red-700"
                            >
                                削除
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    構成ID <span class="text-red-500">*</span>
                                </label>
                                <input
                                    v-model="item.configuration_id"
                                    type="text"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="config-001"
                                />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    単価 <span class="text-red-500">*</span>
                                </label>
                                <input
                                    v-model.number="item.unit_price"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="1000"
                                />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    数量 <span class="text-red-500">*</span>
                                </label>
                                <input
                                    v-model.number="item.quantity"
                                    type="number"
                                    min="1"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="1"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="error" class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                <p>{{ error }}</p>
            </div>

            <div v-if="success" class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                <p>{{ success }}</p>
            </div>

            <div class="flex justify-end space-x-4">
                <button
                    type="button"
                    @click="resetForm"
                    class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors"
                >
                    リセット
                </button>
                <button
                    type="submit"
                    :disabled="loading || form.items.length === 0"
                    class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
                >
                    <span v-if="loading">送信中...</span>
                    <span v-else>注文を確定</span>
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import { createOrder } from '../api/orderApi';

export default {
    name: 'OrderCreate',
    data() {
        return {
            form: {
                member_id: 'member-001',
                store_id: '',
                items: [],
            },
            loading: false,
            error: null,
            success: null,
        };
    },
    methods: {
        addItem() {
            this.form.items.push({
                configuration_id: '',
                unit_price: 0,
                quantity: 1,
            });
        },
        removeItem(index) {
            this.form.items.splice(index, 1);
        },
        async handleSubmit() {
            this.loading = true;
            this.error = null;
            this.success = null;

            try {
                const response = await createOrder(this.form);
                this.success = `注文が作成されました。注文ID: ${response.order_id}`;
                this.$emit('order-created', response.order_id);
                
                // 3秒後にフォームをリセット
                setTimeout(() => {
                    this.resetForm();
                }, 3000);
            } catch (err) {
                this.error = err.response?.data?.message || '注文の作成に失敗しました';
                console.error('Error creating order:', err);
            } finally {
                this.loading = false;
            }
        },
        resetForm() {
            this.form = {
                member_id: 'member-001',
                store_id: '',
                items: [],
            };
            this.error = null;
            this.success = null;
        },
    },
};
</script>




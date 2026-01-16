<template>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <button
                @click="goBack"
                class="text-blue-600 hover:text-blue-800 mb-4 flex items-center"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                戻る
            </button>
            <h1 class="text-3xl font-bold text-gray-900">構成確認</h1>
        </div>

        <div v-if="!configurationData" class="text-center py-8">
            <p class="text-gray-600">構成データが見つかりません</p>
        </div>

        <div v-else class="max-w-2xl mx-auto">
            <!-- 弁当情報 -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ configurationData.boxLunch.name }}
                </h2>
                <p class="text-gray-600 mb-4">
                    {{ configurationData.boxLunch.description || '説明なし' }}
                </p>
                <div class="flex justify-between items-center pt-4 border-t">
                    <span class="text-lg text-gray-600">基本価格:</span>
                    <span class="text-lg font-medium">¥{{ formatPrice(configurationData.boxLunch.base_price) }}</span>
                </div>
            </div>

            <!-- 選択されたオプション -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">選択されたオプション</h3>

                <div v-if="selectedOptionsList.length === 0" class="text-center py-4">
                    <p class="text-gray-600">オプションは選択されていません</p>
                </div>

                <div v-else class="space-y-3">
                    <div
                        v-for="selection in selectedOptionsList"
                        :key="selection.option_id"
                        class="flex justify-between items-center p-3 border rounded-lg"
                    >
                        <div>
                            <p class="font-medium text-gray-900">{{ selection.name }}</p>
                            <p class="text-sm text-gray-600">
                                数量: {{ selection.quantity }} × ¥{{ formatPrice(selection.price_delta) }}
                            </p>
                        </div>
                        <p class="font-semibold text-gray-900">
                            ¥{{ formatPrice(selection.price_delta * selection.quantity) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- 合計金額 -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-lg text-gray-600">基本価格:</span>
                        <span class="text-lg font-medium">¥{{ formatPrice(configurationData.boxLunch.base_price) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-lg text-gray-600">オプション追加:</span>
                        <span class="text-lg font-medium">¥{{ formatPrice(optionTotalPrice) }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t">
                        <span class="text-xl font-semibold text-gray-900">合計金額:</span>
                        <span class="text-2xl font-bold text-blue-600">
                            ¥{{ formatPrice(configurationData.totalPrice) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- エラーメッセージ -->
            <div v-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                <p>{{ error }}</p>
            </div>

            <!-- アクションボタン -->
            <div class="flex gap-4">
                <button
                    @click="goBack"
                    class="flex-1 px-6 py-3 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors font-medium"
                >
                    戻る
                </button>
                <button
                    @click="confirmConfiguration"
                    :disabled="loading"
                    class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors font-medium"
                >
                    <span v-if="loading">作成中...</span>
                    <span v-else>構成を確定</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { createBoxLunchConfiguration } from '../api/boxLunchApi';

export default {
    name: 'BoxLunchConfigurationConfirm',
    props: {
        configurationData: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            loading: false,
            error: null,
        };
    },
    computed: {
        selectedOptionsList() {
            if (!this.configurationData || !this.configurationData.boxLunch) {
                return [];
            }

            return this.configurationData.selections
                .map(selection => {
                    const option = this.configurationData.boxLunch.options.find(
                        opt => opt.option_id === selection.option_id
                    );
                    if (option) {
                        return {
                            option_id: selection.option_id,
                            name: option.name,
                            quantity: selection.quantity,
                            price_delta: option.price_delta,
                        };
                    }
                    return null;
                })
                .filter(item => item !== null);
        },
        optionTotalPrice() {
            return this.selectedOptionsList.reduce((total, selection) => {
                return total + (selection.price_delta * selection.quantity);
            }, 0);
        },
    },
    methods: {
        async confirmConfiguration() {
            this.loading = true;
            this.error = null;

            try {
                const response = await createBoxLunchConfiguration({
                    box_lunch_id: this.configurationData.box_lunch_id,
                    availability_status: this.configurationData.availability_status,
                    selections: this.configurationData.selections,
                });

                // 成功時の処理
                alert(`構成が作成されました！\n構成ID: ${response.configuration_id}\n合計金額: ¥${this.formatPrice(response.total_price)}`);
                
                this.$emit('confirmed', response);
            } catch (err) {
                this.error = err.response?.data?.message || '構成の作成に失敗しました';
                console.error('Error creating configuration:', err);
            } finally {
                this.loading = false;
            }
        },
        goBack() {
            this.$emit('back');
        },
        formatPrice(price) {
            return Number(price).toLocaleString('ja-JP');
        },
    },
};
</script>



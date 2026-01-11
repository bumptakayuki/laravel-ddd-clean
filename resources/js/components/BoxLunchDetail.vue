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
                一覧に戻る
            </button>
            <h1 class="text-3xl font-bold text-gray-900">弁当詳細</h1>
        </div>

        <div v-if="loading" class="text-center py-8">
            <p class="text-gray-600">読み込み中...</p>
        </div>

        <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            <p>{{ error }}</p>
        </div>

        <div v-else-if="boxLunch" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- 弁当情報 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="mb-6">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-2xl font-bold text-gray-900">
                            {{ boxLunch.name }}
                        </h2>
                        <span
                            v-if="boxLunch.is_active"
                            class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium"
                        >
                            販売中
                        </span>
                        <span
                            v-else
                            class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium"
                        >
                            販売停止
                        </span>
                    </div>

                    <p class="text-gray-600 mb-6">
                        {{ boxLunch.description || '説明なし' }}
                    </p>

                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-lg text-gray-600">基本価格:</span>
                            <span class="text-3xl font-bold text-gray-900">
                                ¥{{ formatPrice(boxLunch.base_price) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- オプション選択 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">オプション選択</h3>

                <div v-if="boxLunch.options.length === 0" class="text-center py-8">
                    <p class="text-gray-600">利用可能なオプションがありません</p>
                </div>

                <div v-else class="space-y-4">
                    <div
                        v-for="option in boxLunch.options"
                        :key="option.option_id"
                        class="border rounded-lg p-4"
                        :class="{
                            'border-red-300 bg-red-50': option.is_required && !isOptionSelected(option.option_id),
                            'border-gray-300': !option.is_required || isOptionSelected(option.option_id),
                        }"
                    >
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-semibold text-gray-900">
                                        {{ option.name }}
                                    </h4>
                                    <span
                                        v-if="option.is_required"
                                        class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium"
                                    >
                                        必須
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ option.price_delta >= 0 ? '+' : '' }}¥{{ formatPrice(option.price_delta) }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 mt-4">
                            <button
                                @click="decreaseQuantity(option.option_id)"
                                :disabled="getQuantity(option.option_id) === 0"
                                class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </button>
                            <span class="text-lg font-semibold w-12 text-center">
                                {{ getQuantity(option.option_id) }}
                            </span>
                            <button
                                @click="increaseQuantity(option.option_id)"
                                class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 合計金額表示 -->
                <div class="mt-6 pt-6 border-t">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-lg text-gray-600">基本価格:</span>
                        <span class="text-lg font-medium">¥{{ formatPrice(boxLunch.base_price) }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-lg text-gray-600">オプション追加:</span>
                        <span class="text-lg font-medium">¥{{ formatPrice(optionTotalPrice) }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t">
                        <span class="text-xl font-semibold text-gray-900">合計金額:</span>
                        <span class="text-2xl font-bold text-blue-600">
                            ¥{{ formatPrice(totalPrice) }}
                        </span>
                    </div>
                </div>

                <!-- エラーメッセージ -->
                <div v-if="validationError" class="mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    <p>{{ validationError }}</p>
                </div>

                <!-- 構成作成ボタン -->
                <button
                    @click="createConfiguration"
                    :disabled="!canCreateConfiguration"
                    class="mt-6 w-full px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors font-medium"
                >
                    構成を作成
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { getBoxLunchDetail } from '../api/boxLunchApi';

export default {
    name: 'BoxLunchDetail',
    props: {
        boxLunchId: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            boxLunch: null,
            loading: false,
            error: null,
            selectedOptions: {}, // { optionId: quantity }
            validationError: null,
        };
    },
    computed: {
        optionTotalPrice() {
            if (!this.boxLunch) return 0;
            let total = 0;
            Object.keys(this.selectedOptions).forEach(optionId => {
                const quantity = this.selectedOptions[optionId];
                if (quantity > 0) {
                    const option = this.boxLunch.options.find(opt => opt.option_id === optionId);
                    if (option) {
                        total += option.price_delta * quantity;
                    }
                }
            });
            return total;
        },
        totalPrice() {
            if (!this.boxLunch) return 0;
            return this.boxLunch.base_price + this.optionTotalPrice;
        },
        canCreateConfiguration() {
            if (!this.boxLunch) return false;
            
            // 必須オプションのチェック
            const requiredOptions = this.boxLunch.options.filter(opt => opt.is_required);
            for (const option of requiredOptions) {
                if (!this.selectedOptions[option.option_id] || this.selectedOptions[option.option_id] === 0) {
                    return false;
                }
            }
            
            return true;
        },
    },
    mounted() {
        this.fetchBoxLunchDetail();
    },
    methods: {
        async fetchBoxLunchDetail() {
            this.loading = true;
            this.error = null;
            try {
                this.boxLunch = await getBoxLunchDetail(this.boxLunchId);
            } catch (err) {
                this.error = err.response?.data?.message || '弁当詳細の取得に失敗しました';
                console.error('Error fetching box lunch detail:', err);
            } finally {
                this.loading = false;
            }
        },
        isOptionSelected(optionId) {
            return this.selectedOptions[optionId] && this.selectedOptions[optionId] > 0;
        },
        getQuantity(optionId) {
            return this.selectedOptions[optionId] || 0;
        },
        increaseQuantity(optionId) {
            if (!this.selectedOptions[optionId]) {
                this.selectedOptions[optionId] = 0;
            }
            this.selectedOptions[optionId]++;
            this.validateSelection();
        },
        decreaseQuantity(optionId) {
            if (this.selectedOptions[optionId] && this.selectedOptions[optionId] > 0) {
                this.selectedOptions[optionId]--;
                this.validateSelection();
            }
        },
        validateSelection() {
            this.validationError = null;
            if (!this.boxLunch) return;

            const requiredOptions = this.boxLunch.options.filter(opt => opt.is_required);
            const missingRequired = requiredOptions.filter(opt => {
                return !this.selectedOptions[opt.option_id] || this.selectedOptions[opt.option_id] === 0;
            });

            if (missingRequired.length > 0) {
                this.validationError = '必須オプションが選択されていません: ' + missingRequired.map(opt => opt.name).join(', ');
            }
        },
        createConfiguration() {
            if (!this.canCreateConfiguration) {
                this.validateSelection();
                return;
            }

            // 選択されたオプションを配列に変換
            const selections = Object.keys(this.selectedOptions)
                .filter(optionId => this.selectedOptions[optionId] > 0)
                .map(optionId => ({
                    option_id: optionId,
                    quantity: this.selectedOptions[optionId],
                }));

            const configurationData = {
                boxLunch: this.boxLunch,
                box_lunch_id: this.boxLunch.box_lunch_id,
                availability_status: 'available',
                selections: selections,
                totalPrice: this.totalPrice,
            };

            this.$emit('configuration-created', configurationData);
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


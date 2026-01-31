<template>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <button
                @click="$emit('cancel')"
                class="flex items-center text-gray-600 hover:text-gray-900 mb-4 transition-colors"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                詳細に戻る
            </button>
            <h1 class="text-3xl font-bold text-gray-900">店舗編集</h1>
        </div>

        <div v-if="loading && !store" class="text-center py-8">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <p class="text-gray-600 mt-4">読み込み中...</p>
        </div>

        <div v-else-if="error && !store" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            <p>{{ error }}</p>
        </div>

        <div v-else-if="store" class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
            <form @submit.prevent="handleSubmit">
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            店舗名 <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            required
                            maxlength="100"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                            placeholder="店舗名を入力してください"
                        />
                        <p class="mt-1 text-sm text-gray-500">100文字以内で入力してください</p>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                            住所 <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            id="address"
                            v-model="form.address"
                            required
                            maxlength="200"
                            rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                            placeholder="住所を入力してください"
                        ></textarea>
                        <p class="mt-1 text-sm text-gray-500">200文字以内で入力してください</p>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input
                                v-model="form.is_open"
                                type="checkbox"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            />
                            <span class="ml-2 text-sm text-gray-700">営業中</span>
                        </label>
                    </div>

                    <div v-if="submitError" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                        <p>{{ submitError }}</p>
                    </div>

                    <div class="flex space-x-4">
                        <button
                            type="submit"
                            :disabled="submitting"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            {{ submitting ? '更新中...' : '更新' }}
                        </button>
                        <button
                            type="button"
                            @click="$emit('cancel')"
                            class="px-6 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors"
                        >
                            キャンセル
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { getStore, updateStore } from '../api/storeApi';

export default {
    name: 'StoreEdit',
    props: {
        storeId: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            store: null,
            form: {
                name: '',
                address: '',
                is_open: true,
            },
            loading: false,
            submitting: false,
            error: null,
            submitError: null,
        };
    },
    watch: {
        storeId: {
            immediate: true,
            handler() {
                this.fetchStore();
            },
        },
    },
    methods: {
        async fetchStore() {
            if (!this.storeId) {
                return;
            }

            this.loading = true;
            this.error = null;
            try {
                this.store = await getStore(this.storeId);
                this.form = {
                    name: this.store.name,
                    address: this.store.address,
                    is_open: this.store.is_open,
                };
            } catch (err) {
                this.error = err.response?.data?.message || '店舗情報の取得に失敗しました';
                console.error('Error fetching store:', err);
                this.store = null;
            } finally {
                this.loading = false;
            }
        },
        async handleSubmit() {
            this.submitting = true;
            this.submitError = null;

            try {
                await updateStore(this.storeId, {
                    name: this.form.name,
                    address: this.form.address,
                    is_open: this.form.is_open,
                });

                this.$emit('store-updated');
            } catch (err) {
                this.submitError = err.response?.data?.message || '店舗の更新に失敗しました';
                console.error('Error updating store:', err);
            } finally {
                this.submitting = false;
            }
        },
    },
};
</script>




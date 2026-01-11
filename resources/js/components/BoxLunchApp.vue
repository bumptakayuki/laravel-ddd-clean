<template>
    <div class="min-h-screen bg-gray-50 flex">
        <!-- サイドバー -->
        <aside class="w-64 bg-white shadow-lg flex flex-col h-screen sticky top-0">
            <!-- ロゴ -->
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-gray-900">GoMeal.</h1>
            </div>

            <!-- ナビゲーションメニュー -->
            <nav class="flex-1 px-4 py-6">
                <ul class="space-y-2">
                    <li>
                        <a
                            href="#"
                            class="flex items-center px-4 py-3 rounded-lg bg-yellow-100 text-yellow-600 font-medium"
                        >
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a
                            href="#"
                            class="flex items-center px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-100 font-medium"
                        >
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            Menu
                        </a>
                    </li>
                    <li>
                        <a
                            href="#"
                            class="flex items-center px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-100 font-medium"
                        >
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Food Order
                        </a>
                    </li>
                    <li>
                        <a
                            href="#"
                            class="flex items-center px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-100 font-medium"
                        >
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            Reviews
                        </a>
                    </li>
                    <li>
                        <a
                            href="#"
                            class="flex items-center px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-100 font-medium"
                        >
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Setting
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- アップグレードボタン -->
            <div class="p-4 border-t">
                <div class="bg-yellow-100 rounded-lg p-4">
                    <p class="text-sm font-medium text-gray-900 mb-2">Upgrade your Account to get more benefits</p>
                    <button class="w-full bg-yellow-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-yellow-600 transition-colors">
                        Upgrade
                    </button>
                </div>
            </div>
        </aside>

        <!-- メインコンテンツエリア -->
        <main class="flex-1 overflow-y-auto">
            <!-- ヘッダー -->
            <header class="bg-white shadow-sm sticky top-0 z-10">
                <div class="px-8 py-4 flex items-center justify-between">
                    <h2 class="text-3xl font-bold text-gray-900">Menu</h2>
                    <div class="flex items-center space-x-4">
                        <!-- 検索バー -->
                        <div class="relative">
                            <input
                                type="text"
                                placeholder="Search"
                                v-model="searchQuery"
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 w-64"
                            />
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <!-- 通知アイコン -->
                        <button class="relative p-2 text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </button>
                        <!-- 設定アイコン -->
                        <button class="p-2 text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                        <!-- ユーザープロフィール -->
                        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <!-- Add New Menuボタン -->
                        <button class="bg-yellow-500 text-white font-semibold px-6 py-2 rounded-lg hover:bg-yellow-600 transition-colors">
                            Add New Menu
                        </button>
                    </div>
                </div>
            </header>

            <!-- コンテンツエリア -->
            <div class="px-8 py-6">
                <!-- Categoryセクション -->
                <section class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Category</h3>
                        <a href="#" class="text-gray-600 hover:text-gray-900 text-sm">View all ></a>
                    </div>
                    <div class="flex space-x-4 overflow-x-auto pb-4">
                        <div
                            v-for="category in categories"
                            :key="category.id"
                            class="flex-shrink-0 w-32 h-32 bg-white rounded-lg shadow-md flex flex-col items-center justify-center cursor-pointer hover:shadow-lg transition-shadow"
                        >
                            <div class="text-4xl mb-2">{{ category.icon }}</div>
                            <span class="text-sm font-medium text-gray-700">{{ category.name }}</span>
                        </div>
                    </div>
                </section>

                <!-- Popular This Weekセクション -->
                <section class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Popular This Week</h3>
                        <a href="#" class="text-gray-600 hover:text-gray-900 text-sm">View all ></a>
                    </div>
                    <div class="flex space-x-4 overflow-x-auto pb-4">
                        <div
                            v-for="boxLunch in popularBoxLunches"
                            :key="boxLunch.box_lunch_id"
                            class="flex-shrink-0 w-72 bg-white rounded-lg shadow-md overflow-hidden cursor-pointer hover:shadow-lg transition-shadow"
                            @click="goToBoxLunchDetail(boxLunch.box_lunch_id)"
                        >
                            <div class="relative">
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <button class="absolute top-2 right-2 p-1 bg-white rounded-full shadow-md">
                                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ boxLunch.name }}</h4>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-2xl font-bold text-gray-900">¥{{ formatPrice(boxLunch.base_price) }}</span>
                                    <div class="flex items-center">
                                        <span class="text-yellow-500 mr-1">★</span>
                                        <span class="text-sm text-gray-600">5.0</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mb-2">1k+ User Reviews</p>
                                <p class="text-sm text-gray-600 line-clamp-2">{{ boxLunch.description || 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.' }}</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Best Sellerセクション -->
                <section class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Best Seller</h3>
                        <a href="#" class="text-gray-600 hover:text-gray-900 text-sm">View all ></a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div
                            v-for="boxLunch in bestSellerBoxLunches"
                            :key="boxLunch.box_lunch_id"
                            class="bg-white rounded-lg shadow-md overflow-hidden cursor-pointer hover:shadow-lg transition-shadow"
                            @click="goToBoxLunchDetail(boxLunch.box_lunch_id)"
                        >
                            <div class="relative">
                                <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <button class="absolute top-2 right-2 p-1 bg-white rounded-full shadow-md">
                                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ boxLunch.name }}</h4>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xl font-bold text-gray-900">¥{{ formatPrice(boxLunch.base_price) }}</span>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm text-gray-600">Sold 1k</span>
                                        <span class="text-sm text-green-600 font-semibold">+ 15% ↑</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Promoセクション -->
                <section class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Promo</h3>
                        <a href="#" class="text-gray-600 hover:text-gray-900 text-sm">View all ></a>
                    </div>
                    <div class="flex space-x-4 overflow-x-auto pb-4">
                        <div
                            v-for="boxLunch in promoBoxLunches"
                            :key="boxLunch.box_lunch_id"
                            class="flex-shrink-0 w-72 bg-white rounded-lg shadow-md overflow-hidden cursor-pointer hover:shadow-lg transition-shadow"
                            @click="goToBoxLunchDetail(boxLunch.box_lunch_id)"
                        >
                            <div class="relative">
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-semibold">
                                    15% Off
                                </div>
                            </div>
                            <div class="p-4">
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ boxLunch.name }}</h4>
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <span class="text-2xl font-bold text-gray-900">¥{{ formatPrice(boxLunch.discountedPrice) }}</span>
                                        <span class="text-sm text-gray-400 line-through ml-2">¥{{ formatPrice(boxLunch.base_price) }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-yellow-500 mr-1">★</span>
                                        <span class="text-sm text-gray-600">5.0</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500">1k+ Reviews</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>

        <!-- 詳細画面（モーダルまたは別画面） -->
        <BoxLunchDetail
            v-if="currentView === 'detail'"
            :box-lunch-id="selectedBoxLunchId"
            @back="goToList"
            @configuration-created="handleConfigurationCreated"
        />
        <BoxLunchConfigurationConfirm
            v-if="currentView === 'confirm'"
            :configuration-data="configurationData"
            @back="goToDetail"
            @confirmed="handleConfigurationConfirmed"
        />
    </div>
</template>

<script>
import BoxLunchDetail from './BoxLunchDetail.vue';
import BoxLunchConfigurationConfirm from './BoxLunchConfigurationConfirm.vue';
import { getBoxLunches } from '../api/boxLunchApi';

export default {
    name: 'BoxLunchApp',
    components: {
        BoxLunchDetail,
        BoxLunchConfigurationConfirm,
    },
    data() {
        return {
            currentView: 'list',
            selectedBoxLunchId: null,
            configurationData: null,
            searchQuery: '',
            storeId: 'store-001',
            boxLunches: [],
            loading: false,
            categories: [
                { id: 1, name: 'Bakery', icon: '🧁' },
                { id: 2, name: 'Burger', icon: '🍔' },
                { id: 3, name: 'Beverage', icon: '☕' },
                { id: 4, name: 'Chicken', icon: '🍗' },
                { id: 5, name: 'Pizza', icon: '🍕' },
                { id: 6, name: 'Seafood', icon: '🐟' },
            ],
        };
    },
    computed: {
        popularBoxLunches() {
            return this.boxLunches.slice(0, 4);
        },
        bestSellerBoxLunches() {
            return this.boxLunches.slice(0, 6);
        },
        promoBoxLunches() {
            return this.boxLunches.slice(0, 4).map(boxLunch => ({
                ...boxLunch,
                discountedPrice: Number(boxLunch.base_price) * 0.85,
            }));
        },
    },
    mounted() {
        this.fetchBoxLunches();
    },
    methods: {
        async fetchBoxLunches() {
            this.loading = true;
            try {
                this.boxLunches = await getBoxLunches(this.storeId);
            } catch (err) {
                console.error('Error fetching box lunches:', err);
                this.boxLunches = [];
            } finally {
                this.loading = false;
            }
        },
        goToBoxLunchDetail(boxLunchId) {
            this.selectedBoxLunchId = boxLunchId;
            this.currentView = 'detail';
        },
        handleConfigurationCreated(configurationData) {
            this.configurationData = configurationData;
            this.currentView = 'confirm';
        },
        handleConfigurationConfirmed() {
            this.goToList();
        },
        goToList() {
            this.currentView = 'list';
            this.selectedBoxLunchId = null;
            this.configurationData = null;
        },
        goToDetail() {
            this.currentView = 'detail';
            this.configurationData = null;
        },
        formatPrice(price) {
            return Number(price).toLocaleString('ja-JP');
        },
    },
};
</script>


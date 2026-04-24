<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps<{
    cart: any;
    total: number;
    subtotal: number;
    discount: number;
}>();

const updateQuantity = (itemId: number, quantity: number) => {
    if (quantity < 1) return;
    router.patch(route('cart.update', { item: itemId }), { quantity });
};

const removeItem = (itemId: number) => {
    if (confirm('Voulez-vous retirer cet article ?')) {
        router.delete(route('cart.destroy', { item: itemId }));
    }
};
</script>

<template>
    <Head title="Votre Panier - ShopTech" />

    <div class="min-h-screen bg-white dark:bg-slate-950 transition-colors duration-300">
        <div class="px-6 py-12 mx-auto max-w-7xl lg:px-12">
            <h1 class="text-4xl font-black mb-12">Votre Panier</h1>

            <div v-if="cart.items.length > 0" class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Items -->
                <div class="lg:col-span-2 space-y-6">
                    <div 
                        v-for="item in cart.items" 
                        :key="item.id"
                        class="flex gap-6 p-6 bg-slate-50 dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm"
                    >
                        <div class="w-24 h-24 sm:w-32 sm:h-32 bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shrink-0">
                            <img 
                                v-if="item.product.featured_image" 
                                :src="item.product.featured_image.path" 
                                class="w-full h-full object-cover"
                            />
                        </div>

                        <div class="flex-1 flex flex-col justify-between">
                            <div class="flex justify-between gap-4">
                                <div>
                                    <h3 class="font-bold text-lg">{{ item.product.name }}</h3>
                                    <p v-if="item.variant" class="text-sm text-slate-500">
                                        {{ item.variant.name }}: {{ item.variant.value }}
                                    </p>
                                </div>
                                <button @click="removeItem(item.id)" class="text-slate-400 hover:text-red-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center bg-white dark:bg-slate-800 rounded-xl p-1 border border-slate-200 dark:border-slate-700 shadow-sm">
                                    <button @click="updateQuantity(item.id, item.quantity - 1)" class="w-8 h-8 flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg">-</button>
                                    <span class="w-10 text-center text-sm font-bold">{{ item.quantity }}</span>
                                    <button @click="updateQuantity(item.id, item.quantity + 1)" class="w-8 h-8 flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg">+</button>
                                </div>
                                <div class="font-black text-lg">
                                    {{ (Number(item.variant?.price_override || item.product.base_price) * item.quantity).toLocaleString() }} XAF
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <div class="lg:col-span-1">
                    <div class="p-8 bg-slate-900 text-white rounded-[2.5rem] shadow-2xl space-y-6 sticky top-8">
                        <h2 class="text-2xl font-bold border-b border-white/10 pb-4">Résumé</h2>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between opacity-70">
                                <span>Sous-total</span>
                                <span>{{ subtotal.toLocaleString() }} XAF</span>
                            </div>
                            <div v-if="discount > 0" class="flex justify-between text-green-400">
                                <span>Réduction</span>
                                <span>- {{ discount.toLocaleString() }} XAF</span>
                            </div>
                            <div class="flex justify-between opacity-70">
                                <span>Livraison</span>
                                <span class="text-green-400 font-bold">Gratuite</span>
                            </div>
                            <div class="flex justify-between text-xl font-black pt-4 border-t border-white/10">
                                <span>Total</span>
                                <span class="text-blue-400">{{ total.toLocaleString() }} XAF</span>
                            </div>
                        </div>

                        <Link 
                            href="/checkout"
                            class="block w-full py-5 bg-white text-slate-950 text-center rounded-2xl font-black text-lg hover:bg-blue-400 hover:text-white transition-all shadow-xl active:scale-[0.98]"
                        >
                            Passer à la Caisse
                        </Link>
                        
                        <Link href="/products" class="block text-center text-sm opacity-50 hover:opacity-100 transition-opacity">
                            Continuer vos achats
                        </Link>
                    </div>
                </div>
            </div>

            <div v-else class="text-center py-24 space-y-6 bg-slate-50 dark:bg-slate-900 rounded-[3rem] border border-dashed border-slate-200 dark:border-slate-800">
                <div class="w-24 h-24 bg-white dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto text-slate-300 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold">Votre panier est vide</h2>
                <p class="text-slate-500">Il semble que vous n'ayez pas encore ajouté de produits.</p>
                <Link href="/products" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-2xl font-bold shadow-lg shadow-blue-500/20 hover:bg-blue-700 transition-all">
                    Découvrir le Catalogue
                </Link>
            </div>
        </div>
    </div>
</template>

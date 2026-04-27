<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import CartItem from '@/Components/Shop/CartItem.vue';
import ShopHeader from '@/components/Shop/ShopHeader.vue';
import ShopFooter from '@/components/Shop/ShopFooter.vue';
import { update as cartUpdate, destroy as cartDestroy } from '@/routes/cart';

const props = defineProps<{
    cart: any;
    total: number;
    subtotal: number;
    discount: number;
}>();

const updateQuantity = (itemId: number, quantity: number) => {
    if (quantity < 1) return;
    router.patch(cartUpdate(itemId).url, { quantity });
};

const removeItem = (itemId: number) => {
    if (confirm('Voulez-vous retirer cet article ?')) {
        router.delete(cartDestroy(itemId).url);
    }
};
</script>

<template>
    <Head title="Votre Panier - ShopTech" />

    <div class="min-h-screen bg-white dark:bg-slate-950 transition-colors duration-300">
        <ShopHeader />
        <div class="pt-32 px-6 py-12 mx-auto max-w-7xl lg:px-12">
            <h1 class="text-4xl font-black mb-12">Votre Panier</h1>

            <div v-if="cart.items.length > 0" class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Items -->
                <div class="lg:col-span-2 space-y-6">
                    <CartItem 
                        v-for="item in cart.items" 
                        :key="item.id"
                        :item="item"
                        @update="updateQuantity"
                        @remove="removeItem"
                    />
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

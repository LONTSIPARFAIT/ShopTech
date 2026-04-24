<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import StatusBadge from '@/Components/UI/StatusBadge.vue';

const props = defineProps<{
    order: any;
}>();
</script>

<template>
    <Head :title="`Commande #${order.id} - ShopTech`" />

    <div class="min-h-screen bg-slate-50 dark:bg-slate-950 transition-colors duration-300 py-12">
        <div class="px-6 mx-auto max-w-5xl">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
                <div>
                    <Link href="/orders" class="text-sm font-bold text-slate-500 hover:text-blue-600 transition-colors flex items-center gap-2 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour à mes commandes
                    </Link>
                    <h1 class="text-4xl font-black">Commande #{{ order.id }}</h1>
                    <p class="text-slate-500 mt-2">Passée le {{ new Date(order.created_at).toLocaleDateString() }}</p>
                </div>
                <div class="flex items-center gap-4">
                    <StatusBadge :status="order.status" />
                    <StatusBadge :status="order.payment_status" type="payment" />
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Items -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-xl overflow-hidden">
                        <div class="p-8 border-b border-slate-50 dark:border-slate-800">
                            <h2 class="text-xl font-bold">Articles</h2>
                        </div>
                        <div class="divide-y divide-slate-50 dark:divide-slate-800">
                            <div v-for="item in order.items" :key="item.id" class="p-8 flex gap-6">
                                <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-2xl overflow-hidden shrink-0 border border-slate-100 dark:border-slate-800">
                                    <img v-if="item.product.featured_image" :src="item.product.featured_image.path" class="w-full h-full object-cover" />
                                </div>
                                <div class="flex-1 space-y-1">
                                    <h3 class="font-bold">{{ item.product.name }}</h3>
                                    <p v-if="item.variant" class="text-xs text-slate-500">{{ item.variant.name }}: {{ item.variant.value }}</p>
                                    <div class="flex justify-between items-end pt-2">
                                        <p class="text-sm opacity-60">Quantité: {{ item.quantity }}</p>
                                        <p class="font-black">{{ (Number(item.price) * item.quantity).toLocaleString() }} XAF</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-8 bg-slate-50 dark:bg-slate-800/50 flex justify-between items-center">
                            <span class="font-bold opacity-60">Total payé</span>
                            <span class="text-2xl font-black text-blue-600">{{ Number(order.total_amount).toLocaleString() }} XAF</span>
                        </div>
                    </div>
                </div>

                <!-- Info Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 border border-slate-100 dark:border-slate-800 shadow-xl space-y-8">
                        <div class="space-y-4">
                            <h3 class="text-sm font-black uppercase tracking-widest opacity-40">Livraison</h3>
                            <p class="text-sm leading-relaxed font-medium">
                                {{ order.shipping_address || 'Non spécifiée' }}
                            </p>
                        </div>
                        <div class="space-y-4">
                            <h3 class="text-sm font-black uppercase tracking-widest opacity-40">Contact</h3>
                            <p class="text-sm font-medium">{{ order.customer_phone || 'Non spécifié' }}</p>
                        </div>
                        <div class="space-y-4 pt-8 border-t border-slate-50 dark:border-slate-800">
                            <h3 class="text-sm font-black uppercase tracking-widest opacity-40">Paiement</h3>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center text-slate-500">
                                    <svg v-if="order.payment_method === 'notchpay'" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold">{{ order.payment_method === 'notchpay' ? 'Notch Pay' : 'Paiement à la livraison' }}</p>
                                    <p class="text-[10px] opacity-60 uppercase tracking-tighter">{{ order.payment_status }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

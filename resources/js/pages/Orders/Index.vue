<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import StatusBadge from '@/Components/UI/StatusBadge.vue';

const props = defineProps<{
    orders: {
        data: Array<any>;
        links: Array<any>;
    };
}>();
</script>

<template>
    <Head title="Mes Commandes - ShopTech" />

    <div class="min-h-screen bg-slate-50 dark:bg-slate-950 transition-colors duration-300 py-12">
        <div class="px-6 mx-auto max-w-7xl lg:px-12">
            <div class="flex items-center justify-between mb-12">
                <h1 class="text-4xl font-black">Mes Commandes</h1>
                <Link href="/products" class="text-sm font-bold text-blue-600 hover:underline">Continuer mes achats</Link>
            </div>

            <div v-if="orders.data.length > 0" class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-slate-100 dark:border-slate-800">
                                <th class="px-8 py-6 font-bold text-sm opacity-60">ID</th>
                                <th class="px-8 py-6 font-bold text-sm opacity-60">Date</th>
                                <th class="px-8 py-6 font-bold text-sm opacity-60">Statut</th>
                                <th class="px-8 py-6 font-bold text-sm opacity-60">Paiement</th>
                                <th class="px-8 py-6 font-bold text-sm opacity-60">Total</th>
                                <th class="px-8 py-6 font-bold text-sm opacity-60"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                            <tr v-for="order in orders.data" :key="order.id" class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-8 py-6 font-bold">#{{ order.id }}</td>
                                <td class="px-8 py-6 text-sm opacity-70">{{ new Date(order.created_at).toLocaleDateString() }}</td>
                                <td class="px-8 py-6 text-sm">
                                    <StatusBadge :status="order.status" />
                                </td>
                                <td class="px-8 py-6 text-sm">
                                    <StatusBadge :status="order.payment_status" type="payment" />
                                </td>
                                <td class="px-8 py-6 font-black">{{ Number(order.total_amount).toLocaleString() }} XAF</td>
                                <td class="px-8 py-6 text-right">
                                    <Link :href="`/orders/${order.id}`" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 rounded-xl text-sm font-bold hover:bg-blue-600 hover:text-white transition-all">
                                        Détails
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div v-else class="text-center py-24 bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-xl space-y-6">
                <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto text-slate-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold">Aucune commande pour le moment</h2>
                <Link href="/products" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-2xl font-bold shadow-lg shadow-blue-500/20 hover:bg-blue-700 transition-all">
                    Commencer mes achats
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import StatCard from '@/Components/Admin/StatCard.vue';
import StatusBadge from '@/Components/UI/StatusBadge.vue';

const props = defineProps<{
    stats: {
        total_orders: number;
        total_revenue: number;
        total_products: number;
        total_clients: number;
    };
    recent_orders: Array<any>;
}>();
</script>

<template>
    <Head title="Admin Dashboard - ShopTech" />

    <div class="min-h-screen bg-slate-50 dark:bg-slate-950 p-8">
        <div class="max-w-7xl mx-auto space-y-12">
            <h1 class="text-4xl font-black">Tableau de Bord</h1>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <StatCard label="Revenus" :value="stats.total_revenue" unit="XAF" />
                <StatCard label="Commandes" :value="stats.total_orders" />
                <StatCard label="Produits" :value="stats.total_products" />
                <StatCard label="Clients" :value="stats.total_clients" />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Recent Orders -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold">Commandes Récentes</h2>
                        <Link href="/admin/orders" class="text-sm font-bold text-blue-600">Voir tout</Link>
                    </div>
                    <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
                        <table class="w-full text-left">
                            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                                <tr v-for="order in recent_orders" :key="order.id" class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                    <td class="px-8 py-6 font-bold">#{{ order.id }}</td>
                                    <td class="px-8 py-6 text-sm">{{ order.user.name }}</td>
                                    <td class="px-8 py-6 text-sm font-black">{{ Number(order.total_amount).toLocaleString() }} XAF</td>
                                    <td class="px-8 py-6 text-right">
                                        <StatusBadge :status="order.payment_status" type="payment" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="space-y-6">
                    <h2 class="text-2xl font-bold">Actions Rapides</h2>
                    <div class="grid grid-cols-1 gap-4">
                        <Link href="/admin/products/create" class="p-6 bg-slate-900 text-white rounded-2xl font-bold flex items-center justify-between group hover:bg-blue-600 transition-all">
                            Ajouter un Produit
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </Link>
                        <Link href="/admin/orders" class="p-6 bg-white dark:bg-slate-900 rounded-2xl font-bold border border-slate-100 dark:border-slate-800 flex items-center justify-between group hover:border-blue-600 transition-all">
                            Gérer les Commandes
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import StatCard from '@/components/Admin/StatCard.vue';
import StatusBadge from '@/components/ui/StatusBadge.vue';
import { ShoppingBag, Users, Layers, Activity } from 'lucide-vue-next';

const props = defineProps<{
    stats: {
        total_orders: number;
        total_revenue: number;
        total_products: number;
        total_clients: number;
    };
    recent_orders: any[];
}>();

defineOptions({
    layout: AppSidebarLayout,
});
</script>

<template>
    <Head title="Tableau de Bord Admin" />

    <div class="p-8 space-y-12 bg-slate-50 dark:bg-slate-950/50 min-h-full">
        <!-- Welcome Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-1">
                <h1 class="text-4xl font-black tracking-tight text-slate-900 dark:text-white">Aperçu Global</h1>
                <p class="text-slate-500 font-medium">Bienvenue dans votre centre de contrôle.</p>
            </div>
            <div class="flex items-center gap-3 bg-white dark:bg-slate-900 p-2 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm">
                <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center text-white">
                    <Activity class="w-6 h-6" />
                </div>
                <div class="pr-4">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Statut Système</p>
                    <p class="text-sm font-bold">En ligne</p>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <StatCard 
                label="Revenus Totaux" 
                :value="stats.total_revenue" 
                unit="XAF" 
                trend="+12%" 
                color="bg-blue-600"
                :icon="ShoppingBag"
            />
            <StatCard 
                label="Commandes" 
                :value="stats.total_orders" 
                trend="+5% ce mois" 
                color="bg-purple-600"
                :icon="Layers"
            />
            <StatCard 
                label="Catalogue Produits" 
                :value="stats.total_products" 
                trend="Actifs" 
                color="bg-orange-500"
                :icon="ShoppingBag"
            />
            <StatCard 
                label="Clients" 
                :value="stats.total_clients" 
                trend="Inscrits" 
                color="bg-green-500"
                :icon="Users"
            />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Recent Activity -->
            <div class="lg:col-span-2 space-y-8">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-black tracking-tight">Ventes Récentes</h2>
                    <Link href="/admin/orders" class="text-sm font-black uppercase tracking-widest text-blue-600 hover:text-blue-700 transition-colors">Explorer tout</Link>
                </div>
                
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-xl shadow-black/5 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50 dark:bg-slate-800/30 border-b border-slate-100 dark:border-slate-800">
                                    <th class="px-8 py-6 text-xs font-black uppercase tracking-[0.2em] text-slate-400">Commande</th>
                                    <th class="px-8 py-6 text-xs font-black uppercase tracking-[0.2em] text-slate-400">Client</th>
                                    <th class="px-8 py-6 text-xs font-black uppercase tracking-[0.2em] text-slate-400">Montant</th>
                                    <th class="px-8 py-6 text-xs font-black uppercase tracking-[0.2em] text-slate-400">Paiement</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                                <tr v-for="order in recent_orders" :key="order.id" class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors group">
                                    <td class="px-8 py-6 font-black text-slate-900 dark:text-white">#{{ order.id }}</td>
                                    <td class="px-8 py-6">
                                        <div class="font-bold">{{ order.user.name }}</div>
                                        <div class="text-xs text-slate-400">{{ order.user.email }}</div>
                                    </td>
                                    <td class="px-8 py-6 font-black text-blue-600">
                                        {{ Number(order.total_amount).toLocaleString() }} <span class="text-[10px]">XAF</span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <StatusBadge :status="order.payment_status" type="payment" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="recent_orders.length === 0" class="p-20 text-center space-y-4">
                        <p class="font-bold text-slate-400">Aucune commande récente.</p>
                    </div>
                </div>
            </div>

            <!-- Quick Controls -->
            <div class="space-y-8">
                <h2 class="text-2xl font-black tracking-tight">Raccourcis</h2>
                <div class="grid grid-cols-1 gap-6">
                    <Link href="/admin/products/create" class="group p-8 bg-slate-900 dark:bg-white text-white dark:text-slate-950 rounded-[2.5rem] flex flex-col gap-6 hover:scale-[1.02] transition-all shadow-2xl">
                        <div class="w-14 h-14 bg-white/10 dark:bg-black/5 rounded-2xl flex items-center justify-center">
                            <ShoppingBag class="w-7 h-7" />
                        </div>
                        <div class="space-y-1">
                            <p class="font-black text-xl">Nouveau Produit</p>
                            <p class="text-sm opacity-60">Ajouter un article au catalogue.</p>
                        </div>
                    </Link>
                    
                    <Link href="/admin/orders" class="group p-8 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-[2.5rem] flex flex-col gap-6 hover:border-blue-600 transition-all shadow-sm">
                        <div class="w-14 h-14 bg-blue-50 dark:bg-blue-900/30 text-blue-600 rounded-2xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all">
                            <Layers class="w-7 h-7" />
                        </div>
                        <div class="space-y-1">
                            <p class="font-black text-xl">Commandes</p>
                            <p class="text-sm opacity-60">Traiter les livraisons en attente.</p>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

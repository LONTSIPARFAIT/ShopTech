<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import StatCard from '@/components/Admin/StatCard.vue';
import StatusBadge from '@/components/ui/StatusBadge.vue';
import { ShoppingBag, Users, Package, TrendingUp, Eye, CreditCard } from 'lucide-vue-next';

const props = defineProps<{
    stats: {
        total_orders: number;
        total_revenue: number;
        total_products: number;
        total_clients: number;
    };
    recent_orders: any[];
}>();
</script>

<template>
    <Head title="Tableau de Bord Admin" />

    <div class="py-6 md:py-8 px-4 max-w-7xl">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-black tracking-tight text-foreground">Tableau de bord</h1>
                <p class="text-sm text-muted-foreground mt-1">Bienvenue dans votre centre de contrôle</p>
            </div>
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 dark:bg-green-950/30 rounded-xl">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-xs font-bold text-green-700 dark:text-green-400">Système en ligne</span>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <StatCard 
                label="Revenus totaux" 
                :value="stats.total_revenue" 
                unit="FCFA" 
                trend="+12%"
                color="bg-primary/10 text-primary"
                :icon="TrendingUp"
            />
            <StatCard 
                label="Commandes" 
                :value="stats.total_orders" 
                trend="+5%"
                color="bg-purple-100 text-purple-600 dark:bg-purple-950/30 dark:text-purple-400"
                :icon="ShoppingBag"
            />
            <StatCard 
                label="Produits" 
                :value="stats.total_products" 
                color="bg-orange-100 text-orange-600 dark:bg-orange-950/30 dark:text-orange-400"
                :icon="Package"
            />
            <StatCard 
                label="Clients" 
                :value="stats.total_clients" 
                color="bg-green-100 text-green-600 dark:bg-green-950/30 dark:text-green-400"
                :icon="Users"
            />
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Orders -->
            <div class="lg:col-span-2">
                <div class="bg-card border border-border rounded-2xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-border bg-secondary/30 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-foreground">Commandes récentes</h2>
                        <Link href="/admin/orders" class="text-sm font-semibold text-primary hover:underline">Voir tout</Link>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-secondary/20">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-muted-foreground">Commande</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-muted-foreground">Client</th>
                                    <th class="px-4 py-3 text-right text-xs font-bold text-muted-foreground">Montant</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-muted-foreground">Statut</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-muted-foreground"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border">
                                <tr v-for="order in recent_orders.slice(0, 5)" :key="order.id" class="hover:bg-secondary/30 transition-colors">
                                    <td class="px-4 py-3 text-sm font-bold text-foreground">#{{ order.id }}</td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-foreground">{{ order.user.name }}</div>
                                        <div class="text-xs text-muted-foreground">{{ order.user.email }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-bold text-primary">{{ Number(order.total_amount).toLocaleString() }} FCFA</td>
                                    <td class="px-4 py-3 text-center">
                                        <StatusBadge :status="order.payment_status" type="payment" />
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <Link :href="`/admin/orders/${order.id}`" class="p-1.5 text-muted-foreground hover:text-primary rounded-lg">
                                            <Eye class="w-4 h-4" />
                                        </Link>
                                    </td>
                                </tr>
                                <tr v-if="recent_orders.length === 0">
                                    <td colspan="5" class="px-4 py-8 text-center text-muted-foreground">
                                        Aucune commande récente
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div>
                <div class="bg-card border border-border rounded-2xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-border bg-secondary/30">
                        <h2 class="text-lg font-bold text-foreground">Actions rapides</h2>
                    </div>
                    <div class="divide-y divide-border">
                        <Link href="/admin/products/create" class="flex items-center gap-4 p-4 hover:bg-secondary/30 transition-colors group">
                            <div class="p-2 bg-primary/10 rounded-xl group-hover:bg-primary group-hover:text-white transition-all">
                                <Package class="w-5 h-5 text-primary group-hover:text-white" />
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-foreground">Nouveau produit</h3>
                                <p class="text-xs text-muted-foreground">Ajouter un article au catalogue</p>
                            </div>
                        </Link>
                        <Link href="/admin/orders" class="flex items-center gap-4 p-4 hover:bg-secondary/30 transition-colors group">
                            <div class="p-2 bg-purple-100 dark:bg-purple-950/30 rounded-xl group-hover:bg-purple-500 transition-all">
                                <ShoppingBag class="w-5 h-5 text-purple-600 dark:text-purple-400 group-hover:text-white" />
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-foreground">Commandes</h3>
                                <p class="text-xs text-muted-foreground">Gérer les commandes en attente</p>
                            </div>
                        </Link>
                        <Link href="/admin/products" class="flex items-center gap-4 p-4 hover:bg-secondary/30 transition-colors group">
                            <div class="p-2 bg-orange-100 dark:bg-orange-950/30 rounded-xl group-hover:bg-orange-500 transition-all">
                                <Package class="w-5 h-5 text-orange-600 dark:text-orange-400 group-hover:text-white" />
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-foreground">Catalogue</h3>
                                <p class="text-xs text-muted-foreground">Gérer les produits</p>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
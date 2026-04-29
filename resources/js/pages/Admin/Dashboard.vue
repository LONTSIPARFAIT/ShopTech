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

    <div class="dashboard-container">
        <!-- Welcome Header -->
        <div class="dashboard-header">
            <div class="dashboard-header-content">
                <h1 class="dashboard-title">Aperçu Global</h1>
                <p class="dashboard-subtitle">Bienvenue dans votre centre de contrôle.</p>
            </div>
            <div class="system-status">
                <div class="system-status-icon">
                    <Activity class="w-5 h-5 md:w-6 md:h-6" />
                </div>
                <div class="system-status-info">
                    <p class="system-status-label">Statut Système</p>
                    <p class="system-status-value">En ligne</p>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
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

        <!-- Recent Activity & Quick Controls -->
        <div class="dashboard-grid">
            <!-- Recent Activity -->
            <div class="dashboard-recent">
                <div class="section-header">
                    <h2 class="section-title">Ventes Récentes</h2>
                    <Link href="/admin/orders" class="section-link">Explorer tout</Link>
                </div>
                
                <div class="dashboard-table-container">
                    <div class="overflow-x-auto">
                        <table class="dashboard-table">
                            <thead>
                                <tr class="dashboard-table-header">
                                    <th class="dashboard-table-cell">Commande</th>
                                    <th class="dashboard-table-cell">Client</th>
                                    <th class="dashboard-table-cell">Montant</th>
                                    <th class="dashboard-table-cell">Paiement</th>
                                 </tr>
                            </thead>
                            <tbody>
                                <tr v-for="order in recent_orders" :key="order.id" class="dashboard-table-row">
                                    <td class="dashboard-table-cell dashboard-order-id">#{{ order.id }}</td>
                                    <td class="dashboard-table-cell">
                                        <div class="dashboard-client-name">{{ order.user.name }}</div>
                                        <div class="dashboard-client-email">{{ order.user.email }}</div>
                                    </td>
                                    <td class="dashboard-table-cell dashboard-amount">
                                        {{ Number(order.total_amount).toLocaleString() }} <span class="dashboard-amount-unit">XAF</span>
                                    </td>
                                    <td class="dashboard-table-cell">
                                        <StatusBadge :status="order.payment_status" type="payment" />
                                    </td>
                                 </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div v-if="recent_orders.length === 0" class="dashboard-empty">
                        <p class="dashboard-empty-text">Aucune commande récente.</p>
                    </div>
                </div>
            </div>

            <!-- Quick Controls -->
            <div class="dashboard-quick">
                <h2 class="section-title">Raccourcis</h2>
                <div class="quick-grid">
                    <Link href="/admin/products/create" class="quick-card quick-card-primary">
                        <div class="quick-icon-primary">
                            <ShoppingBag class="w-6 h-6 md:w-7 md:h-7" />
                        </div>
                        <div class="quick-content">
                            <p class="quick-title">Nouveau Produit</p>
                            <p class="quick-description">Ajouter un article au catalogue.</p>
                        </div>
                    </Link>
                    
                    <Link href="/admin/orders" class="quick-card quick-card-secondary">
                        <div class="quick-icon-secondary">
                            <Layers class="w-6 h-6 md:w-7 md:h-7" />
                        </div>
                        <div class="quick-content">
                            <p class="quick-title">Commandes</p>
                            <p class="quick-description">Traiter les livraisons en attente.</p>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
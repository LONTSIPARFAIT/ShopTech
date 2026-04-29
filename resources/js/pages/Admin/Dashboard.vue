<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import StatCard from '@/components/Admin/StatCard.vue';
import StatusBadge from '@/components/ui/StatusBadge.vue';
import { ShoppingBag, Users, Layers, Activity, Package, CreditCard, TrendingUp } from 'lucide-vue-next';

const props = defineProps<{
    stats: {
        total_orders: number;
        total_revenue: number;
        total_products: number;
        total_clients: number;
    };
    recent_orders: any[];
}>();

defineOptions({ layout: AppSidebarLayout });
</script>

<template>
    <Head title="Tableau de Bord Admin" />

    <div class="admin-dashboard">
        <!-- Header -->
        <div class="admin-dashboard-header">
            <div>
                <h1 class="admin-dashboard-title">Tableau de bord</h1>
                <p class="admin-dashboard-subtitle">Bienvenue dans votre centre de contrôle</p>
            </div>
            <div class="admin-dashboard-status">
                <span class="admin-dashboard-status-dot"></span>
                <span class="admin-dashboard-status-text">Système en ligne</span>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="admin-stats-grid">
            <StatCard 
                label="Revenus totaux" 
                :value="stats.total_revenue" 
                unit="XAF" 
                trend="+12%"
                color="bg-blue-50 text-blue-600"
                :icon="TrendingUp"
            />
            <StatCard 
                label="Commandes" 
                :value="stats.total_orders" 
                trend="+5%"
                color="bg-purple-50 text-purple-600"
                :icon="ShoppingBag"
            />
            <StatCard 
                label="Produits" 
                :value="stats.total_products" 
                color="bg-orange-50 text-orange-600"
                :icon="Package"
            />
            <StatCard 
                label="Clients" 
                :value="stats.total_clients" 
                color="bg-green-50 text-green-600"
                :icon="Users"
            />
        </div>

        <!-- Main Content -->
        <div class="admin-dashboard-content">
            <!-- Recent Orders -->
            <div class="admin-recent-orders">
                <div class="admin-section-header">
                    <h2 class="admin-section-title">Commandes récentes</h2>
                    <Link href="/admin/orders" class="admin-section-link">Voir tout</Link>
                </div>

                <div class="admin-orders-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Commande</th>
                                <th>Client</th>
                                <th>Montant</th>
                                <th>Statut</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in recent_orders" :key="order.id">
                                <td class="admin-order-id">#{{ order.id }}</td>
                                <td>
                                    <div class="admin-order-client">{{ order.user.name }}</div>
                                    <div class="admin-order-email">{{ order.user.email }}</div>
                                </td>
                                <td class="admin-order-amount">
                                    {{ Number(order.total_amount).toLocaleString() }} XAF
                                </td>
                                <td>
                                    <StatusBadge :status="order.payment_status" type="payment" />
                                </td>
                                <td>
                                    <Link :href="`/admin/orders/${order.id}`" class="admin-order-link">
                                        Détails
                                    </Link>
                                </td>
                            </tr>
                            <tr v-if="recent_orders.length === 0">
                                <td colspan="5" class="admin-empty-cell">
                                    Aucune commande récente
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="admin-quick-actions">
                <h2 class="admin-section-title">Actions rapides</h2>
                <div class="admin-actions-list">
                    <Link href="/admin/products/create" class="admin-action-card admin-action-primary">
                        <Package class="w-6 h-6" />
                        <div>
                            <h3>Nouveau produit</h3>
                            <p>Ajouter un article au catalogue</p>
                        </div>
                    </Link>
                    <Link href="/admin/orders" class="admin-action-card">
                        <ShoppingBag class="w-6 h-6" />
                        <div>
                            <h3>Commandes</h3>
                            <p>Gérer les commandes en attente</p>
                        </div>
                    </Link>
                    <Link href="/admin/products" class="admin-action-card">
                        <Package class="w-6 h-6" />
                        <div>
                            <h3>Catalogue</h3>
                            <p>Gérer les produits</p>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
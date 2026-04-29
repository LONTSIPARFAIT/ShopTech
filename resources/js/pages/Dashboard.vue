<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import StatusBadge from '@/components/ui/StatusBadge.vue';
import { ShoppingCart, Package, CreditCard, ChevronRight, User, Headphones, Settings } from 'lucide-vue-next';

const props = defineProps<{
    recentOrders: any[];
    stats: {
        totalOrders: number;
        totalSpent: number;
    };
}>();

defineOptions({
    layout: AppSidebarLayout,
});
</script>

<template>
    <Head title="Mon Espace Client" />

    <div class="user-dashboard">
        <!-- Welcome Section -->
        <div class="user-welcome">
            <div class="user-welcome-content">
                <div class="user-welcome-badge">
                    <User class="w-3 h-3" />
                    Membre
                </div>
                <h1 class="user-welcome-title">
                    Bonjour, <span class="text-blue-600">{{ $page.props.auth.user.name }}</span>
                </h1>
                <p class="user-welcome-text">
                    Gérez vos commandes, suivez vos achats et découvrez nos offres.
                </p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="user-stats">
            <div class="user-stat-card">
                <div class="user-stat-icon icon-blue">
                    <CreditCard class="w-5 h-5" />
                </div>
                <div class="user-stat-info">
                    <span class="user-stat-label">Total dépensé</span>
                    <p class="user-stat-value">
                        {{ Number(stats.totalSpent).toLocaleString() }} 
                        <span class="user-stat-unit">FCFA</span>
                    </p>
                </div>
            </div>

            <div class="user-stat-card">
                <div class="user-stat-icon icon-purple">
                    <Package class="w-5 h-5" />
                </div>
                <div class="user-stat-info">
                    <span class="user-stat-label">Commandes</span>
                    <p class="user-stat-value">
                        {{ stats.totalOrders }} 
                        <span class="user-stat-unit">achats</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="user-content">
            <!-- Recent Orders -->
            <div class="user-orders">
                <div class="user-orders-header">
                    <h2>Commandes récentes</h2>
                    <Link href="/orders" class="user-link">
                        Voir tout <ChevronRight class="w-3 h-3" />
                    </Link>
                </div>

                <div v-if="recentOrders.length > 0" class="user-orders-list">
                    <div v-for="order in recentOrders" :key="order.id" class="user-order-card">
                        <div class="user-order-info">
                            <div class="user-order-id">#{{ order.id }}</div>
                            <div class="user-order-date">
                                {{ new Date(order.created_at).toLocaleDateString('fr-FR') }}
                            </div>
                        </div>
                        <div class="user-order-amount">
                            {{ Number(order.total_amount).toLocaleString() }} FCFA
                        </div>
                        <div class="user-order-status">
                            <StatusBadge :status="order.status" type="order" />
                        </div>
                        <Link :href="`/orders/${order.id}`" class="user-order-link">
                            Détails <ChevronRight class="w-3 h-3" />
                        </Link>
                    </div>
                </div>

                <div v-else class="user-empty">
                    <ShoppingCart class="w-12 h-12" />
                    <h3>Aucune commande</h3>
                    <p>Votre premier achat vous attend</p>
                    <Link href="/products" class="user-btn-primary">
                        Découvrir la boutique
                    </Link>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="user-sidebar">
                <h2>Support & Compte</h2>
                <div class="user-sidebar-list">
                    <Link href="/contact" class="user-sidebar-card card-support">
                        <Headphones class="w-5 h-5" />
                        <div>
                            <h3>Service client</h3>
                            <p>Une question ? Contactez-nous</p>
                        </div>
                    </Link>
                    <Link href="/settings/profile" class="user-sidebar-card">
                        <Settings class="w-5 h-5" />
                        <div>
                            <h3>Mon profil</h3>
                            <p>Gérer vos informations</p>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
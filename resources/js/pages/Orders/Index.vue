<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import StatusBadge from '@/components/ui/StatusBadge.vue';
import { Package, ChevronRight, Calendar, CreditCard } from 'lucide-vue-next';

const props = defineProps<{
    orders: {
        data: any[];
        links: any[];
    };
}>();

defineOptions({ layout: AppSidebarLayout });
</script>

<template>
    <Head title="Mes Commandes" />

    <div class="user-orders-page">
        <div class="user-page-header">
            <h1 class="user-page-title">Mes commandes</h1>
            <p class="user-page-subtitle">Retrouvez tous vos achats effectués sur ShopTech</p>
        </div>

        <div v-if="orders.data.length > 0" class="user-orders-list">
            <div v-for="order in orders.data" :key="order.id" class="user-order-card">
                <div class="user-order-main">
                    <div class="user-order-id">#{{ order.id }}</div>
                    <div class="user-order-amount">
                        {{ Number(order.total_amount).toLocaleString() }} FCFA
                    </div>
                    <div class="user-order-status">
                        <StatusBadge :status="order.status" type="order" />
                    </div>
                </div>
                <div class="user-order-footer">
                    <div class="user-order-meta">
                        <span class="user-order-date">
                            <Calendar class="w-3 h-3" />
                            {{ new Date(order.created_at).toLocaleDateString('fr-FR') }}
                        </span>
                        <span class="user-order-payment">
                            <CreditCard class="w-3 h-3" />
                            {{ order.payment_status === 'paid' ? 'Payé' : 'En attente' }}
                        </span>
                    </div>
                    <Link :href="`/orders/${order.id}`" class="user-order-link">
                        Détails <ChevronRight class="w-3 h-3" />
                    </Link>
                </div>
            </div>
        </div>

        <div v-else class="user-empty">
            <Package class="w-12 h-12" />
            <h3>Aucune commande</h3>
            <p>Votre premier achat vous attend</p>
            <Link href="/products" class="user-btn-primary">Découvrir la boutique</Link>
        </div>
    </div>
</template>
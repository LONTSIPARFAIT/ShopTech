<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import StatusBadge from '@/components/ui/StatusBadge.vue';
import { ShoppingBag, Search, Filter } from 'lucide-vue-next';
import { ref, computed } from 'vue';

const props = defineProps<{
    orders: any[];
}>();

const search = ref('');
const statusFilter = ref('all');

const filteredOrders = computed(() => {
    let result = props.orders;
    
    if (search.value) {
        const q = search.value.toLowerCase();
        result = result.filter(o => 
            `#${o.id}`.includes(q) || 
            o.user.name.toLowerCase().includes(q)
        );
    }
    
    if (statusFilter.value !== 'all') {
        result = result.filter(o => o.status === statusFilter.value);
    }
    
    return result;
});
</script>

<template>
    <Head title="Commandes - Admin" />

    <div class="admin-orders">
        <div class="admin-header">
            <div>
                <h1 class="admin-title">Commandes</h1>
                <p class="admin-subtitle">Suivez et gérez les commandes de vos clients</p>
            </div>
            <div class="admin-stats-badge">
                <ShoppingBag class="w-4 h-4" />
                <span>{{ orders.length }} commandes</span>
            </div>
        </div>

        <!-- Filters -->
        <div class="admin-filters">
            <div class="admin-search">
                <Search class="admin-search-icon" />
                <input 
                    v-model="search"
                    type="text" 
                    placeholder="Rechercher une commande..."
                    class="admin-search-input"
                />
            </div>
            <select v-model="statusFilter" class="admin-select">
                <option value="all">Tous les statuts</option>
                <option value="pending">En attente</option>
                <option value="processing">En cours</option>
                <option value="delivered">Livrée</option>
                <option value="cancelled">Annulée</option>
            </select>
        </div>

        <!-- Orders Table -->
        <div class="admin-table-container">
            <div v-if="filteredOrders.length === 0" class="admin-empty">
                <ShoppingBag class="w-12 h-12" />
                <h3>Aucune commande</h3>
                <p>Les commandes de vos clients apparaîtront ici</p>
            </div>

            <div v-else class="admin-orders-list">
                <div v-for="order in filteredOrders" :key="order.id" class="admin-order-card">
                    <div class="admin-order-header">
                        <div class="admin-order-id">#{{ order.id }}</div>
                        <div class="admin-order-date">{{ new Date(order.created_at).toLocaleDateString() }}</div>
                    </div>
                    <div class="admin-order-body">
                        <div class="admin-order-customer">
                            <div class="admin-order-name">{{ order.user.name }}</div>
                            <div class="admin-order-email">{{ order.user.email }}</div>
                        </div>
                        <div class="admin-order-amount">
                            {{ Number(order.total_amount).toLocaleString() }} XAF
                        </div>
                        <div class="admin-order-badges">
                            <StatusBadge :status="order.payment_status" type="payment" />
                            <StatusBadge :status="order.status" type="order" />
                        </div>
                        <Link :href="`/admin/orders/${order.id}`" class="admin-order-link">
                            Détails
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
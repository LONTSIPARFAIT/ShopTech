<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import StatusBadge from '@/components/ui/StatusBadge.vue';
import { ArrowLeft, Package, User, CreditCard, Truck } from 'lucide-vue-next';

const props = defineProps<{
    order: any;
}>();

const form = useForm({
    status: props.order.status,
    payment_status: props.order.payment_status,
});

const updateOrder = () => {
    form.put(`/admin/orders/${props.order.id}`);
};
</script>

<template>
    <Head :title="`Commande #${order.id}`" />

    <div class="admin-order-detail">
        <Link href="/admin/orders" class="admin-back-btn">
            <ArrowLeft class="w-4 h-4" />
            Retour aux commandes
        </Link>

        <div class="admin-order-header">
            <div>
                <h1 class="admin-title">Commande #{{ order.id }}</h1>
                <p class="admin-subtitle">{{ new Date(order.created_at).toLocaleString() }}</p>
            </div>
            <div class="admin-order-statuses">
                <StatusBadge :status="order.payment_status" type="payment" />
                <StatusBadge :status="order.status" type="order" />
            </div>
        </div>

        <div class="admin-order-grid">
            <!-- Order Items -->
            <div class="admin-order-items">
                <div class="admin-card">
                    <div class="admin-card-header">
                        <Package class="w-5 h-5" />
                        <h2>Produits commandés</h2>
                    </div>
                    <div class="admin-items-list">
                        <div v-for="item in order.items" :key="item.id" class="admin-order-item">
                            <div class="admin-item-image">
                                <img v-if="item.product.featured_image" :src="item.product.featured_image.url" />
                                <div v-else class="admin-item-placeholder">
                                    <Package class="w-6 h-6" />
                                </div>
                            </div>
                            <div class="admin-item-info">
                                <div class="admin-item-name">{{ item.product.name }}</div>
                                <div class="admin-item-variant">{{ item.variant.name }}: {{ item.variant.value }}</div>
                            </div>
                            <div class="admin-item-price">
                                <div>{{ Number(item.price).toLocaleString() }} XAF</div>
                                <div class="admin-item-qty">Qté: {{ item.quantity }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="admin-order-total">
                        <span>Total de la commande</span>
                        <span>{{ Number(order.total_amount).toLocaleString() }} XAF</span>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="admin-order-sidebar">
                <!-- Customer Info -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <User class="w-5 h-5" />
                        <h2>Client</h2>
                    </div>
                    <div class="admin-customer-info">
                        <div class="admin-customer-avatar">
                            {{ order.user.name.charAt(0).toUpperCase() }}
                        </div>
                        <div>
                            <div class="admin-customer-name">{{ order.user.name }}</div>
                            <div class="admin-customer-email">{{ order.user.email }}</div>
                        </div>
                    </div>
                </div>

                <!-- Update Status -->
                <div class="admin-card">
                    <div class="admin-card-header">
                        <Truck class="w-5 h-5" />
                        <h2>Gérer le statut</h2>
                    </div>
                    <form @submit.prevent="updateOrder" class="admin-status-form">
                        <div class="admin-form-group">
                            <label>Statut commande</label>
                            <select v-model="form.status" class="admin-select">
                                <option value="pending">En attente</option>
                                <option value="processing">En cours</option>
                                <option value="delivered">Livrée</option>
                                <option value="cancelled">Annulée</option>
                            </select>
                        </div>
                        <div class="admin-form-group">
                            <label>Statut paiement</label>
                            <select v-model="form.payment_status" class="admin-select">
                                <option value="unpaid">Non payé</option>
                                <option value="paid">Payé</option>
                                <option value="failed">Échoué</option>
                            </select>
                        </div>
                        <button type="submit" :disabled="form.processing" class="admin-btn-primary">
                            {{ form.processing ? 'Chargement...' : 'Mettre à jour' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import StatusBadge from '@/components/ui/StatusBadge.vue';
import { ChevronLeft, Package, MapPin, CreditCard, Clock } from 'lucide-vue-next';

const props = defineProps<{
    order: any;
}>();

defineOptions({ layout: AppSidebarLayout });
</script>

<template>
    <Head :title="`Commande #${order.id}`" />

    <div class="user-order-detail">
        <!-- Header -->
        <div class="user-order-detail-header">
            <Link href="/orders" class="user-back-link">
                <ChevronLeft class="w-4 h-4" />
                Retour aux commandes
            </Link>
            <div class="user-order-detail-title">
                <h1>Commande #{{ order.id }}</h1>
                <StatusBadge :status="order.status" type="order" />
            </div>
            <div v-if="order.payment_status === 'unpaid'" class="user-order-pay-btn">
                <Link :href="`/payment/notchpay/init/${order.id}`" class="user-btn-primary">
                    Payer maintenant
                </Link>
            </div>
        </div>

        <div class="user-order-detail-grid">
            <!-- Order Items -->
            <div class="user-order-items">
                <div class="user-card">
                    <div class="user-card-header">
                        <Package class="w-5 h-5" />
                        <h2>Articles commandés</h2>
                    </div>
                    <div class="user-items-list">
                        <div v-for="item in order.items" :key="item.id" class="user-order-item">
                            <div class="user-item-image">
                                <img v-if="item.product.featured_image" :src="item.product.featured_image.url" />
                                <div v-else class="user-item-placeholder">
                                    <Package class="w-6 h-6" />
                                </div>
                            </div>
                            <div class="user-item-info">
                                <div class="user-item-name">{{ item.product.name }}</div>
                                <div class="user-item-variant">{{ item.variant.name }}: {{ item.variant.value }}</div>
                            </div>
                            <div class="user-item-price">
                                <div>{{ Number(item.price).toLocaleString() }} FCFA</div>
                                <div class="user-item-qty">Qté: {{ item.quantity }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="user-order-total">
                        <span>Total payé</span>
                        <span>{{ Number(order.total_amount).toLocaleString() }} FCFA</span>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="user-order-sidebar">
                <!-- Timeline -->
                <div class="user-card">
                    <div class="user-card-header">
                        <Clock class="w-5 h-5" />
                        <h2>Suivi</h2>
                    </div>
                    <div class="user-timeline">
                        <div class="user-timeline-item">
                            <div class="user-timeline-icon active">
                                <Clock class="w-4 h-4" />
                            </div>
                            <div>
                                <p class="user-timeline-title">Commande placée</p>
                                <p class="user-timeline-date">{{ new Date(order.created_at).toLocaleString() }}</p>
                            </div>
                        </div>
                        <div class="user-timeline-item" :class="{ active: order.payment_status === 'paid' }">
                            <div class="user-timeline-icon" :class="{ active: order.payment_status === 'paid' }">
                                <CreditCard class="w-4 h-4" />
                            </div>
                            <div>
                                <p class="user-timeline-title">Paiement</p>
                                <p class="user-timeline-date">
                                    <StatusBadge :status="order.payment_status" type="payment" />
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivery Address -->
                <div class="user-card">
                    <div class="user-card-header">
                        <MapPin class="w-5 h-5" />
                        <h2>Livraison</h2>
                    </div>
                    <div class="user-address">
                        <p class="user-address-name">{{ $page.props.auth.user.name }}</p>
                        <p>Yaoundé, Cameroun</p>
                        <p>Bastos, Avenue de l'Indépendance</p>
                        <p>+237 6XX XXX XXX</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
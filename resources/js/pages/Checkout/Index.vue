<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { store as checkoutStore } from '@/routes/checkout';
import ShopLayout from '@/layouts/ShopLayout.vue';
import { CreditCard, Truck } from 'lucide-vue-next';

const props = defineProps<{
    cart: any;
    total: number;
    discount: number;
}>();

const form = useForm({
    payment_method: 'notchpay',
    shipping_address: '',
    customer_phone: '',
});

const submit = () => {
    form.post(checkoutStore().url);
};
</script>

<template>
    <ShopLayout>
        <Head title="Paiement - ShopTech" />

        <div class="checkout-container">
            <h1 class="checkout-title">Finaliser votre commande</h1>

            <form @submit.prevent="submit" class="checkout-grid">
                <!-- Left Column -->
                <div class="checkout-form">
                    <!-- Delivery Info -->
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <Truck class="w-5 h-5" />
                            <h2>Informations de livraison</h2>
                        </div>
                        <div class="checkout-form-group">
                            <label>Adresse complète</label>
                            <textarea v-model="form.shipping_address" rows="3" placeholder="Quartier, Rue, Ville..." required></textarea>
                            <p v-if="form.errors.shipping_address" class="checkout-error">{{ form.errors.shipping_address }}</p>
                        </div>
                        <div class="checkout-form-group">
                            <label>Téléphone</label>
                            <input v-model="form.customer_phone" type="tel" placeholder="+237 ..." required />
                            <p v-if="form.errors.customer_phone" class="checkout-error">{{ form.errors.customer_phone }}</p>
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <CreditCard class="w-5 h-5" />
                            <h2>Méthode de paiement</h2>
                        </div>
                        <div class="checkout-payment-methods">
                            <label class="checkout-payment-option" :class="{ active: form.payment_method === 'notchpay' }">
                                <input type="radio" v-model="form.payment_method" value="notchpay" />
                                <div class="checkout-payment-option-content">
                                    <div class="flex items-center gap-2">
                                        <span>MTN / Orange Money</span>
                                        <div class="flex gap-1">
                                            <div class="px-1.5 py-0.5 bg-yellow-400 text-[8px] font-black rounded text-black">MTN</div>
                                            <div class="px-1.5 py-0.5 bg-orange-500 text-[8px] font-black rounded text-white">ORANGE</div>
                                        </div>
                                    </div>
                                    <small>Paiement sécurisé via Mobile Money</small>
                                </div>
                            </label>
                            <label class="checkout-payment-option" :class="{ active: form.payment_method === 'cod' }">
                                <input type="radio" v-model="form.payment_method" value="cod" />
                                <div class="checkout-payment-option-content">
                                    <span>Paiement à la livraison</span>
                                    <small>Payez en espèces à la réception</small>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Summary -->
                <div class="checkout-summary">
                    <div class="checkout-summary-card">
                        <h2>Résumé</h2>
                        <div class="checkout-summary-items">
                            <div v-for="item in cart.items" :key="item.id" class="checkout-summary-item">
                                <span>{{ item.product.name }} x{{ item.quantity }}</span>
                                <span>{{ (Number(item.variant?.price_override || item.product.base_price) * item.quantity).toLocaleString() }} XAF</span>
                            </div>
                        </div>
                        <div class="checkout-summary-divider"></div>
                        <div class="checkout-summary-total">
                            <span>Total</span>
                            <span>{{ (Number(total) || 0).toLocaleString() }} XAF</span>
                        </div>
                        <button type="submit" :disabled="form.processing" class="checkout-submit-btn">
                            {{ form.processing ? 'Traitement...' : 'Payer maintenant' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </ShopLayout>
</template>
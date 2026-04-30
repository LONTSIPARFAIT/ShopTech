<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import CartItem from '@/components/Shop/CartItem.vue';
import ShopLayout from '@/layouts/ShopLayout.vue';
import { update as cartUpdate, destroy as cartDestroy } from '@/routes/cart';
import { index as checkoutIndex } from '@/routes/checkout';
import { index as productsIndex } from '@/routes/products';
import { ShoppingBag, ArrowRight } from 'lucide-vue-next';

const props = defineProps<{
    cart: any;
    total: number;
    subtotal: number;
    discount: number;
}>();

const updateQuantity = (itemId: number, quantity: number) => {
    if (quantity < 1) return;
    router.patch(cartUpdate(itemId).url, { quantity });
};

const removeItem = (itemId: number) => {
    if (confirm('Retirer cet article ?')) {
        router.delete(cartDestroy(itemId).url);
    }
};
</script>

<template>
    <ShopLayout>
        <Head title="Mon Panier - ShopTech" />

        <div class="cart-container">
            <h1 class="cart-title">Mon panier</h1>

            <div v-if="cart.items.length > 0" class="cart-grid">
                <!-- Items -->
                <div class="cart-items">
                    <CartItem 
                        v-for="item in cart.items" 
                        :key="item.id"
                        :item="item"
                        @update="updateQuantity"
                        @remove="removeItem"
                    />
                </div>

                <!-- Summary -->
                <div class="cart-summary">
                    <div class="cart-summary-card">
                        <h2>Résumé</h2>
                        <div class="cart-summary-row">
                            <span>Sous-total</span>
                            <span>{{ (Number(subtotal) || 0).toLocaleString() }} XAF</span>
                        </div>
                        <div v-if="discount > 0" class="cart-summary-row discount">
                            <span>Réduction</span>
                            <span>- {{ (Number(discount) || 0).toLocaleString() }} XAF</span>
                        </div>
                        <div class="cart-summary-row">
                            <span>Livraison</span>
                            <span class="text-green-600">Gratuite</span>
                        </div>
                        <div class="cart-summary-divider"></div>
                        <div class="cart-summary-total">
                            <span>Total</span>
                            <span>{{ (Number(total) || 0).toLocaleString() }} XAF</span>
                        </div>
                        <Link :href="checkoutIndex().url" class="cart-checkout-btn">
                            Passer à la caisse <ArrowRight class="w-4 h-4" />
                        </Link>
                        <Link :href="productsIndex().url" class="cart-continue-link">
                            Continuer mes achats
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Empty Cart -->
            <div v-else class="cart-empty">
                <ShoppingBag class="w-16 h-16" />
                <h2>Votre panier est vide</h2>
                <p>Découvrez nos produits et trouvez votre bonheur</p>
                <Link :href="productsIndex().url" class="cart-empty-btn">Découvrir la boutique</Link>
            </div>
        </div>
    </ShopLayout>
</template>
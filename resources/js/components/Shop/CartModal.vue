<script setup lang="ts">
import { computed } from 'vue';
import { usePage, Link, router } from '@inertiajs/vue3';
import { 
    Dialog, 
    DialogContent, 
    DialogHeader, 
    DialogTitle, 
    DialogFooter,
    DialogClose 
} from '@/components/ui/dialog';
import { ShoppingBag, X, Plus, Minus, Trash2, ShoppingCart, ArrowRight, ShieldCheck } from 'lucide-vue-next';
import { update as cartUpdate, destroy as cartDestroy } from '@/routes/cart';
import { index as checkoutIndex } from '@/routes/checkout';
import { index as productsIndex } from '@/routes/products';

const page = usePage();
const cart = computed(() => (page.props as any).cart);
const cartCount = computed(() => (page.props as any).cartCount || 0);

const updateQuantity = (itemId: number, quantity: number) => {
    if (quantity < 1) return;
    router.patch(cartUpdate(itemId).url, { quantity }, {
        preserveScroll: true,
    });
};

const removeItem = (itemId: number) => {
    router.delete(cartDestroy(itemId).url, {
        preserveScroll: true,
    });
};
</script>

<template>
    <Dialog>
        <slot name="trigger" />
        
        <DialogContent class="cart-modal">
            <DialogHeader class="cart-modal-header">
                <div class="cart-modal-title-wrapper">
                    <DialogTitle class="cart-modal-title">
                        <div class="cart-modal-icon">
                            <ShoppingCart class="w-5 h-5" />
                        </div>
                        Mon panier
                        <span v-if="cartCount > 0" class="cart-modal-count">
                            {{ cartCount }}
                        </span>
                    </DialogTitle>
                    <DialogClose class="cart-modal-close">
                        <X class="w-5 h-5" />
                    </DialogClose>
                </div>
            </DialogHeader>

            <!-- Contenu -->
            <div class="cart-modal-content">
                <!-- État vide -->
                <div v-if="!cart || cart.items.length === 0" class="cart-empty">
                    <div class="cart-empty-icon">
                        <ShoppingBag class="w-12 h-12" />
                    </div>
                    <h3 class="cart-empty-title">Votre panier est vide</h3>
                    <p class="cart-empty-text">
                        Découvrez nos produits et trouvez votre bonheur.
                    </p>
                    <DialogClose as-child>
                        <Link :href="productsIndex().url" class="cart-empty-btn">
                            Découvrir la boutique
                        </Link>
                    </DialogClose>
                </div>

                <!-- Liste des articles -->
                <div v-else class="cart-items">
                    <div v-for="item in cart.items" :key="item.id" class="cart-item">
                        <div class="cart-item-image">
                            <img 
                                v-if="item.product.featured_image" 
                                :src="item.product.featured_image.path" 
                                :alt="item.product.name"
                            />
                            <div v-else class="cart-item-image-placeholder">
                                <ShoppingBag class="w-5 h-5" />
                            </div>
                        </div>
                        
                        <div class="cart-item-info">
                            <h4 class="cart-item-name">{{ item.product.name }}</h4>
                            <p v-if="item.variant" class="cart-item-variant">
                                {{ item.variant.name }}: {{ item.variant.value }}
                            </p>
                            <p class="cart-item-price">
                                {{ (Number(item.variant?.price_override || item.product.base_price)).toLocaleString() }} XAF
                            </p>
                            
                            <div class="cart-item-actions">
                                <div class="cart-quantity">
                                    <button 
                                        @click="updateQuantity(item.id, item.quantity - 1)"
                                        class="cart-quantity-btn"
                                    >
                                        <Minus class="w-3 h-3" />
                                    </button>
                                    <span class="cart-quantity-value">{{ item.quantity }}</span>
                                    <button 
                                        @click="updateQuantity(item.id, item.quantity + 1)"
                                        class="cart-quantity-btn"
                                    >
                                        <Plus class="w-3 h-3" />
                                    </button>
                                </div>
                                <button 
                                    @click="removeItem(item.id)" 
                                    class="cart-remove-btn"
                                >
                                    <Trash2 class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                        
                        <div class="cart-item-total">
                            <span class="cart-item-total-price">
                                {{ (Number(item.variant?.price_override || item.product.base_price) * item.quantity).toLocaleString() }}
                            </span>
                            <span class="cart-item-total-currency">XAF</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <DialogFooter v-if="cart && cart.items.length > 0" class="cart-modal-footer">
                <div class="cart-total">
                    <div class="cart-subtotal">
                        <span class="cart-subtotal-label">Sous-total</span>
                        <span class="cart-subtotal-value">{{ Number(cart.total).toLocaleString() }} XAF</span>
                    </div>
                    <div class="cart-divider"></div>
                    <div class="cart-grandtotal">
                        <span class="cart-grandtotal-label">Total à payer</span>
                        <span class="cart-grandtotal-value">
                            {{ Number(cart.total).toLocaleString() }} 
                            <span class="cart-grandtotal-currency">XAF</span>
                        </span>
                    </div>
                </div>
                
                <div class="cart-security">
                    <ShieldCheck class="w-4 h-4" />
                    <span>Paiement 100% sécurisé</span>
                </div>

                <DialogClose as-child>
                    <Link 
                        :href="checkoutIndex().url" 
                        class="cart-checkout-btn"
                    >
                        Passer à la caisse
                        <ArrowRight class="w-4 h-4" />
                    </Link>
                </DialogClose>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
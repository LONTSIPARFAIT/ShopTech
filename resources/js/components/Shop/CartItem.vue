<script setup lang="ts">
import { ShoppingBag, Minus, Plus, Trash2 } from 'lucide-vue-next';

const props = defineProps<{
    item: any;
}>();

const emit = defineEmits(['update', 'remove']);
</script>

<template>
    <div class="shop-cart-item-card">
        <div class="shop-cart-item-card-image">
            <img 
                v-if="item.product.featured_image" 
                :src="item.product.featured_image.url" 
                :alt="item.product.name"
            />
            <div v-else class="shop-cart-item-card-image-placeholder">
                <ShoppingBag class="w-6 h-6" />
            </div>
        </div>

        <div class="shop-cart-item-card-info">
            <h3 class="shop-cart-item-card-name">{{ item.product.name }}</h3>
            <p v-if="item.variant" class="shop-cart-item-card-variant">
                {{ item.variant.name }}: {{ item.variant.value }}
            </p>
            <p class="shop-cart-item-card-price">
                {{ (Number(item.product.base_price) + Number(item.variant?.price_override || 0)).toLocaleString() }} XAF
            </p>

            <div class="shop-cart-item-card-actions">
                <div class="shop-cart-quantity-stepper">
                <button 
                    @click="emit('update', item.id, item.quantity - 1)"
                    :disabled="item.quantity <= 1"
                    class="stepper-btn"
                >
                    <Minus class="w-3 h-3" />
                </button>
                <input 
                    type="number" 
                    :value="item.quantity" 
                    @input="(e) => {
                        const val = parseInt((e.target as HTMLInputElement).value);
                        if (val > 0) emit('update', item.id, val);
                    }"
                    min="1" 
                    class="stepper-input"
                />
                <button 
                    @click="emit('update', item.id, item.quantity + 1)"
                    class="stepper-btn"
                >
                    <Plus class="w-3 h-3" />
                </button>
            </div>
                <button 
                    @click="emit('remove', item.id)" 
                    class="shop-cart-item-card-remove"
                >
                    <Trash2 class="w-4 h-4" />
                </button>
            </div>
        </div>

        <div class="shop-cart-item-card-total">
            <span class="shop-cart-item-card-total-price">
                {{ ((Number(item.product.base_price) + Number(item.variant?.price_override || 0)) * item.quantity || 0).toLocaleString() }}
            </span>
            <span class="shop-cart-item-card-total-currency">XAF</span>
        </div>
    </div>
</template>
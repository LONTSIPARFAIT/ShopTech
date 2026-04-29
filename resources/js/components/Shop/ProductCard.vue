<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import products from '@/routes/products';
import { store as cartStore } from '@/routes/cart';
import { ShoppingCart, Eye } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
    product: any;
}>();

const discountPercent = computed(() => {
    const base = parseFloat(props.product.base_price);
    const orig = parseFloat(props.product.original_price);
    if (!base || !orig || orig <= base) return null;
    return Math.round((1 - base / orig) * 100);
});

const addToCart = () => {
    if (props.product.variants && props.product.variants.length > 0) {
        router.visit(products.show({ slug: props.product.slug }).url);
        return;
    }
    router.post(cartStore().url, { product_id: props.product.id, quantity: 1 }, { preserveScroll: true });
};
</script>

<template>
    <div class="product-card">
        <!-- Image Section -->
        <div class="product-card-image">
            <Link :href="products.show({ slug: product.slug }).url" class="product-card-link">
                <img
                    v-if="product.featured_image"
                    :src="product.featured_image.url"
                    :alt="product.name"
                    class="product-card-img"
                />
                <div v-else class="product-card-placeholder">
                    <ShoppingCart class="w-12 h-12" />
                </div>
            </Link>

            <!-- Category Badge -->
            <span class="product-card-badge">
                {{ product.category?.name }}
            </span>

            <!-- Discount Badge -->
            <span v-if="discountPercent" class="product-card-discount">
                -{{ discountPercent }}%
            </span>
        </div>

        <!-- Content -->
        <div class="product-card-content">
            <Link :href="products.show({ slug: product.slug }).url" class="product-card-title-link">
                <h3 class="product-card-title">{{ product.name }}</h3>
                <p class="product-card-description">{{ product.description }}</p>
            </Link>

            <div class="product-card-footer">
                <div class="product-card-price">
                    <span v-if="product.original_price" class="product-card-price-old">
                        {{ Number(product.original_price).toLocaleString() }} XAF
                    </span>
                    <div class="product-card-price-current">
                        <span class="product-card-price-value">
                            {{ Number(product.base_price).toLocaleString() }}
                        </span>
                        <span class="product-card-price-currency">XAF</span>
                    </div>
                </div>

                <button @click="addToCart" class="product-card-cart-btn">
                    <ShoppingCart class="w-4 h-4" />
                    <span>Ajouter</span>
                </button>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import { store as cartStore } from '@/routes/cart';
import { ShoppingBag, ChevronRight, Plus, Minus, ShieldCheck, Truck, RefreshCcw } from 'lucide-vue-next';
import ShopLayout from '@/Layouts/ShopLayout.vue';
import ProductCard from '@/components/Shop/ProductCard.vue';

const props = defineProps<{
    product: any;
    relatedProducts: any[];
}>();

const selectedVariant = ref(props.product.variants[0] || null);
const quantity = ref(1);
const activeImage = ref(props.product.images[0]?.path || null);

const totalPrice = computed(() => {
    if (selectedVariant.value && selectedVariant.value.price_override > 0) {
        return Number(selectedVariant.value.price_override);
    }
    return Number(props.product.base_price);
});

const discountPercent = computed(() => {
    if (!props.product.original_price) return null;
    return Math.round((1 - props.product.base_price / props.product.original_price) * 100);
});

const form = useForm({
    product_id: props.product.id,
    variant_id: selectedVariant.value?.id,
    quantity: quantity.value,
});

watch([selectedVariant, quantity], () => {
    form.variant_id = selectedVariant.value?.id;
    form.quantity = quantity.value;
});

const addToCart = () => {
    form.post(cartStore().url, { preserveScroll: true });
};

const buyNow = () => {
    form.post(cartStore().url, {
        onSuccess: () => { window.location.href = '/checkout'; }
    });
};
</script>

<template>
    <ShopLayout>
        <Head :title="`${product.name} - ShopTech`" />

        <div class="shop-product">
            <!-- Breadcrumbs -->
            <nav class="shop-breadcrumb">
                <Link href="/" class="shop-breadcrumb-link">Accueil</Link>
                <ChevronRight class="shop-breadcrumb-sep" />
                <Link href="/products" class="shop-breadcrumb-link">Boutique</Link>
                <ChevronRight class="shop-breadcrumb-sep" />
                <Link :href="`/products?category=${product.category.slug}`" class="shop-breadcrumb-link">
                    {{ product.category.name }}
                </Link>
                <ChevronRight class="shop-breadcrumb-sep" />
                <span class="shop-breadcrumb-current">{{ product.name }}</span>
            </nav>

            <!-- Product Main Section -->
            <div class="shop-product-main">
                <!-- Gallery -->
                <div class="shop-gallery">
                    <div class="shop-gallery-main">
                        <img 
                            v-if="activeImage" 
                            :src="activeImage" 
                            :alt="product.name"
                            class="shop-gallery-img"
                        />
                        <div v-else class="shop-gallery-placeholder">
                            <ShoppingBag class="w-24 h-24" />
                        </div>
                        <div v-if="discountPercent" class="shop-gallery-badge">
                            -{{ discountPercent }}%
                        </div>
                    </div>
                    
                    <div v-if="product.images.length > 1" class="shop-gallery-thumbs">
                        <button 
                            v-for="(image, index) in product.images" 
                            :key="index"
                            @click="activeImage = image.url"
                            class="shop-gallery-thumb"
                            :class="activeImage === image.url && 'shop-gallery-thumb-active'"
                        >
                            <img :src="image.url" />
                        </button>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="shop-product-info">
                    <div class="shop-product-meta">
                        <span class="shop-product-category">{{ product.category.name }}</span>
                        <span v-if="selectedVariant?.stock > 0" class="shop-product-stock">
                            En stock
                        </span>
                    </div>

                    <h1 class="shop-product-title">{{ product.name }}</h1>

                    <!-- Price -->
                    <div class="shop-product-price">
                        <span class="shop-product-price-current">
                            {{ totalPrice.toLocaleString() }} XAF
                        </span>
                        <span v-if="product.original_price" class="shop-product-price-old">
                            {{ Number(product.original_price).toLocaleString() }} XAF
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="shop-product-description">
                        <h3 class="shop-product-section-title">Description</h3>
                        <p class="shop-product-description-text">{{ product.description }}</p>
                    </div>

                    <!-- Variants -->
                    <div v-if="product.variants.length > 0" class="shop-product-variants">
                        <h3 class="shop-product-section-title">Options</h3>
                        <div class="shop-variants-list">
                            <button 
                                v-for="variant in product.variants" 
                                :key="variant.id"
                                @click="selectedVariant = variant"
                                class="shop-variant-btn"
                                :class="selectedVariant?.id === variant.id && 'shop-variant-btn-active'"
                            >
                                <div 
                                    v-if="variant.color_code" 
                                    class="shop-variant-color"
                                    :style="{ backgroundColor: variant.color_code }"
                                ></div>
                                <div class="shop-variant-info">
                                    <div class="shop-variant-name">{{ variant.name }}: {{ variant.value }}</div>
                                    <div v-if="variant.price_override > 0" class="shop-variant-price">
                                        {{ Number(variant.price_override).toLocaleString() }} XAF
                                    </div>
                                    <div v-else class="shop-variant-price">
                                        {{ Number(product.base_price).toLocaleString() }} XAF
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="shop-product-actions">
                        <div class="shop-quantity">
                            <button @click="quantity > 1 && quantity--" class="shop-quantity-btn">
                                <Minus class="w-4 h-4" />
                            </button>
                            <span class="shop-quantity-value">{{ quantity }}</span>
                            <button @click="quantity++" class="shop-quantity-btn">
                                <Plus class="w-4 h-4" />
                            </button>
                        </div>
                        
                        <div class="shop-action-buttons">
                            <button 
                                @click="addToCart"
                                :disabled="form.processing"
                                class="shop-cart-btn"
                            >
                                <ShoppingBag class="w-5 h-5" />
                                Ajouter au panier
                            </button>

                            <button 
                                @click="buyNow"
                                :disabled="form.processing"
                                class="shop-buy-btn"
                            >
                                Acheter maintenant
                            </button>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="shop-features">
                        <div class="shop-feature">
                            <Truck class="shop-feature-icon" />
                            <span class="shop-feature-text">Livraison express</span>
                        </div>
                        <div class="shop-feature">
                            <ShieldCheck class="shop-feature-icon" />
                            <span class="shop-feature-text">Garantie 2 ans</span>
                        </div>
                        <div class="shop-feature">
                            <RefreshCcw class="shop-feature-icon" />
                            <span class="shop-feature-text">Retour 30 jours</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <div v-if="relatedProducts.length > 0" class="shop-related">
                <h2 class="shop-related-title">Produits similaires</h2>
                <div class="shop-related-grid">
                    <ProductCard v-for="rel in relatedProducts" :key="rel.id" :product="rel" />
                </div>
            </div>
        </div>
    </ShopLayout>
</template>
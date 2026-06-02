<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import { store as cartStore } from '@/routes/cart';
import { ShoppingBag, ChevronRight, Plus, Minus, ShieldCheck, Truck, RefreshCcw, Check } from 'lucide-vue-next';
import ShopLayout from '@/layouts/ShopLayout.vue';
import ProductCard from '@/components/Shop/ProductCard.vue';

const props = defineProps<{
    product: any;
    relatedProducts: any[];
}>();

const selectedVariant = ref(props.product.variants[0] || null);
const quantity = ref(1);
const activeImage = ref(props.product.images[0]?.url || null);

const totalPrice = computed(() => {
    let unitPrice = Number(props.product.base_price);
    if (selectedVariant.value && selectedVariant.value.price_override > 0) {
        unitPrice += Number(selectedVariant.value.price_override);
    }
    return unitPrice * quantity.value;
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

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8 pt-24 md:pt-28">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 flex-wrap mb-6 text-xs font-semibold uppercase tracking-wider">
                <Link href="/" class="text-muted-foreground hover:text-primary transition-colors">Accueil</Link>
                <ChevronRight class="w-3 h-3 text-border" />
                <Link href="/products" class="text-muted-foreground hover:text-primary transition-colors">Boutique</Link>
                <ChevronRight class="w-3 h-3 text-border" />
                <Link :href="`/products?category=${product.category.slug}`" class="text-muted-foreground hover:text-primary transition-colors">
                    {{ product.category.name }}
                </Link>
                <ChevronRight class="w-3 h-3 text-border" />
                <span class="text-primary">{{ product.name }}</span>
            </nav>

            <!-- Product Main Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <!-- Gallery -->
                <div class="space-y-4">
                    <!-- Main image -->
                    <div class="relative aspect-square bg-secondary rounded-2xl overflow-hidden">
                        <img 
                            v-if="activeImage" 
                            :src="activeImage" 
                            :alt="product.name"
                            class="w-full h-full object-cover"
                        />
                        <div v-else class="w-full h-full flex items-center justify-center text-muted-foreground">
                            <ShoppingBag class="w-24 h-24" />
                        </div>
                        <div v-if="discountPercent" class="absolute top-4 left-4 px-3 py-1.5 bg-red-500 text-white rounded-lg text-sm font-bold">
                            -{{ discountPercent }}%
                        </div>
                    </div>
                    
                    <!-- Thumbnails -->
                    <div v-if="product.images.length > 1" class="grid grid-cols-4 gap-3">
                        <button 
                            v-for="(image, index) in product.images" 
                            :key="index"
                            @click="activeImage = image.url"
                            class="aspect-square rounded-xl overflow-hidden border-2 transition-all"
                            :class="activeImage === image.url ? 'border-primary' : 'border-border hover:border-primary/50'"
                        >
                            <img :src="image.url" class="w-full h-full object-cover" />
                        </button>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="space-y-5">
                    <!-- Meta -->
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="px-3 py-1 bg-secondary rounded-full text-xs font-semibold text-foreground">
                            {{ product.category.name }}
                        </span>
                        <span v-if="selectedVariant?.stock > 0" class="flex items-center gap-1.5 text-xs font-semibold text-green-600">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            En stock
                        </span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-2xl md:text-3xl font-bold text-foreground">{{ product.name }}</h1>

                    <!-- Price -->
                    <div class="flex items-baseline gap-3">
                        <span class="text-3xl font-black text-primary">
                            {{ totalPrice.toLocaleString() }} FCFA
                        </span>
                        <span v-if="product.original_price" class="text-lg text-muted-foreground line-through">
                            {{ Number(product.original_price).toLocaleString() }} FCFA
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="pt-3">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-muted-foreground mb-2">Description</h3>
                        <p class="text-sm text-muted-foreground leading-relaxed">{{ product.description }}</p>
                    </div>

                    <!-- Variants -->
                    <div v-if="product.variants.length > 0" class="pt-2">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-muted-foreground mb-3">Options</h3>
                        <div class="flex flex-wrap gap-3">
                            <button 
                                v-for="variant in product.variants" 
                                :key="variant.id"
                                @click="selectedVariant = variant"
                                class="flex items-center gap-2 px-4 py-2 rounded-xl border transition-all"
                                :class="selectedVariant?.id === variant.id 
                                    ? 'bg-primary border-primary text-white' 
                                    : 'bg-card border-border text-foreground hover:border-primary'"
                            >
                                <div 
                                    v-if="variant.color_code" 
                                    class="w-4 h-4 rounded-full"
                                    :style="{ backgroundColor: variant.color_code }"
                                ></div>
                                <span class="text-sm font-medium">{{ variant.name }}: {{ variant.value }}</span>
                                <span v-if="variant.price_override > 0" class="text-xs opacity-80">+{{ Number(variant.price_override).toLocaleString() }}</span>
                                <Check v-if="selectedVariant?.id === variant.id" class="w-3 h-3 ml-1" />
                            </button>
                        </div>
                    </div>

                    <!-- Quantity & Actions -->
                    <div class="space-y-4 pt-4">
                        <!-- Quantity -->
                        <div>
                            <label class="text-xs font-bold uppercase tracking-wider text-muted-foreground mb-2 block">Quantité</label>
                            <div class="inline-flex items-center bg-secondary rounded-xl border border-border">
                                <button @click="quantity > 1 && quantity--" class="w-10 h-10 flex items-center justify-center hover:bg-card rounded-l-xl transition-colors">
                                    <Minus class="w-4 h-4" />
                                </button>
                                <input 
                                    v-model.number="quantity" 
                                    type="number" 
                                    min="1" 
                                    class="w-16 h-10 text-center bg-transparent text-foreground focus:outline-none"
                                />
                                <button @click="quantity++" class="w-10 h-10 flex items-center justify-center hover:bg-card rounded-r-xl transition-colors">
                                    <Plus class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                        
                        <!-- Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button 
                                @click="addToCart"
                                :disabled="form.processing"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-secondary border border-border rounded-xl font-semibold text-foreground hover:bg-primary hover:text-white hover:border-primary transition-all disabled:opacity-50"
                            >
                                <ShoppingBag class="w-5 h-5" />
                                Ajouter au panier
                            </button>

                            <button 
                                @click="buyNow"
                                :disabled="form.processing"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-primary to-primary-dark text-white rounded-xl font-semibold transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-primary/30 disabled:opacity-50"
                            >
                                Acheter maintenant
                            </button>
                        </div>

                        <!-- Features -->
                        <div class="grid grid-cols-3 gap-3 pt-3">
                            <div class="flex flex-col items-center gap-2 p-3 bg-secondary rounded-xl">
                                <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center">
                                    <Truck class="w-4 h-4 text-primary" />
                                </div>
                                <span class="text-[10px] font-semibold uppercase text-center text-muted-foreground">Livraison<br>gratuite</span>
                            </div>
                            <div class="flex flex-col items-center gap-2 p-3 bg-secondary rounded-xl">
                                <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center">
                                    <ShieldCheck class="w-4 h-4 text-primary" />
                                </div>
                                <span class="text-[10px] font-semibold uppercase text-center text-muted-foreground">Garantie<br>2 ans</span>
                            </div>
                            <div class="flex flex-col items-center gap-2 p-3 bg-secondary rounded-xl">
                                <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center">
                                    <RefreshCcw class="w-4 h-4 text-primary" />
                                </div>
                                <span class="text-[10px] font-semibold uppercase text-center text-muted-foreground">Retour<br>30 jours</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <div v-if="relatedProducts.length > 0" class="pt-8 border-t border-border">
                <h2 class="text-xl font-bold text-foreground mb-6">Produits similaires</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                    <ProductCard v-for="rel in relatedProducts" :key="rel.id" :product="rel" />
                </div>
            </div>
        </div>
    </ShopLayout>
</template>
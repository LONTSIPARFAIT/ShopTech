<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps<{
    product: any;
    relatedProducts: Array<any>;
}>();

const selectedVariant = ref(props.product.variants[0] || null);

const totalPrice = computed(() => {
    let price = Number(props.product.base_price);
    if (selectedVariant.value && selectedVariant.value.price_override) {
        price = Number(selectedVariant.value.price_override);
    }
    return price;
});

const quantity = ref(1);

const form = useForm({
    product_id: props.product.id,
    variant_id: selectedVariant.value?.id,
    quantity: quantity.value,
});

const addToCart = () => {
    // Sera implémenté dans le module Panier
    alert('Ajouté au panier ! (Bientôt disponible)');
};
</script>

<template>
    <Head :title="`${product.name} - ShopTech`" />

    <div class="min-h-screen bg-white dark:bg-slate-950 transition-colors duration-300 pb-24">
        <div class="px-6 py-12 mx-auto max-w-7xl lg:px-12">
            <!-- Breadcrumbs -->
            <nav class="flex text-sm text-slate-500 mb-8 gap-2 items-center">
                <Link href="/products" class="hover:text-blue-600 transition-colors">Boutique</Link>
                <span>/</span>
                <Link :href="`/products?category=${product.category.slug}`" class="hover:text-blue-600 transition-colors">{{ product.category.name }}</Link>
                <span>/</span>
                <span class="text-slate-900 dark:text-white font-medium truncate">{{ product.name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <!-- Gallery -->
                <div class="space-y-4">
                    <div class="aspect-square bg-slate-100 dark:bg-slate-900 rounded-[2.5rem] overflow-hidden border border-slate-100 dark:border-slate-800 shadow-lg">
                        <img 
                            v-if="product.images.length > 0" 
                            :src="product.images[0].path" 
                            :alt="product.name"
                            class="w-full h-full object-cover"
                        />
                        <div v-else class="flex items-center justify-center h-full text-slate-300 dark:text-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    
                    <div v-if="product.images.length > 1" class="grid grid-cols-4 gap-4">
                        <div 
                            v-for="(image, index) in product.images" 
                            :key="index"
                            class="aspect-square rounded-2xl overflow-hidden border-2 cursor-pointer hover:border-blue-500 transition-all"
                            :class="index === 0 ? 'border-blue-500' : 'border-transparent bg-slate-50 dark:bg-slate-900'"
                        >
                            <img :src="image.path" class="w-full h-full object-cover" />
                        </div>
                    </div>
                </div>

                <!-- Info -->
                <div class="space-y-8">
                    <div class="space-y-4">
                        <div class="inline-flex px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-xs font-bold tracking-widest uppercase">
                            {{ product.category.name }}
                        </div>
                        <h1 class="text-4xl font-black tracking-tight sm:text-5xl leading-tight">{{ product.name }}</h1>
                        <p class="text-3xl font-black text-blue-600 dark:text-blue-400">
                            {{ totalPrice.toLocaleString() }} <span class="text-sm font-normal opacity-70">XAF</span>
                        </p>
                    </div>

                    <div class="space-y-4">
                        <h3 class="font-bold text-lg">Description</h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ product.description }}
                        </p>
                    </div>

                    <!-- Variants -->
                    <div v-if="product.variants.length > 0" class="space-y-4">
                        <h3 class="font-bold text-lg">Options</h3>
                        <div class="flex flex-wrap gap-3">
                            <button 
                                v-for="variant in product.variants" 
                                :key="variant.id"
                                @click="selectedVariant = variant"
                                class="px-6 py-3 rounded-2xl border-2 transition-all text-sm font-bold"
                                :class="selectedVariant?.id === variant.id 
                                    ? 'border-blue-600 bg-blue-50 dark:bg-blue-900/20 text-blue-600' 
                                    : 'border-slate-100 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-600 text-slate-600 dark:text-slate-300'"
                            >
                                {{ variant.name }}: {{ variant.value }}
                                <span v-if="variant.price_override" class="block text-[10px] font-normal opacity-70">
                                    {{ Number(variant.price_override).toLocaleString() }} XAF
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="pt-8 space-y-6 border-t border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-6">
                            <div class="flex items-center bg-slate-100 dark:bg-slate-900 rounded-2xl p-1 border border-slate-200 dark:border-slate-800">
                                <button @click="quantity > 1 && quantity--" class="w-12 h-12 flex items-center justify-center hover:bg-white dark:hover:bg-slate-800 rounded-xl transition-all">-</button>
                                <span class="w-12 text-center font-bold">{{ quantity }}</span>
                                <button @click="quantity++" class="w-12 h-12 flex items-center justify-center hover:bg-white dark:hover:bg-slate-800 rounded-xl transition-all">+</button>
                            </div>
                            <div class="text-sm text-slate-500">
                                <span class="font-bold text-slate-900 dark:text-white">{{ selectedVariant?.stock || 0 }}</span> en stock
                            </div>
                        </div>

                        <button 
                            @click="addToCart"
                            class="w-full py-5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-3xl font-black text-xl hover:opacity-90 transition-all shadow-2xl active:scale-[0.98] flex items-center justify-center gap-3 group"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Ajouter au Panier
                        </button>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <div v-if="relatedProducts.length > 0" class="mt-32 space-y-12">
                <h2 class="text-3xl font-black">Produits Similaires</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div v-for="rel in relatedProducts" :key="rel.id" class="group">
                        <Link :href="`/products/${rel.slug}`" class="space-y-4">
                            <div class="aspect-square bg-slate-50 dark:bg-slate-900 rounded-3xl overflow-hidden border border-slate-100 dark:border-slate-800 group-hover:shadow-lg transition-all">
                                <img v-if="rel.featured_image" :src="rel.featured_image.path" class="w-full h-full object-cover transition-transform group-hover:scale-105" />
                            </div>
                            <h4 class="font-bold group-hover:text-blue-600 transition-colors">{{ rel.name }}</h4>
                            <p class="text-sm font-black">{{ Number(rel.base_price).toLocaleString() }} XAF</p>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

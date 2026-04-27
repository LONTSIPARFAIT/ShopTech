<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import ProductCard from '@/components/Shop/ProductCard.vue';
import ShopHeader from '@/components/Shop/ShopHeader.vue';
import ShopFooter from '@/components/Shop/ShopFooter.vue';

const props = defineProps<{
    products: {
        data: any[];
        links: any[];
    };
    categories: any[];
    filters: any;
}>();
</script>

<template>
    <Head title="Catalogue - ShopTech" />

    <div class="min-h-screen bg-white dark:bg-slate-950 transition-colors duration-300">
        <ShopHeader />
        
        <div class="pt-32 pb-24 px-6 py-12 mx-auto max-w-7xl lg:px-12">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12">
                <div class="space-y-4">
                    <h1 class="text-4xl font-black tracking-tight sm:text-5xl">Notre Catalogue</h1>
                    <p class="text-slate-500 dark:text-slate-400 max-w-xl">
                        Explorez notre sélection de gadgets premium et d'innovations technologiques.
                    </p>
                </div>
                
                <!-- Filters (Simplifiés pour le moment) -->
                <div class="flex flex-wrap gap-2">
                    <Link 
                        href="/products"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-all"
                        :class="!filters.category ? 'bg-blue-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200'"
                    >
                        Tous
                    </Link>
                    <Link 
                        v-for="category in categories" 
                        :key="category.id"
                        :href="`/products?category=${category.slug}`"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-all"
                        :class="filters.category === category.slug ? 'bg-blue-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200'"
                    >
                        {{ category.name }}
                    </Link>
                </div>
            </div>

            <!-- Product Grid -->
            <div v-if="products.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <ProductCard 
                    v-for="product in products.data" 
                    :key="product.id"
                    :product="product"
                />
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-24 space-y-6">
                <div class="w-24 h-24 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto text-slate-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold">Aucun produit trouvé</h2>
                <p class="text-slate-500">Essayez de changer de catégorie ou revenez plus tard.</p>
                <Link href="/products" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-2xl font-bold shadow-lg shadow-blue-500/20 hover:bg-blue-700 transition-all">
                    Voir tous les produits
                </Link>
            </div>

            <!-- Pagination (Simplifiée) -->
            <div v-if="products.links.length > 3" class="mt-16 flex justify-center gap-2">
                <Link 
                    v-for="(link, index) in products.links" 
                    :key="index"
                    v-html="link.label"
                    :href="link.url || '#'"
                    class="px-4 py-2 rounded-xl text-sm transition-all"
                    :class="[
                        link.active ? 'bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-bold' : 'bg-white dark:bg-slate-800 text-slate-500 hover:bg-slate-100',
                        !link.url ? 'opacity-50 cursor-not-allowed' : ''
                    ]"
                />
            </div>
        </div>
        <ShopFooter />
    </div>
</template>

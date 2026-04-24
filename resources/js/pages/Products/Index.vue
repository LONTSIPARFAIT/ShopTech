<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { products_show } from '@/routes';

const props = defineProps<{
    products: {
        data: Array<any>;
        links: Array<any>;
    };
    categories: Array<any>;
    filters: any;
}>();
</script>

<template>
    <Head title="Catalogue - ShopTech" />

    <div class="min-h-screen bg-white dark:bg-slate-950 transition-colors duration-300">
        <div class="px-6 py-12 mx-auto max-w-7xl lg:px-12">
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
                <div 
                    v-for="product in products.data" 
                    :key="product.id"
                    class="group relative bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800/50 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden hover:-translate-y-2"
                >
                    <Link :href="products_show({ slug: product.slug })" class="block">
                        <div class="aspect-square bg-slate-100 dark:bg-slate-800 relative overflow-hidden">
                            <img 
                                v-if="product.featured_image" 
                                :src="product.featured_image.path" 
                                :alt="product.name"
                                class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110"
                            />
                            <div v-else class="flex items-center justify-center h-full text-slate-300 dark:text-slate-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            
                            <!-- Badges -->
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider bg-white/90 dark:bg-slate-900/90 backdrop-blur-sm rounded-full text-blue-600 shadow-sm">
                                    {{ product.category.name }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 space-y-3">
                            <h3 class="text-lg font-bold group-hover:text-blue-600 transition-colors line-clamp-1">
                                {{ product.name }}
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">
                                {{ product.description }}
                            </p>
                            <div class="flex items-center justify-between pt-2">
                                <div class="text-xl font-black text-slate-900 dark:text-white">
                                    {{ Number(product.base_price).toLocaleString() }} <span class="text-xs font-normal opacity-70">XAF</span>
                                </div>
                                <div class="w-10 h-10 bg-slate-900 dark:bg-white text-white dark:text-slate-950 rounded-xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </Link>
                </div>
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
    </div>
</template>

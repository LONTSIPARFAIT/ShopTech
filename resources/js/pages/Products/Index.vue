<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import ProductCard from '@/components/Shop/ProductCard.vue';
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Search, SlidersHorizontal, ChevronDown, FilterX } from 'lucide-vue-next';
import { debounce } from 'lodash';

const props = defineProps<{
    products: {
        data: any[];
        links: any[];
    };
    categories: any[];
    filters: any;
}>();

const search = ref(props.filters.search || '');
const sort = ref(props.filters.sort || 'latest');

const updateFilters = debounce(() => {
    router.get('/products', {
        search: search.value,
        category: props.filters.category,
        sort: sort.value
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    });
}, 500);

watch([search, sort], () => {
    updateFilters();
});
</script>

<template>
    <ShopLayout>
        <Head title="Catalogue - ShopTech" />

        <div class="pt-32 pb-24 px-6 mx-auto max-w-7xl lg:px-12 min-h-[80vh]">
            <!-- Header Section -->
            <div class="flex flex-col space-y-12 mb-16">
                <div class="space-y-4 text-center max-w-3xl mx-auto">
                    <h1 class="text-6xl font-black tracking-tight sm:text-7xl uppercase italic">
                        <span class="text-blue-600">The</span> Catalog
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 text-lg font-medium">
                        Dénichez les meilleures pépites technologiques parmi notre sélection rigoureuse.
                    </p>
                </div>

                <!-- Search & Filters Bar -->
                <div class="sticky top-24 z-40">
                    <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-2xl p-4 rounded-[2.5rem] shadow-2xl shadow-black/[0.05] border border-slate-100 dark:border-slate-800 flex flex-col lg:flex-row gap-6">
                        <!-- Search -->
                        <div class="relative flex-1 group">
                            <Search class="w-5 h-5 absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 transition-colors" />
                            <input 
                                v-model="search"
                                type="text" 
                                placeholder="Rechercher un produit, une marque..."
                                class="w-full pl-14 pr-6 py-5 bg-slate-50 dark:bg-slate-950 border-none rounded-[1.8rem] text-sm font-bold focus:ring-2 focus:ring-blue-500 transition-all placeholder:opacity-50"
                            />
                        </div>

                        <!-- Categories Navigation -->
                        <div class="flex items-center gap-3 overflow-x-auto no-scrollbar py-1">
                            <Link 
                                href="/products"
                                class="px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap"
                                :class="!filters.category ? 'bg-blue-600 text-white shadow-xl shadow-blue-500/20' : 'bg-slate-50 dark:bg-slate-950 text-slate-500 dark:text-slate-400 hover:bg-slate-100'"
                            >
                                Tous
                            </Link>
                            <Link 
                                v-for="category in categories" 
                                :key="category.id"
                                :href="`/products?category=${category.slug}&search=${search}&sort=${sort}`"
                                class="px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap"
                                :class="filters.category === category.slug ? 'bg-blue-600 text-white shadow-xl shadow-blue-500/20' : 'bg-slate-50 dark:bg-slate-950 text-slate-500 dark:text-slate-400 hover:bg-slate-100'"
                            >
                                {{ category.name }}
                            </Link>
                        </div>

                        <div class="h-10 w-px bg-slate-100 dark:bg-slate-800 hidden lg:block"></div>

                        <!-- Sort -->
                        <div class="relative min-w-[200px]">
                            <select 
                                v-model="sort"
                                class="w-full pl-8 pr-12 py-5 bg-slate-50 dark:bg-slate-950 border-none rounded-[1.8rem] text-[10px] font-black uppercase tracking-widest focus:ring-2 focus:ring-blue-500 appearance-none cursor-pointer"
                            >
                                <option value="latest">Nouveautés</option>
                                <option value="price_asc">Prix Croissant</option>
                                <option value="price_desc">Prix Décroissant</option>
                                <option value="name_asc">Nom A-Z</option>
                            </select>
                            <ChevronDown class="w-4 h-4 absolute right-8 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Meta -->
            <div class="mb-12 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <span class="w-3 h-3 bg-blue-600 rounded-full animate-pulse"></span>
                    <p class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                        {{ products.data.length }} pépites disponibles
                    </p>
                </div>
                <div class="h-px flex-1 mx-10 bg-slate-100 dark:bg-slate-800"></div>
                <div v-if="filters.category || search" class="flex items-center gap-4">
                    <Link href="/products" class="text-[10px] font-black uppercase tracking-widest text-red-500 flex items-center gap-2 hover:opacity-70 transition-opacity">
                        <FilterX class="w-4 h-4" /> Effacer
                    </Link>
                </div>
            </div>

            <!-- Product Grid -->
            <div v-if="products.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
                <ProductCard 
                    v-for="product in products.data" 
                    :key="product.id"
                    :product="product"
                />
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-40 space-y-10 bg-slate-50 dark:bg-slate-900/50 rounded-[4rem] border-2 border-dashed border-slate-200 dark:border-slate-800">
                <div class="w-32 h-32 bg-white dark:bg-slate-950 rounded-[2.5rem] flex items-center justify-center mx-auto text-slate-200 dark:text-slate-800 shadow-2xl">
                    <Search class="w-16 h-16" />
                </div>
                <div class="space-y-4">
                    <h2 class="text-4xl font-black italic uppercase">Introuvable</h2>
                    <p class="text-slate-500 font-medium max-w-sm mx-auto leading-relaxed">
                        Aucun produit ne semble correspondre à votre recherche. Pourquoi ne pas tenter une autre requête ?
                    </p>
                </div>
                <Link href="/products" class="inline-flex px-12 py-5 bg-blue-600 text-white rounded-3xl font-black uppercase tracking-widest text-xs shadow-2xl shadow-blue-500/30 hover:scale-105 transition-all">
                    Toutes les pépites
                </Link>
            </div>

            <!-- Pagination -->
            <div v-if="products.links.length > 3" class="mt-32 flex justify-center items-center gap-3">
                <Link 
                    v-for="(link, index) in products.links" 
                    :key="index"
                    v-html="link.label"
                    :href="link.url || '#'"
                    class="min-w-[60px] h-[60px] flex items-center justify-center rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all"
                    :class="[
                        link.active 
                            ? 'bg-slate-900 dark:bg-white text-white dark:text-slate-900 shadow-2xl scale-110' 
                            : 'bg-white dark:bg-slate-900 text-slate-400 hover:text-blue-600 hover:bg-slate-50 dark:hover:bg-slate-800',
                        !link.url ? 'opacity-20 cursor-not-allowed' : ''
                    ]"
                />
            </div>
        </div>
    </ShopLayout>
</template>


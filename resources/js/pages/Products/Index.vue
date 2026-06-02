<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Search, ChevronDown, FilterX, Grid3x3, List, X } from 'lucide-vue-next';
import { ref } from 'vue';
import ProductCard from '@/components/Shop/ProductCard.vue';
import ShopLayout from '@/layouts/ShopLayout.vue';

const props = defineProps<{
    products: {
        data: any[];
        links: any[];
    };
    categories: any[];
    subcategories: any[];
    filters: any;
}>();

const search = ref(props.filters.search || '');
const sort = ref(props.filters.sort || 'latest');

function debounce<T extends (...args: any[]) => void>(fn: T, delay = 500) {
    let timeout: ReturnType<typeof setTimeout> | null = null;
    return (...args: Parameters<T>) => {
        if (timeout) clearTimeout(timeout);
        timeout = setTimeout(() => fn(...args), delay);
    };
}

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
});

const clearFilters = () => {
    search.value = '';
    router.get('/products');
};
</script>

<template>
    <ShopLayout>
        <Head title="Catalogue - ShopTech" />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8 pt-24 md:pt-28">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-black tracking-tight text-foreground">
                    Notre <span class="text-primary">Catalogue</span>
                </h1>
                <p class="text-muted-foreground text-sm mt-2">
                    Découvrez notre sélection de produits de qualité
                </p>
            </div>

            <!-- Search & Filters -->
            <div class="bg-card border border-border rounded-2xl p-4 mb-8">
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Search -->
                    <div class="flex-1 relative">
                        <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" />
                        <input
                            v-model="search"
                            @input="updateFilters"
                            type="text"
                            placeholder="Rechercher un produit..."
                            class="w-full pl-11 pr-4 py-2.5 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-foreground placeholder:text-muted-foreground/50"
                        />
                    </div>

                    <!-- Sort -->
                    <div class="relative w-full md:w-48">
                        <select
                            v-model="sort"
                            @change="updateFilters"
                            class="w-full appearance-none px-4 py-2.5 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary text-foreground cursor-pointer"
                        >
                            <option value="latest">Nouveautés</option>
                            <option value="price_asc">Prix croissant</option>
                            <option value="price_desc">Prix décroissant</option>
                            <option value="name_asc">Nom A-Z</option>
                        </select>
                        <ChevronDown class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground pointer-events-none" />
                    </div>

                    <!-- Clear filters -->
                    <button v-if="filters.category || search" @click="clearFilters" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-500/10 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all">
                        <FilterX class="w-4 h-4" />
                        <span class="text-sm font-medium">Effacer</span>
                    </button>
                </div>

                <!-- Categories -->
                <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-border">
                    <Link
                        href="/products"
                        class="px-3 py-1.5 text-xs font-semibold rounded-full transition-all"
                        :class="!filters.category 
                            ? 'bg-primary text-white' 
                            : 'bg-secondary text-muted-foreground hover:bg-primary/10 hover:text-primary'"
                    >
                        Tous
                    </Link>
                    <Link
                        v-for="category in categories"
                        :key="category.id"
                        :href="`/products?category=${category.slug}`"
                        class="px-3 py-1.5 text-xs font-semibold rounded-full transition-all"
                        :class="filters.category === category.slug 
                            ? 'bg-primary text-white' 
                            : 'bg-secondary text-muted-foreground hover:bg-primary/10 hover:text-primary'"
                    >
                        {{ category.name }}
                    </Link>
                </div>
            </div>

            <!-- Sous-catégories -->
            <div v-if="subcategories.length > 0" class="mb-8">
                <h2 class="text-sm font-bold uppercase tracking-wider text-muted-foreground mb-4">Sous-catégories</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                    <Link
                        v-for="subcategory in subcategories"
                        :key="subcategory.id"
                        :href="`/products?category=${subcategory.slug}`"
                        class="group p-4 bg-card border border-border rounded-xl text-center hover:border-primary/50 hover:-translate-y-1 transition-all duration-300"
                    >
                        <h3 class="text-sm font-semibold text-foreground group-hover:text-primary">{{ subcategory.name }}</h3>
                        <p class="text-xs text-muted-foreground mt-1 line-clamp-1">{{ subcategory.description }}</p>
                    </Link>
                </div>
            </div>

            <!-- Results count -->
            <div class="flex items-center justify-between mb-6">
                <span class="text-sm text-muted-foreground">{{ products.data.length }} produit(s) trouvé(s)</span>
                <div class="w-px h-4 bg-border"></div>
                <span class="text-sm text-muted-foreground">Page {{ products.links?.find(l => l.active)?.label || 1 }}</span>
            </div>

            <!-- Product Grid -->
            <div v-if="products.data.length > 0" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                <ProductCard
                    v-for="product in products.data"
                    :key="product.id"
                    :product="product"
                />
            </div>

            <!-- Empty State -->
            <div v-else class="flex flex-col items-center justify-center py-16 text-center bg-card border border-border rounded-2xl">
                <div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                    <Search class="w-10 h-10 text-primary" />
                </div>
                <h3 class="text-lg font-bold text-foreground mb-2">Aucun produit trouvé</h3>
                <p class="text-sm text-muted-foreground max-w-md mb-6">
                    Aucun produit ne correspond à votre recherche. Essayez d'autres mots-clés ou parcourez notre catalogue.
                </p>
                <Link href="/products" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary to-primary-dark text-white font-bold rounded-xl transition-all hover:-translate-y-0.5">
                    Voir tous les produits
                </Link>
            </div>

            <!-- Pagination -->
            <div v-if="products.links && products.links.length > 3" class="flex justify-center gap-2 mt-8">
                <Link
                    v-for="(link, index) in products.links"
                    :key="index"
                    v-html="link.label"
                    :href="link.url || '#'"
                    class="w-10 h-10 flex items-center justify-center rounded-xl text-sm font-medium transition-all"
                    :class="link.active 
                        ? 'bg-primary text-white' 
                        : link.url 
                            ? 'bg-secondary text-foreground hover:bg-primary/10 hover:text-primary' 
                            : 'bg-secondary/50 text-muted-foreground cursor-not-allowed opacity-50'"
                />
            </div>
        </div>
    </ShopLayout>
</template>
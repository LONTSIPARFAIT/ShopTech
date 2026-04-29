<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import ProductCard from '@/components/Shop/ProductCard.vue';
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Search, ChevronDown, FilterX } from 'lucide-vue-next';
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

const clearFilters = () => {
    search.value = '';
    router.get('/products');
};
</script>

<template>
    <ShopLayout>
        <Head title="Catalogue - ShopTech" />

        <div class="shop-catalog">
            <!-- Header -->
            <div class="shop-catalog-header">
                <h1 class="shop-catalog-title">
                    <span class="text-blue-600">The</span> Catalog
                </h1>
                <p class="shop-catalog-subtitle">
                    Dénichez les meilleures pépites technologiques
                </p>
            </div>

            <!-- Search & Filters -->
            <div class="shop-catalog-filters">
                <!-- Search -->
                <div class="shop-search">
                    <Search class="shop-search-icon" />
                    <input 
                        v-model="search"
                        type="text" 
                        placeholder="Rechercher un produit..."
                        class="shop-search-input"
                    />
                </div>

                <!-- Categories -->
                <div class="shop-categories">
                    <Link 
                        href="/products"
                        class="shop-category-btn"
                        :class="!filters.category && 'shop-category-btn-active'"
                    >
                        Tous
                    </Link>
                    <Link 
                        v-for="category in categories" 
                        :key="category.id"
                        :href="`/products?category=${category.slug}`"
                        class="shop-category-btn"
                        :class="filters.category === category.slug && 'shop-category-btn-active'"
                    >
                        {{ category.name }}
                    </Link>
                </div>

                <!-- Sort & Clear -->
                <div class="shop-sort">
                    <select 
                        v-model="sort"
                        class="shop-sort-select"
                    >
                        <option value="latest">Nouveautés</option>
                        <option value="price_asc">Prix croissant</option>
                        <option value="price_desc">Prix décroissant</option>
                        <option value="name_asc">Nom A-Z</option>
                    </select>
                    <ChevronDown class="shop-sort-icon" />
                </div>

                <button v-if="filters.category || search" @click="clearFilters" class="shop-clear-btn">
                    <FilterX class="w-4 h-4" /> Effacer
                </button>
            </div>

            <!-- Results -->
            <div class="shop-results-meta">
                <span class="shop-results-count">{{ products.data.length }} produits</span>
                <span class="shop-results-line"></span>
            </div>

            <!-- Product Grid -->
            <div v-if="products.data.length > 0" class="shop-product-grid">
                <ProductCard 
                    v-for="product in products.data" 
                    :key="product.id"
                    :product="product"
                />
            </div>

            <!-- Empty State -->
            <div v-else class="shop-empty">
                <div class="shop-empty-icon">
                    <Search class="w-12 h-12" />
                </div>
                <h2 class="shop-empty-title">Aucun produit trouvé</h2>
                <p class="shop-empty-text">Essayez une autre recherche ou parcourez notre catalogue.</p>
                <Link href="/products" class="shop-empty-btn">Voir tous les produits</Link>
            </div>

            <!-- Pagination -->
            <div v-if="products.links.length > 3" class="shop-pagination">
                <Link 
                    v-for="(link, index) in products.links" 
                    :key="index"
                    v-html="link.label"
                    :href="link.url || '#'"
                    class="shop-pagination-link"
                    :class="{
                        'shop-pagination-link-active': link.active,
                        'shop-pagination-link-disabled': !link.url
                    }"
                />
            </div>
        </div>
    </ShopLayout>
</template>
<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import products from '@/routes/products';

defineProps<{
    category: {
        id: number;
        name: string;
        slug: string;
        image?: string;
        products_count: number;
    };
}>();
</script>

<template>
    <Link :href="products.index({ category: category.slug }).url" class="category-card">
        <div class="category-card-image">
            <img v-if="category.image" :src="category.image" :alt="category.name" />
            <div v-else class="category-card-placeholder"></div>
            <div class="category-card-overlay"></div>
        </div>
        <div class="category-card-content">
            <h4 class="category-card-title">{{ category.name }}</h4>
            <div class="flex items-center gap-3">
                <span class="category-card-badge">{{ category.products_count }} Articles</span>
                <div class="category-card-arrow">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </div>
    </Link>
</template>

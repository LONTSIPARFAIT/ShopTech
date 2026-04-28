<script setup lang="ts">
import { index as productsIndex } from '@/actions/App/Http/Controllers/ProductController';
import { Link } from '@inertiajs/vue3';

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
    <Link
        :href="productsIndex.url({ query: { category: category.slug } })"
        class="min-w-[220px] h-[280px] relative rounded-[2rem] overflow-hidden group flex-shrink-0"
    >
        <img
            v-if="category.image"
            :src="category.image"
            :alt="category.name"
            class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
        />
        <div v-else class="absolute inset-0 bg-gradient-to-br from-blue-100 to-indigo-200 dark:from-slate-800 dark:to-slate-700"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/20 to-transparent"></div>
        <div class="absolute bottom-6 left-6 text-white space-y-1">
            <h4 class="text-lg font-black uppercase italic">{{ category.name }}</h4>
            <p class="text-[10px] font-bold uppercase tracking-widest opacity-60">{{ category.products_count }} Articles</p>
        </div>
    </Link>
</template>
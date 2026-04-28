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
    <Link
        :href="products.index({ category: category.slug }).url"
        class="group relative h-[320px] rounded-[2.5rem] overflow-hidden flex flex-col justify-end p-8 transition-all duration-700 hover:-translate-y-2"
    >
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img
                v-if="category.image"
                :src="category.image"
                :alt="category.name"
                class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
            />
            <div v-else class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900"></div>
            <!-- Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent group-hover:via-black/40 transition-colors duration-500"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 space-y-2">
            <h4 class="text-2xl font-black text-white uppercase italic tracking-tight group-hover:text-blue-400 transition-colors">
                {{ category.name }}
            </h4>
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-[10px] font-black text-white uppercase tracking-widest border border-white/10">
                    {{ category.products_count }} Articles
                </span>
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center -translate-x-4 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-500">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" /></svg>
                </div>
            </div>
        </div>
    </Link>
</template>
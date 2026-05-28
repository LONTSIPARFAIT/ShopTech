<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import products from '@/routes/products';
import { ArrowRight } from 'lucide-vue-next';

defineProps<{
    category: {
        id: number;
        name: string;
        slug: string;
        description: string | null;
        image?: string;
        url?: string;
        products_count: number;
    };
}>();
</script>

<template>
    <Link
        :href="products.index({ category: category.slug }).url"
        class="group relative h-80 md:h-96 lg:h-[400px] rounded-xl overflow-hidden flex flex-col justify-end p-6 transition-all duration-300 hover:-translate-y-1 cursor-pointer no-underline"
    >
        <!-- Image -->
        <div class="absolute inset-0 z-0">
            <img
                v-if="category.url || category.image"
                :src="category.url || category.image"
                :alt="category.name"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                loading="lazy"
            />
            <div v-else class="w-full h-full bg-gradient-to-br from-secondary to-muted"></div>
            <!-- Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent transition-all duration-300 group-hover:from-black/90 group-hover:via-black/30"></div>
        </div>

        <!-- Contenu -->
        <div class="relative z-10 flex flex-col gap-2">
            <h4 class="text-xl md:text-2xl font-black uppercase italic text-white transition-colors duration-300 group-hover:text-primary">
                {{ category.name }}
            </h4>

            <!-- Description -->
            <p v-if="category.description" class="text-xs text-white/70 line-clamp-2 mb-2 leading-relaxed">
                {{ category.description }}
            </p>

            <div class="flex items-center gap-3">
                <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-[10px] font-black uppercase tracking-wider">
                    {{ category.products_count }} Articles
                </span>
                <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center -translate-x-2 opacity-0 transition-all duration-300 group-hover:translate-x-0 group-hover:opacity-100">
                    <ArrowRight class="w-4 h-4 text-white" />
                </div>
            </div>
        </div>
    </Link>
</template>

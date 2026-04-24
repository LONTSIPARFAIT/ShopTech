<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { products_show } from '@/routes';

const props = defineProps<{
    product: any;
}>();
</script>

<template>
    <div class="group relative bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800/50 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden hover:-translate-y-2">
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
</template>

<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import products from '@/routes/products';
import { store as cartStore } from '@/routes/cart';
import { ShoppingBag, Plus, Eye } from 'lucide-vue-next';

const props = defineProps<{
    product: any;
}>();

const addToCart = () => {
    // If product has variants, redirect to show page to pick one
    if (props.product.variants && props.product.variants.length > 0) {
        router.visit(products.show({ slug: props.product.slug }).url);
        return;
    }

    // Otherwise add directly
    router.post(cartStore().url, {
        product_id: props.product.id,
        quantity: 1
    }, {
        preserveScroll: true,
    });
};
</script>

<template>
    <div class="group relative bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800/50 shadow-sm hover:shadow-2xl transition-all duration-700 overflow-hidden hover:-translate-y-3">
        <!-- Image Section -->
        <div class="relative aspect-[4/5] bg-slate-50 dark:bg-slate-950 overflow-hidden">
            <Link :href="products.show({ slug: product.slug }).url" class="block w-full h-full">
                <img 
                    v-if="product.featured_image" 
                    :src="product.featured_image.path" 
                    :alt="product.name"
                    class="object-cover w-full h-full transition-transform duration-1000 group-hover:scale-110"
                />
                <div v-else class="flex items-center justify-center h-full text-slate-200 dark:text-slate-800">
                    <ShoppingBag class="w-24 h-24" />
                </div>
            </Link>
            
            <!-- Floating Actions -->
            <div class="absolute inset-x-6 bottom-6 flex items-center gap-3 translate-y-20 group-hover:translate-y-0 transition-transform duration-500">
                <button 
                    @click="addToCart"
                    class="flex-1 h-14 bg-blue-600 text-white rounded-2xl flex items-center justify-center gap-3 font-black text-[10px] uppercase tracking-widest shadow-xl shadow-blue-500/20 hover:bg-blue-700 transition-all active:scale-95"
                >
                    <Plus class="w-4 h-4" /> Ajouter
                </button>
                <Link 
                    :href="products.show({ slug: product.slug }).url"
                    class="w-14 h-14 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md text-slate-900 dark:text-white rounded-2xl flex items-center justify-center hover:bg-white transition-all shadow-xl active:scale-95"
                >
                    <Eye class="w-5 h-5" />
                </Link>
            </div>

            <!-- Category Badge -->
            <div class="absolute top-6 left-6">
                <span class="px-4 py-2 text-[8px] font-black uppercase tracking-[0.2em] bg-white/90 dark:bg-slate-900/90 backdrop-blur-md rounded-full text-blue-600 shadow-sm border border-slate-100 dark:border-slate-800">
                    {{ product.category.name }}
                </span>
            </div>

            <!-- Discount Badge -->
            <div v-if="product.original_price" class="absolute top-6 right-6">
                <div class="w-12 h-12 bg-red-500 text-white rounded-2xl flex flex-col items-center justify-center shadow-xl shadow-red-500/30">
                    <span class="text-[10px] font-black">-{{ Math.round((1 - (product.base_price / product.original_price)) * 100) }}%</span>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="p-8 space-y-6">
            <div class="space-y-2">
                <Link :href="products.show({ slug: product.slug }).url" class="block">
                    <h3 class="text-xl font-black tracking-tight group-hover:text-blue-600 transition-colors line-clamp-1 uppercase italic">
                        {{ product.name }}
                    </h3>
                </Link>
                <p class="text-xs text-slate-400 font-medium line-clamp-2 leading-relaxed h-8">
                    {{ product.description }}
                </p>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-slate-50 dark:border-slate-800/50">
                <div class="flex flex-col">
                    <span v-if="product.original_price" class="text-xs text-slate-400 line-through font-bold opacity-50 mb-0.5">
                        {{ Number(product.original_price).toLocaleString() }} XAF
                    </span>
                    <div class="text-2xl font-black text-slate-900 dark:text-white flex items-baseline gap-1">
                        {{ Number(product.base_price).toLocaleString() }}
                        <span class="text-[9px] font-black uppercase tracking-widest text-blue-600">XAF</span>
                    </div>
                </div>

                <!-- Small Add Button (Fallback/Always visible on mobile) -->
                <button 
                    @click="addToCart"
                    class="lg:hidden w-12 h-12 bg-blue-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20 active:scale-90"
                >
                    <Plus class="w-6 h-6" />
                </button>
            </div>
        </div>
    </div>
</template>


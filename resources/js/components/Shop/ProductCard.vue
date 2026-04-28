<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import products from '@/routes/products';
import { store as cartStore } from '@/routes/cart';
import { ShoppingCart, Eye, Tag } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
    product: any;
}>();

const discountPercent = computed(() => {
    const base = parseFloat(props.product.base_price);
    const orig = parseFloat(props.product.original_price);
    if (!base || !orig || orig <= base) return null;
    return Math.round((1 - base / orig) * 100);
});

const addToCart = () => {
    if (props.product.variants && props.product.variants.length > 0) {
        router.visit(products.show({ slug: props.product.slug }).url);
        return;
    }
    router.post(cartStore().url, { product_id: props.product.id, quantity: 1 }, { preserveScroll: true });
};
</script>

<template>
    <div class="group relative bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800/50 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden hover:-translate-y-2">
        <!-- Image -->
        <div class="relative aspect-square bg-slate-50 dark:bg-slate-950 overflow-hidden">
            <Link :href="products.show({ slug: product.slug }).url" class="block w-full h-full">
                <img
                    v-if="product.featured_image"
                    :src="product.featured_image.path"
                    :alt="product.name"
                    class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110"
                />
                <div v-else class="flex items-center justify-center h-full text-slate-200 dark:text-slate-800">
                    <ShoppingCart class="w-16 h-16" />
                </div>
            </Link>

            <!-- Hover Actions -->
            <div class="absolute inset-x-3 bottom-3 flex items-center gap-2 translate-y-14 group-hover:translate-y-0 transition-transform duration-400">
                <button
                    @click="addToCart"
                    class="flex-1 h-11 bg-blue-600 text-white rounded-xl flex items-center justify-center gap-2 font-black text-[10px] uppercase tracking-widest shadow-lg shadow-blue-500/20 hover:bg-blue-700 transition-all active:scale-95"
                >
                    <ShoppingCart class="w-3.5 h-3.5" /> Ajouter
                </button>
                <Link
                    :href="products.show({ slug: product.slug }).url"
                    class="w-11 h-11 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md rounded-xl flex items-center justify-center hover:bg-white transition-all shadow-lg active:scale-95"
                >
                    <Eye class="w-4 h-4" />
                </Link>
            </div>

            <!-- Category Badge -->
            <div class="absolute top-3 left-3">
                <span class="px-2.5 py-1 text-[8px] font-black uppercase tracking-[0.2em] bg-white/90 dark:bg-slate-900/90 backdrop-blur-md rounded-full text-blue-600 shadow-sm border border-slate-100 dark:border-slate-800">
                    {{ product.category?.name }}
                </span>
            </div>

            <!-- Discount Badge -->
            <div v-if="discountPercent" class="absolute top-3 right-3">
                <div class="flex items-center gap-1 px-2 py-1 bg-red-500 text-white rounded-xl shadow-lg shadow-red-500/30">
                    <Tag class="w-2.5 h-2.5" />
                    <span class="text-[9px] font-black">-{{ discountPercent }}%</span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-5 space-y-3">
            <Link :href="products.show({ slug: product.slug }).url" class="block space-y-1">
                <h3 class="text-sm font-black tracking-tight group-hover:text-blue-600 transition-colors line-clamp-1 leading-snug">
                    {{ product.name }}
                </h3>
                <p class="text-[10px] text-slate-500 dark:text-slate-400 line-clamp-2 font-medium leading-relaxed">
                    {{ product.description }}
                </p>
            </Link>

            <div class="flex items-end justify-between">
                <!-- Prices -->
                <div class="flex flex-col">
                    <span v-if="product.original_price" class="text-[10px] text-slate-400 line-through font-semibold">
                        {{ Number(product.original_price).toLocaleString() }} XAF
                    </span>
                    <div class="flex items-baseline gap-1">
                        <span class="text-lg font-black text-slate-900 dark:text-white">
                            {{ Number(product.base_price).toLocaleString() }}
                        </span>
                        <span class="text-[8px] font-black uppercase tracking-widest text-blue-600">XAF</span>
                    </div>
                </div>

                <!-- Mobile add button -->
                <button
                    @click="addToCart"
                    class="lg:hidden w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center shadow-md shadow-blue-500/20 active:scale-90"
                >
                    <ShoppingCart class="w-4 h-4" />
                </button>
            </div>
        </div>
    </div>
</template>

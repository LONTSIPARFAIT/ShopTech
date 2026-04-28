<template>
    <SectionWrapper 
        v-if="products.length > 0"
        title="Offres Spéciales" 
        badge="Exclusive deals" 
        :badge-icon="Star"
        :view-all-link="productsIndex.url()"
        bg-class="bg-slate-50/50 dark:bg-slate-900/30"
    >
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            <ProductCard 
                v-for="product in products" 
                :key="product.id" 
                :product="product" 
            />
        </div>
    </SectionWrapper>
</template>

<script setup lang="ts">
import { index as productsIndex } from '@/actions/App/Http/Controllers/ProductController';
import ProductCard from '@/components/Shop/ProductCard.vue';
import SectionWrapper from '@/layouts/SectionWrapper.vue';
import HorizontalSlider from '@/components/Slider/HorizontalSlider.vue';
import { Star } from 'lucide-vue-next';

defineProps<{
    products: any[];
}>();
</script>
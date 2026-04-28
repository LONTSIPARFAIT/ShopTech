<template>
    <SectionWrapper 
        title="Nouveautés" 
        badge="Just arrived" 
        :badge-icon="Zap"
        :view-all-link="productsIndex.url()"
        bg-class="bg-white dark:bg-slate-950"
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
import { Zap } from 'lucide-vue-next';
import SectionWrapper from '@/layouts/SectionWrapper.vue';
import ProductCard from '@/components/Shop/ProductCard.vue';
import HorizontalSlider from '@/components/Slider/HorizontalSlider.vue';

defineProps<{
    products: any[];
}>();
</script>
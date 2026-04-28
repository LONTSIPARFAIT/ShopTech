<template>
    <SectionWrapper 
        v-if="products.length > 0"
        title="Offres Spéciales" 
        badge="Exclusive deals" 
        :badge-icon="Star"
        :view-all-link="productsIndex.url()"
        bg-class="bg-slate-50/50 dark:bg-slate-900/30"
    >
        <MarqueeSlider :items="products" duration="60s" item-width="280px">
            <template #default="{ item }">
                <ProductCard :product="item" />
            </template>
        </MarqueeSlider>
    </SectionWrapper>
</template>

<script setup lang="ts">
import { index as productsIndex } from '@/actions/App/Http/Controllers/ProductController';
import ProductCard from '@/components/Shop/ProductCard.vue';
import SectionWrapper from '@/layouts/SectionWrapper.vue';
import MarqueeSlider from '@/components/Slider/MarqueeSlider.vue';
import { Star } from 'lucide-vue-next';

defineProps<{
    products: any[];
}>();
</script>
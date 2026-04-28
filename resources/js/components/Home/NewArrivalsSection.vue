<template>
    <SectionWrapper 
        title="Nouveautés" 
        badge="Just arrived" 
        :badge-icon="Zap"
        :view-all-link="productsIndex.url()"
        bg-class="bg-white dark:bg-slate-950"
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
import { Zap } from 'lucide-vue-next';
import SectionWrapper from '@/layouts/SectionWrapper.vue';
import ProductCard from '@/components/Shop/ProductCard.vue';
import MarqueeSlider from '@/components/Slider/MarqueeSlider.vue';

defineProps<{
    products: any[];
}>();
</script>
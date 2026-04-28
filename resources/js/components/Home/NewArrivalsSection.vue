<template>
    <SectionWrapper 
        title="Nouveautés" 
        badge="Just arrived" 
        :badge-icon="Zap"
        :view-all-link="productsIndex.url()"
    >
        <HorizontalSlider :items="products" card-width="280px" show-progress>
            <template #default="{ item }">
                <ProductCard :product="item" />
            </template>
        </HorizontalSlider>
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
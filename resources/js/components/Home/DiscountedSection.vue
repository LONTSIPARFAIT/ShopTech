<template>
    <SectionWrapper 
        v-if="products.length > 0"
        title="Offres Spéciales" 
        badge="Exclusive deals" 
        :badge-icon="Star"
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
import ProductCard from '@/components/Shop/ProductCard.vue';
import SectionWrapper from '@/layouts/SectionWrapper.vue';
import HorizontalSlider from '@/components/Slider/HorizontalSlider.vue';
import { Star } from 'lucide-vue-next';

defineProps<{
    products: any[];
}>();
</script>
<template>
    <SectionWrapper 
        title="Par Catégories" 
        badge="Collections" 
        :badge-icon="Layers"
        bg-class="bg-white dark:bg-slate-950"
    >
        <MarqueeSlider :items="categories" duration="40s" item-width="280px">
            <template #default="{ item }">
                <CategoryCard :category="item" />
            </template>
        </MarqueeSlider>
    </SectionWrapper>
</template>

<script setup lang="ts">
import CategoryCard from '@/components/Home/CategoryCard.vue';
import SectionWrapper from '@/layouts/SectionWrapper.vue';
import MarqueeSlider from '@/components/Slider/MarqueeSlider.vue';
import { Layers } from 'lucide-vue-next';

defineProps<{
    categories: any[];
}>();
</script>
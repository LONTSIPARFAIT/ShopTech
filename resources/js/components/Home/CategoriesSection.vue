<template>
    <SectionWrapper 
        title="Par Catégories" 
        badge="Collections" 
        :subtitle="subtitle"
        :badge-icon="Layers"
        bg-class="bg-white dark:bg-slate-950"
    >
        <HorizontalSlider :items="categories" card-width="280px" show-progress>
            <template #default="{ item }">
                <CategoryCard :category="item" />
            </template>
        </HorizontalSlider>
    </SectionWrapper>
</template>

<script setup lang="ts">
import CategoryCard from '@/components/Home/CategoryCard.vue';
import SectionWrapper from '@/layouts/SectionWrapper.vue';
import HorizontalSlider from '@/components/Slider/HorizontalSlider.vue';
import { Layers } from 'lucide-vue-next';

defineProps<{
    categories: any[];
    subtitle?: string;
}>();
</script>
<template>
    <SectionWrapper 
        title="Par Catégories" 
        badge="Collections" 
        :badge-icon="Layers"
        bg-class="bg-slate-50/50 dark:bg-slate-900/30"
    >
        <HorizontalSlider :items="categories" card-width="220px" show-progress>
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
}>();
</script>
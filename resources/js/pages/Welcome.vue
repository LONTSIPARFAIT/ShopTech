<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import NewArrivalsSection from '@/components/Home/NewArrivalsSection.vue';
import TechFocusSection from '@/components/Home/TechFocusSection.vue';
import DiscountedSection from '@/components/Home/DiscountedSection.vue';
import CategoriesSection from '@/components/Home/CategoriesSection.vue';
import HeroSection from '@/components/Home/HeroSection.vue';
import StatsSection from '@/components/Home/StatsSection.vue';
import FeaturesSection from '@/components/Home/FeaturesSection.vue';
import ShopLayout from '@/layouts/ShopLayout.vue';


defineProps<{
    canRegister: boolean;
    newArrivals: any[];
    discountedProducts: any[];
    categories: any[];
}>();
</script>

<template>
    <ShopLayout>
        <Head title="Bienvenue chez ShopTech - L'excellence Technologique" />

        <HeroSection />
        <StatsSection />
        <CategoriesSection :categories="categories" />
        <DiscountedSection :products="discountedProducts" />
        <NewArrivalsSection :products="newArrivals" />
        <TechFocusSection />
        <FeaturesSection />
    </ShopLayout>
</template>
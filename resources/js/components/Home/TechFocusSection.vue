<template>
    <section class="py-20 bg-slate-950 text-white rounded-[3rem] mx-6 lg:mx-12 overflow-hidden relative">
        <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_30%_30%,#1e3a8a_0%,transparent_50%)] opacity-30"></div>
        <div class="max-w-7xl mx-auto px-10 lg:px-12 relative z-10 space-y-14">
            <div class="max-w-2xl space-y-4">
                <h2 class="text-4xl font-black uppercase italic leading-[0.9]">La Technologie <br/><span class="text-blue-500">Sans Compromis</span></h2>
                <p class="text-slate-400 font-medium">Nous collaborons avec les plus grandes marques pour vous offrir le meilleur de l'innovation mondiale.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <TechCard
                    v-for="tech in techItems"
                    :key="tech.title"
                    :icon="tech.icon"
                    :title="tech.title"
                    :description="tech.description"
                    :icon-color="tech.iconColor"
                />
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import TechCard from '@/Components/Home/TechCard.vue';
import { Smartphone, Cpu, Headphones } from 'lucide-vue-next';

const techItems = [
    {
        icon: Smartphone,
        iconColor: 'blue',
        title: 'Smartphones',
        description: 'Dernières sorties des gammes iPhone, Samsung et Google Pixel.'
    },
    {
        icon: Cpu,
        iconColor: 'purple',
        title: 'Informatique',
        description: 'Stations de travail surpuissantes et laptops ultra-portables.'
    },
    {
        icon: Headphones,
        iconColor: 'emerald',
        title: 'Accessoires',
        description: 'Audio haute fidélité et périphériques gaming de précision.'
    }
];
</script>
<template>
    <section class="tech-focus">
        <div class="tech-focus-bg"></div>
        <div class="tech-focus-container">
            <div class="tech-focus-header">
                <h2 class="tech-focus-title">La Technologie <br/><span>Sans Compromis</span></h2>
                <p class="tech-focus-subtitle">Nous collaborons avec les plus grandes marques pour vous offrir le meilleur de l'innovation mondiale.</p>
            </div>
            <div class="tech-focus-grid">
                <TechCard v-for="tech in techItems" :key="tech.title" v-bind="tech" />
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import TechCard from '@/components/Home/TechCard.vue';
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
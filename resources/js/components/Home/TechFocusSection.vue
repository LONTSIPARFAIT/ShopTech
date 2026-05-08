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
import { Wrench, Zap, Hammer } from 'lucide-vue-next';
import TechCard from '@/components/Home/TechCard.vue';

const techItems = [
    {
        icon: Wrench,
        iconColor: 'blue',
        title: 'Plomberie',
        description: 'Solutions d\'adduction d\'eau et d\'évacuation durables et fiables.'
    },
    {
        icon: Zap,
        iconColor: 'amber',
        title: 'Électricité',
        description: 'Matériel haute performance pour des installations électriques sûres.'
    },
    {
        icon: Hammer,
        iconColor: 'red',
        title: 'Outillage',
        description: 'Outils robustes pour professionnels exigeants et bricoleurs passionnés.'
    }
];
</script>
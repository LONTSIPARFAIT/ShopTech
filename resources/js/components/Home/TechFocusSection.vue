<template>
    <section class="relative py-16 md:py-20 overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
        <!-- Effets de fond -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-orange-500/8 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-orange-600/5 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- En-tête -->
            <div class="text-center max-w-2xl mx-auto mb-12">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-500/10 border border-orange-500/20 mb-5">
                    <span class="w-1 h-1 bg-orange-500 rounded-full"></span>
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-orange-400">Notre expertise</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">
                    La technologie <span class="text-orange-500">sans compromis</span>
                </h2>
                <p class="text-slate-300 text-sm max-w-md mx-auto">
                    Les meilleures marques pour vos projets
                </p>
            </div>

            <!-- Grille -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <TechCard
                    v-for="tech in techItems"
                    :key="tech.title"
                    :icon="tech.icon"
                    :title="tech.title"
                    :description="tech.description"
                />
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
        title: 'Plomberie',
        description: 'Solutions d\'adduction d\'eau et d\'évacuation durables et fiables.'
    },
    {
        icon: Zap,
        title: 'Électricité',
        description: 'Matériel haute performance pour des installations électriques sûres.'
    },
    {
        icon: Hammer,
        title: 'Outillage',
        description: 'Outils robustes pour professionnels exigeants.'
    }
];
</script>

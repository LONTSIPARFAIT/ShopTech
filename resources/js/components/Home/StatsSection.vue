<template>
    <section class="home-stats">
        <div class="home-stats-container">
            <div class="home-stats-grid">
                <div v-for="(stat, index) in stats" :key="index" class="home-stat-item">
                    <div class="flex flex-col items-center space-y-2">
                        <span class="home-stat-value">{{ stat.value }}</span>
                        <span class="home-stat-label">{{ stat.label }}</span>
                    </div>
                    <div v-if="index < stats.length - 1" class="home-stat-divider"></div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
const stats = [
    { value: '15K+', label: 'Clients Heureux' },
    { value: '500+', label: 'Dernières Pépites' },
    { value: '24H', label: 'Livraison Rapide' },
    { value: '100%', label: 'Paiement Sécurisé' }
];
</script>
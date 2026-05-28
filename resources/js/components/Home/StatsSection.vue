<template>
    <section class="py-8 md:py-12 bg-card border-t border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <div v-for="stat in stats" :key="stat.label" class="text-center">
                    <div class="flex flex-col items-center gap-1 sm:gap-2">
                        <!-- Valeur avec la couleur primary (orange) -->
                        <span class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight" style="color: var(--primary)">
                            {{ stat.value }}
                        </span>
                        <!-- Label avec la couleur muted-foreground -->
                        <span class="text-[10px] sm:text-xs font-semibold uppercase tracking-wider" style="color: var(--muted-foreground)">
                            {{ stat.label }}
                        </span>
                    </div>
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

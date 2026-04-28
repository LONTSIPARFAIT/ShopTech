<template>
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <FeatureCard
                    :icon="Truck"
                    title="Livraison Partout"
                    description="Peu importe où vous vous trouvez au Cameroun, nous vous livrons vos produits préférés en un temps record avec un suivi en temps réel."
                    variant="primary"
                />
                <FeatureCard
                    :icon="ShieldCheck"
                    title="Garantie Officielle"
                    description="Tous nos produits bénéficient d'une garantie constructeur officielle pour votre tranquillité d'esprit."
                    variant="light"
                />
                <FeatureCard
                    :icon="Zap"
                    title="SAV Expert"
                    description="Une équipe de techniciens à votre écoute pour toute assistance technique ou question sur vos produits."
                    variant="dark"
                />
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { Truck, ShieldCheck, Zap } from 'lucide-vue-next';
import FeatureCard from '@/components/Home/FeatureCard.vue';
</script>
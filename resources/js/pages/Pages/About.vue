<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import ShopLayout from '@/layouts/ShopLayout.vue';
import { Shield, Zap, Award, Users, MapPin, CheckCircle } from 'lucide-vue-next';

defineOptions({ layout: ShopLayout });

// ✅ Déplacer les tableaux dans le script
const stats = [
    { value: '500+', label: 'Produits' },
    { value: '2 000+', label: 'Clients' },
    { value: '5 ans', label: "D'expérience" },
    { value: '48h', label: 'Livraison' }
];

const values = [
    { icon: Shield, title: 'Qualité garantie', desc: 'Tous nos produits sont soigneusement vérifiés avant livraison.', iconBg: 'bg-orange-100 dark:bg-orange-950/30', iconColor: 'text-primary' },
    { icon: Zap, title: 'Livraison rapide', desc: 'Expédition sous 24h dans tout le Cameroun.', iconBg: 'bg-amber-100 dark:bg-amber-950/30', iconColor: 'text-amber-500' },
    { icon: Award, title: 'Marques premium', desc: 'Partenaires officiels des grandes marques mondiales.', iconBg: 'bg-purple-100 dark:bg-purple-950/30', iconColor: 'text-purple-500' },
    { icon: Users, title: 'Support humain', desc: 'Une équipe disponible 6j/7 pour vous accompagner.', iconBg: 'bg-green-100 dark:bg-green-950/30', iconColor: 'text-green-500' }
];

const advantages = [
    'Produits authentiques avec garantie constructeur',
    'Paiement sécurisé (Mobile Money, Orange Money)',
    'Service après-vente disponible pendant 12 mois',
    'Retours gratuits sous 7 jours',
    'Livraison gratuite à partir de 50 000 XAF'
];
</script>

<template>
    <Head title="À propos – ShopTech" />

    <div class="pt-20">
        <!-- Hero -->
        <section class="relative py-16 md:py-24 overflow-hidden bg-gradient-to-br from-orange-50/50 to-white dark:from-slate-900 dark:to-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <span class="inline-block px-3 py-1.5 rounded-full bg-orange-100 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 text-xs font-bold uppercase tracking-wider mb-4">
                    Notre Histoire
                </span>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-foreground mb-4">
                    Qui sommes-<span class="text-primary">nous ?</span>
                </h1>
                <p class="text-muted-foreground text-base md:text-lg max-w-2xl mx-auto">
                    ShopTech est né d'une passion pour la technologie et d'une volonté de démocratiser l'accès aux meilleurs produits de service de Plomberie et d'Electricité au Cameroun.
                </p>
            </div>
        </section>

        <!-- Mission Section -->
        <section class="py-16 md:py-20 bg-card">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-primary">Notre Mission</span>
                        <h2 class="text-2xl md:text-3xl lg:text-4xl font-black text-foreground mt-2 mb-4">
                            L'innovation, <br/><span class="text-primary">accessible à tous</span>
                        </h2>
                        <p class="text-muted-foreground leading-relaxed mb-4">
                            Depuis notre création, nous nous engageons à proposer des produits technologiques de qualité à des prix compétitifs. Notre équipe sélectionne rigoureusement chaque article pour garantir votre satisfaction.
                        </p>
                        <p class="text-muted-foreground leading-relaxed mb-6">
                            Basés à Yaoundé, nous livrons dans tout le Cameroun avec un service client réactif et professionnel. Votre confiance est notre priorité.
                        </p>
                        <div class="flex items-center gap-2 text-muted-foreground">
                            <MapPin class="w-5 h-5 text-primary" />
                            <span>Yaoundé, Cameroun – Rue de la Cathédrale</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div v-for="stat in stats" :key="stat.label" class="text-center p-6 bg-secondary rounded-xl border border-border hover:border-primary/30 transition-all duration-300">
                            <p class="text-2xl md:text-3xl font-black text-primary">{{ stat.value }}</p>
                            <p class="text-xs font-semibold uppercase text-muted-foreground">{{ stat.label }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Values Section -->
        <section class="py-16 md:py-20 bg-secondary">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <span class="text-xs font-bold uppercase tracking-wider text-primary">Ce qui nous différencie</span>
                    <h2 class="text-2xl md:text-3xl font-black text-foreground mt-2">
                        Nos <span class="text-primary">valeurs</span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="val in values" :key="val.title" class="p-6 bg-card rounded-xl border border-border hover:border-primary/30 hover:-translate-y-1 transition-all duration-300">
                        <div :class="['w-12 h-12 rounded-xl flex items-center justify-center mb-4', val.iconBg]">
                            <component :is="val.icon" :class="['w-5 h-5', val.iconColor]" />
                        </div>
                        <h3 class="text-lg font-bold text-foreground mb-2">{{ val.title }}</h3>
                        <p class="text-sm text-muted-foreground leading-relaxed">{{ val.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Us -->
        <section class="py-16 md:py-20 bg-card">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-4">
                        <div v-for="item in advantages" :key="item" class="flex items-start gap-3">
                            <CheckCircle class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" />
                            <span class="text-foreground">{{ item }}</span>
                        </div>
                    </div>

                    <div class="p-8 rounded-xl bg-gradient-to-r from-primary to-primary-dark text-white text-center">
                        <h3 class="text-2xl font-black mb-3">Rejoignez notre communauté</h3>
                        <p class="text-orange-100 mb-6">
                            Plus de 2 000 clients nous font confiance pour leurs achats technologiques.
                        </p>
                        <a href="/contact" class="inline-block px-6 py-3 bg-white text-primary-dark rounded-lg font-bold hover:bg-gray-100 hover:-translate-y-1 transition-all duration-300 shadow-lg">
                            Nous contacter
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

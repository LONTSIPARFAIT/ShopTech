<template>
    <section class="py-16 md:py-20 lg:py-24 relative overflow-hidden bg-gradient-to-b from-secondary/50 to-secondary">
        <!-- Effets de fond décoratifs -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl -mr-48 -mt-48"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl -ml-48 -mb-48"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-orange-500/5 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <!-- Partie gauche : Contenu texte -->
                <div>
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-orange-500/10 border border-orange-500/20 mb-6">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-500 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                        </span>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-orange-500">Services Professionnels</span>
                    </div>

                    <!-- Titre -->
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-black mb-6 leading-tight text-foreground">
                        Besoin d'un <span class="bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent italic">Expert</span> pour vos Travaux ?
                    </h2>

                    <!-- Description -->
                    <p class="text-base md:text-lg text-muted-foreground mb-8 max-w-xl leading-relaxed">
                        Au-delà de la vente de matériel, ShopTech vous accompagne avec des services d'installation et de maintenance réalisés par des professionnels qualifiés en plomberie et électricité.
                    </p>

                    <!-- Avantages -->
                    <div class="flex flex-wrap gap-6 mb-10">
                        <div v-for="benefit in benefits" :key="benefit.title" class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-card flex items-center justify-center text-orange-500 border border-border shadow-sm">
                                <component :is="benefit.icon" class="w-4.5 h-4.5" />
                            </div>
                            <span class="text-sm font-semibold text-foreground">{{ benefit.title }}</span>
                        </div>
                    </div>

                    <!-- Bouton principal -->
                    <Link
                        :href="contact()"
                        class="group relative inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl font-bold transition-all duration-300 hover:shadow-2xl hover:shadow-orange-500/25 hover:-translate-y-1 active:scale-95 overflow-hidden"
                    >
                        <span class="relative z-10">Demander un Devis Gratuit</span>
                        <ArrowRight class="relative z-10 w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" />
                        <span class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-500 bg-gradient-to-r from-transparent via-white/20 to-transparent"></span>
                    </Link>
                </div>

                <!-- Partie droite : Cartes services -->
                <div class="grid gap-6">
                    <div
                        v-for="service in servicesList"
                        :key="service.title"
                        class="group p-6 md:p-8 rounded-2xl bg-card border border-border hover:border-orange-500/30 transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
                    >
                        <div class="flex flex-col sm:flex-row sm:items-start gap-5">
                            <!-- Icône -->
                            <div class="w-14 h-14 rounded-xl flex items-center justify-center shrink-0 transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg bg-gradient-to-br from-orange-500 to-orange-600">
                                <component :is="service.icon" class="w-7 h-7 text-white" />
                            </div>

                            <!-- Contenu -->
                            <div class="flex-1">
                                <h3 class="text-xl md:text-2xl font-bold text-foreground mb-2 group-hover:text-orange-500 transition-colors duration-300">
                                    {{ service.title }}
                                </h3>
                                <p class="text-muted-foreground mb-4 leading-relaxed">
                                    {{ service.description }}
                                </p>
                                <Link
                                    :href="contact()"
                                    class="inline-flex items-center gap-1.5 text-sm font-bold text-orange-500 hover:gap-2.5 transition-all duration-300 group/link"
                                >
                                    <span>En savoir plus</span>
                                    <ArrowRight class="w-4 h-4 transition-transform duration-300 group-hover/link:translate-x-1" />
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { contact } from '@/routes';
import { Wrench, Zap, ArrowRight, ShieldCheck, Clock, Award } from 'lucide-vue-next';

const servicesList = [
    {
        title: 'Plomberie',
        description: 'Installation, réparation et entretien de vos systèmes sanitaires par nos experts.',
        icon: Wrench,
    },
    {
        title: 'Électricité',
        description: 'Mise en conformité, dépannage et installation électrique complète pour votre sécurité.',
        icon: Zap,
    }
];

const benefits = [
    { title: 'Intervention Rapide', icon: Clock },
    { title: 'Qualité Garantie', icon: ShieldCheck },
    { title: 'Experts Certifiés', icon: Award },
];
</script>

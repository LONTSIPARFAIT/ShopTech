<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import ShopLayout from '@/layouts/ShopLayout.vue';
import { Wrench, Zap, Hammer, Drill, Droplet, Lightbulb, ShieldCheck, Truck, ArrowRight, MessageCircle, Building2, HardHat } from 'lucide-vue-next';

defineOptions({ layout: ShopLayout });

const services = [
    {
        icon: Droplet,
        title: 'Plomberie',
        description: 'Installation, réparation et maintenance de vos systèmes sanitaires. Tuyauterie, robinetterie, chauffe-eau et dépannage d\'urgence.',
        iconBg: 'bg-blue-100 dark:bg-blue-950/30',
        iconColor: 'text-blue-500'
    },
    {
        icon: Zap,
        title: 'Électricité',
        description: 'Installation électrique complète, mise aux normes, dépannage et éclairage. Travaux neufs ou rénovation par des électriciens certifiés.',
        iconBg: 'bg-amber-100 dark:bg-amber-950/30',
        iconColor: 'text-amber-500'
    },
    {
        icon: Drill,
        title: 'Outillage Électroportatif',
        description: 'Vente d\'outillage électroportatif professionnel. Perceuses, visseuses, meuleuses, scies et coffrets complets pour artisans.',
        iconBg: 'bg-orange-100 dark:bg-orange-950/30',
        iconColor: 'text-orange-500'
    },
    {
        icon: Building2,
        title: 'Matériel de Chantier',
        description: 'Bétonnières, échafaudages, compresseurs, groupes électrogènes. Location et vente de matériel BTP pour vos chantiers.',
        iconBg: 'bg-red-100 dark:bg-red-950/30',
        iconColor: 'text-red-500'
    },
    {
        icon: Wrench,
        title: 'Installation & Réparation',
        description: 'Service technique complet pour l\'installation de vos équipements (chauffe-eau, pompes, tableau électrique) et réparation sur site.',
        iconBg: 'bg-purple-100 dark:bg-purple-950/30',
        iconColor: 'text-purple-500'
    },
    {
        icon: ShieldCheck,
        title: 'Garantie & SAV',
        description: 'Garantie constructeur sur tous nos produits et outillages. Service après-vente réactif et pièces détachées disponibles.',
        iconBg: 'bg-green-100 dark:bg-green-950/30',
        iconColor: 'text-green-500'
    }
];
</script>

<template>
    <Head title="Nos Services – ShopTech" />

    <div class="pt-20">
        <!-- Hero -->
        <section class="relative py-16 md:py-24 overflow-hidden bg-gradient-to-br from-orange-50/50 to-white dark:from-slate-900 dark:to-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <span class="inline-block px-3 py-1.5 rounded-full bg-orange-100 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 text-xs font-bold uppercase tracking-wider mb-4">
                    Nos domaines d'expertise
                </span>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-foreground mb-4">
                    Plomberie & <span class="text-primary">Électricité</span>
                </h1>
                <p class="text-muted-foreground text-base md:text-lg max-w-2xl mx-auto">
                    Vente d'outillage professionnel, installation et réparation par des techniciens certifiés.
                </p>
            </div>
        </section>

        <!-- Services Grid -->
        <section class="py-16 md:py-20 bg-card">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="service in services" :key="service.title" class="group p-6 bg-secondary rounded-xl border border-border hover:border-primary/30 hover:-translate-y-1 transition-all duration-300">
                        <div :class="['w-12 h-12 rounded-xl flex items-center justify-center mb-4 transition-all duration-300 group-hover:scale-110', service.iconBg]">
                            <component :is="service.icon" :class="['w-6 h-6', service.iconColor]" />
                        </div>
                        <h3 class="text-lg font-bold text-foreground mb-2 group-hover:text-primary transition-colors">{{ service.title }}</h3>
                        <p class="text-sm text-muted-foreground mb-4 leading-relaxed">{{ service.description }}</p>
                        <a href="/contact" class="inline-flex items-center gap-1 text-sm font-bold text-primary hover:gap-2 transition-all duration-300">
                            En savoir plus <ArrowRight class="w-3 h-3" />
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Spécialistes -->
        <section class="py-12 bg-secondary">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-wrap justify-center gap-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-950/30 flex items-center justify-center">
                            <Droplet class="w-5 h-5 text-blue-500" />
                        </div>
                        <span class="text-sm font-medium text-foreground">Plombiers certifiés</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-950/30 flex items-center justify-center">
                            <Zap class="w-5 h-5 text-amber-500" />
                        </div>
                        <span class="text-sm font-medium text-foreground">Électriciens diplômés</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-orange-100 dark:bg-orange-950/30 flex items-center justify-center">
                            <Hammer class="w-5 h-5 text-orange-500" />
                        </div>
                        <span class="text-sm font-medium text-foreground">Outillage pro</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-950/30 flex items-center justify-center">
                            <ShieldCheck class="w-5 h-5 text-green-500" />
                        </div>
                        <span class="text-sm font-medium text-foreground">Garantie 12 mois</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Banner -->
        <section class="py-16 bg-gradient-to-r from-primary to-primary-dark">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-2xl md:text-3xl font-black text-white mb-3">Besoin d'une installation ou d'une réparation ?</h2>
                <p class="text-orange-100 mb-6 max-w-md mx-auto">
                    Nos techniciens se déplacent à votre domicile pour tous vos travaux.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/contact" class="inline-flex items-center justify-center px-6 py-3 bg-white text-primary-dark rounded-lg font-bold hover:bg-gray-100 hover:-translate-y-1 transition-all duration-300 shadow-lg">
                        Demander un devis
                    </a>
                    <a href="https://wa.me/237600000000" target="_blank" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-orange-800/30 text-white rounded-lg font-bold hover:bg-orange-800/40 hover:-translate-y-1 transition-all duration-300">
                        <MessageCircle class="w-4 h-4" />
                        WhatsApp urgent
                    </a>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { contact } from '@/routes';
import { Wrench, Zap, ArrowRight, ShieldCheck, Clock, Award } from 'lucide-vue-next';

const servicesList = [
    {
        title: 'Plomberie',
        description: 'Installation, réparation et entretien de vos systèmes sanitaires par nos experts.',
        icon: Wrench,
        color: 'blue'
    },
    {
        title: 'Électricité',
        description: 'Mise en conformité, dépannage et installation électrique complète pour votre sécurité.',
        icon: Zap,
        color: 'amber'
    }
];

const benefits = [
    { title: 'Intervention Rapide', icon: Clock },
    { title: 'Qualité Garantie', icon: ShieldCheck },
    { title: 'Experts Certifiés', icon: Award },
];
</script>

<template>
    <section class="py-24 relative overflow-hidden bg-secondary/30">
        <!-- Background decorative elements -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl -mr-48 -mt-48"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl -ml-48 -mb-48"></div>

        <div class="shop-header-container relative">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Left side: Text content -->
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 text-primary text-xs font-bold uppercase tracking-wider mb-6">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                        </span>
                        Services Professionnels
                    </div>
                    
                    <h2 class="text-4xl md:text-5xl font-black mb-6 leading-tight">
                        Besoin d'un <span class="text-primary italic">Expert</span> pour vos Travaux ?
                    </h2>
                    
                    <p class="text-lg text-muted-foreground mb-10 max-w-xl leading-relaxed">
                        Au-delà de la vente de matériel, ShopTech vous accompagne avec des services d'installation et de maintenance réalisés par des professionnels qualifiés en plomberie et électricité.
                    </p>

                    <div class="flex flex-wrap gap-8 mb-10">
                        <div v-for="benefit in benefits" :key="benefit.title" class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-background flex items-center justify-center text-primary border border-border shadow-sm">
                                <component :is="benefit.icon" class="w-4 h-4" />
                            </div>
                            <span class="text-sm font-medium">{{ benefit.title }}</span>
                        </div>
                    </div>

                    <Link 
                        :href="contact()" 
                        class="group inline-flex items-center gap-3 px-8 py-4 bg-primary text-primary-foreground rounded-2xl font-bold transition-all hover:shadow-2xl hover:shadow-primary/20 hover:-translate-y-1 active:scale-95"
                    >
                        Demander un Devis Gratuit
                        <ArrowRight class="w-5 h-5 transition-transform group-hover:translate-x-1" />
                    </Link>
                </div>

                <!-- Right side: Service cards -->
                <div class="grid gap-6">
                    <div 
                        v-for="service in servicesList" 
                        :key="service.title"
                        class="p-8 rounded-3xl bg-background border border-border shadow-xl hover:shadow-2xl hover:border-primary/30 transition-all group"
                    >
                        <div class="flex items-start gap-6">
                            <div 
                                class="w-16 h-16 rounded-2xl flex items-center justify-center shrink-0 transition-transform group-hover:scale-110"
                                :class="service.color === 'blue' ? 'bg-blue-500/10 text-blue-500' : 'bg-amber-500/10 text-amber-500'"
                            >
                                <component :is="service.icon" class="w-8 h-8" />
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold mb-2">{{ service.title }}</h3>
                                <p class="text-muted-foreground mb-4 leading-relaxed">
                                    {{ service.description }}
                                </p>
                                <Link 
                                    :href="contact()" 
                                    class="text-sm font-bold text-primary flex items-center gap-1 hover:gap-2 transition-all"
                                >
                                    En savoir plus
                                    <ArrowRight class="w-4 h-4" />
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

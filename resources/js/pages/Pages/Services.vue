<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import ShopLayout from '@/layouts/ShopLayout.vue';
import { Smartphone, Laptop, Wrench, Headphones, ShieldCheck, Truck, ArrowRight } from 'lucide-vue-next';

defineOptions({ layout: ShopLayout });

const services = [
    {
        icon: Smartphone,
        title: 'Vente de Smartphones',
        description: 'Large gamme de smartphones haut de gamme et milieu de gamme. iPhones, Samsung, Xiaomi, Tecno et bien plus encore avec garantie officielle.',
        color: 'blue',
    },
    {
        icon: Laptop,
        title: 'Ordinateurs & Tablettes',
        description: 'PC portables, ordinateurs de bureau, MacBook et tablettes. Configuration sur mesure disponible pour professionnels et étudiants.',
        color: 'indigo',
    },
    {
        icon: Headphones,
        title: 'Accessoires Tech',
        description: 'Écouteurs, câbles, étuis, chargeurs, claviers, souris et tout l\'écosystème d\'accessoires pour vos appareils.',
        color: 'purple',
    },
    {
        icon: Wrench,
        title: 'Réparation & SAV',
        description: 'Service de réparation rapide pour smartphones et ordinateurs. Diagnostic gratuit, pièces d\'origine et techniciens certifiés.',
        color: 'orange',
    },
    {
        icon: ShieldCheck,
        title: 'Garantie & Assurance',
        description: 'Extension de garantie jusqu\'à 2 ans sur tous nos produits. Protection complète contre les pannes et accidents.',
        color: 'green',
    },
    {
        icon: Truck,
        title: 'Livraison Rapide',
        description: 'Livraison sous 24–48h à Yaoundé, Douala et dans les principales villes du Cameroun. Livraison gratuite dès 50 000 XAF.',
        color: 'teal',
    },
];

const colorMap: Record<string, string> = {
    blue: 'bg-blue-600/10 text-blue-600',
    indigo: 'bg-indigo-600/10 text-indigo-600',
    purple: 'bg-purple-600/10 text-purple-600',
    orange: 'bg-orange-500/10 text-orange-500',
    green: 'bg-green-500/10 text-green-500',
    teal: 'bg-teal-500/10 text-teal-500',
};
</script>

<template>
    <Head title="Nos Services – ShopTech" />

    <div class="pt-24">
        <!-- Hero -->
        <section class="py-20 bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-indigo-400/10 rounded-full blur-[100px]"></div>
            </div>
            <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
                <span class="inline-block px-4 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-[10px] font-black uppercase tracking-widest mb-6">Ce que nous offrons</span>
                <h1 class="text-4xl lg:text-5xl font-black tracking-tight uppercase italic mb-4">
                    Nos <span class="text-blue-600">Services</span>
                </h1>
                <p class="text-slate-600 dark:text-slate-400 font-medium leading-relaxed max-w-2xl mx-auto">
                    Du smartphone à l'ordinateur, de la vente à la réparation, ShopTech vous accompagne à chaque étape de votre parcours technologique.
                </p>
            </div>
        </section>

        <!-- Services Grid -->
        <section class="py-20 max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="service in services"
                    :key="service.title"
                    class="shop-card p-8 space-y-5 hover:-translate-y-2 group cursor-default"
                >
                    <div class="w-14 h-14 rounded-3xl flex items-center justify-center" :class="colorMap[service.color]">
                        <component :is="service.icon" class="w-7 h-7" />
                    </div>
                    <h3 class="text-lg font-black group-hover:text-blue-600 transition-colors">{{ service.title }}</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-medium">{{ service.description }}</p>
                    <a href="/contact" class="inline-flex items-center gap-1.5 text-xs font-black uppercase tracking-wider text-blue-600 hover:gap-3 transition-all">
                        En savoir plus <ArrowRight class="w-3 h-3" />
                    </a>
                </div>
            </div>
        </section>

        <!-- CTA Banner -->
        <section class="py-16 bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-blue-700 dark:to-indigo-800">
            <div class="max-w-4xl mx-auto px-6 text-center space-y-6">
                <h2 class="text-3xl font-black text-white uppercase tracking-tight">Besoin d'un service spécifique ?</h2>
                <p class="text-blue-100 font-medium leading-relaxed">
                    Notre équipe est disponible pour répondre à vos besoins personnalisés. Contactez-nous dès maintenant.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/contact" class="px-8 py-4 bg-white text-blue-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-50 transition-colors shadow-xl">
                        Nous contacter
                    </a>
                    <a
                        href="https://wa.me/237600000000?text=Bonjour%2C%20je%20voudrais%20en%20savoir%20plus%20sur%20vos%20services"
                        target="_blank"
                        class="px-8 py-4 bg-green-500 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-green-400 transition-colors shadow-xl flex items-center gap-2 justify-center"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WhatsApp
                    </a>
                </div>
            </div>
        </section>
    </div>
</template>

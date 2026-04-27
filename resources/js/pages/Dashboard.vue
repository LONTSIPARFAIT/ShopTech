<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import StatusBadge from '@/components/ui/StatusBadge.vue';
import { ShoppingCart, Package, CreditCard, ChevronRight } from 'lucide-vue-next';

const props = defineProps<{
    recentOrders: any[];
    stats: {
        totalOrders: number;
        totalSpent: number;
    };
}>();

defineOptions({
    layout: AppSidebarLayout,
});
</script>

<template>
    <Head title="Mon Espace Client" />

    <div class="max-w-7xl mx-auto p-6 lg:p-12 space-y-16">
        <!-- Welcome Hero -->
        <div class="relative p-12 rounded-[3rem] bg-gradient-to-br from-slate-900 to-slate-800 dark:from-white dark:to-slate-200 text-white dark:text-slate-900 overflow-hidden shadow-2xl">
            <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/20 blur-[100px] rounded-full translate-x-1/2 -translate-y-1/2"></div>
            <div class="relative z-10 space-y-6">
                <div class="inline-flex px-4 py-2 bg-white/10 dark:bg-black/5 rounded-full text-xs font-black uppercase tracking-[0.2em] backdrop-blur-md">
                    Membre Privilégié
                </div>
                <h1 class="text-5xl font-black tracking-tighter">Bienvenue, {{ $page.props.auth.user.name }}</h1>
                <p class="text-xl opacity-70 max-w-xl font-medium">Suivez vos achats, gérez vos adresses et découvrez nos dernières offres personnalisées.</p>
            </div>
        </div>

        <!-- Consumer Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="p-10 bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-xl shadow-black/[0.02] group transition-all hover:scale-[1.02]">
                <div class="flex items-center justify-between mb-8">
                    <div class="w-16 h-16 bg-blue-50 dark:bg-blue-900/30 text-blue-600 rounded-2xl flex items-center justify-center">
                        <CreditCard class="w-8 h-8" />
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Investissement Tech</span>
                </div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Total Dépensé</p>
                <p class="text-5xl font-black tracking-tight">{{ Number(stats.totalSpent).toLocaleString() }} <span class="text-lg opacity-50">XAF</span></p>
            </div>

            <div class="p-10 bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-xl shadow-black/[0.02] group transition-all hover:scale-[1.02]">
                <div class="flex items-center justify-between mb-8">
                    <div class="w-16 h-16 bg-purple-50 dark:bg-purple-900/30 text-purple-600 rounded-2xl flex items-center justify-center">
                        <Package class="w-8 h-8" />
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Activité</span>
                </div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Commandes Réalisées</p>
                <p class="text-5xl font-black tracking-tight">{{ stats.totalOrders }} <span class="text-lg opacity-50">Achats</span></p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Order Activity Feed -->
            <div class="lg:col-span-2 space-y-8">
                <div class="flex items-center justify-between">
                    <h2 class="text-3xl font-black tracking-tight">Historique Récent</h2>
                    <Link href="/orders" class="group flex items-center gap-2 font-black text-xs uppercase tracking-widest text-blue-600 hover:text-blue-700 transition-all">
                        Voir tout l'historique
                        <ChevronRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                    </Link>
                </div>

                <div v-if="recentOrders.length > 0" class="space-y-4">
                    <div v-for="order in recentOrders" :key="order.id" class="p-8 bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-6 hover:shadow-lg transition-all">
                        <div class="flex items-center gap-6">
                            <div class="w-14 h-14 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center font-black text-slate-400">
                                #{{ order.id }}
                            </div>
                            <div>
                                <p class="font-black text-lg">{{ Number(order.total_amount).toLocaleString() }} XAF</p>
                                <p class="text-sm font-medium text-slate-400">{{ new Date(order.created_at).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' }) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-6">
                            <StatusBadge :status="order.status" type="order" />
                            <Link :href="`/orders/${order.id}`" class="p-3 bg-slate-50 dark:bg-slate-800 rounded-xl hover:bg-slate-900 dark:hover:bg-white hover:text-white dark:hover:text-slate-950 transition-all">
                                <ChevronRight class="w-5 h-5" />
                            </Link>
                        </div>
                    </div>
                </div>

                <div v-else class="p-20 text-center bg-slate-50 dark:bg-slate-900/50 rounded-[3rem] border border-dashed border-slate-200 dark:border-slate-800 space-y-6">
                    <div class="w-20 h-20 bg-white dark:bg-slate-900 rounded-3xl flex items-center justify-center mx-auto shadow-xl text-slate-200">
                        <ShoppingCart class="w-10 h-10" />
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-xl font-bold">Prêt pour votre premier achat ?</h3>
                        <p class="text-slate-500 font-medium">Découvrez notre catalogue exclusif de produits high-tech.</p>
                    </div>
                    <Link href="/products" class="inline-flex px-10 py-4 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-2xl font-black uppercase tracking-widest text-xs hover:opacity-90 transition-all shadow-xl">
                        Explorer la Boutique
                    </Link>
                </div>
            </div>

            <!-- Promotion / Help -->
            <div class="space-y-8">
                <h2 class="text-3xl font-black tracking-tight">Support</h2>
                <div class="grid grid-cols-1 gap-6">
                    <div class="p-8 bg-blue-600 rounded-[2.5rem] text-white space-y-6 relative overflow-hidden group shadow-2xl shadow-blue-500/20">
                        <div class="absolute bottom-0 right-0 w-32 h-32 bg-white/10 blur-3xl rounded-full translate-x-1/3 translate-y-1/3"></div>
                        <h3 class="text-2xl font-black leading-tight">Besoin d'aide avec une commande ?</h3>
                        <p class="text-sm font-medium opacity-80">Notre équipe de support est disponible 24/7 pour vous accompagner.</p>
                        <button class="w-full py-4 bg-white text-blue-600 rounded-2xl font-black uppercase tracking-widest text-xs hover:scale-105 transition-all">
                            Contacter le Support
                        </button>
                    </div>

                    <div class="p-8 bg-slate-100 dark:bg-slate-800 rounded-[2.5rem] space-y-4">
                        <h3 class="text-xl font-bold">Votre Profil</h3>
                        <p class="text-sm text-slate-500 font-medium">Gérez vos informations personnelles et vos préférences de sécurité.</p>
                        <Link href="/settings/profile" class="inline-flex items-center gap-2 font-black text-xs uppercase tracking-widest text-slate-900 dark:text-white hover:text-blue-600 transition-colors">
                            Paramètres du compte
                            <ChevronRight class="w-4 h-4" />
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

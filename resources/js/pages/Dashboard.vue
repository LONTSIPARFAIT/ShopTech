<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import StatusBadge from '@/components/ui/StatusBadge.vue';
import { ShoppingCart, Package, CreditCard, ChevronRight, User, Headphones, Settings, Calendar, TrendingUp, Heart } from 'lucide-vue-next';

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

    <div class="py-6 md:py-8 px-4 max-w-7xl ">
        <!-- Welcome Section -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-primary/10 via-primary/5 to-transparent p-6 md:p-8 mb-8">
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/20 text-primary text-xs font-bold uppercase tracking-wider mb-4">
                    <User class="w-3 h-3" />
                    Membre depuis {{ new Date($page.props.auth.user.created_at).getFullYear() }}
                </div>
                <h1 class="text-2xl md:text-3xl font-black text-foreground mb-2">
                    Bonjour, <span class="bg-gradient-to-r from-primary to-primary-dark bg-clip-text text-transparent">{{ $page.props.auth.user.name }}</span>
                </h1>
                <p class="text-sm text-muted-foreground max-w-md">
                    Gérez vos commandes, suivez vos achats et découvrez nos offres exclusives.
                </p>
            </div>
            <!-- Décoration -->
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-primary/10 rounded-full blur-3xl"></div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
            <div class="bg-card border border-border rounded-xl p-5 hover:border-primary/30 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div class="p-3 bg-primary/10 rounded-xl">
                        <CreditCard class="w-5 h-5 text-primary" />
                    </div>
                    <div class="text-right">
                        <span class="text-2xl font-black text-primary">{{ Number(stats.totalSpent).toLocaleString() }}</span>
                        <span class="text-sm font-semibold text-muted-foreground ml-1">FCFA</span>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Total dépensé</div>
                    <div class="flex items-center gap-1 mt-1">
                        <TrendingUp class="w-3 h-3 text-green-500" />
                        <span class="text-xs text-green-500">+12% vs mois dernier</span>
                    </div>
                </div>
            </div>

            <div class="bg-card border border-border rounded-xl p-5 hover:border-primary/30 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div class="p-3 bg-purple-100 dark:bg-purple-950/30 rounded-xl">
                        <Package class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                    </div>
                    <div class="text-right">
                        <span class="text-2xl font-black text-purple-600 dark:text-purple-400">{{ stats.totalOrders }}</span>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Commandes passées</div>
                    <div class="text-xs text-muted-foreground mt-1">Dont {{ recentOrders.filter(o => o.status === 'delivered').length }} livrées</div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Orders -->
            <div class="lg:col-span-2">
                <div class="bg-card border border-border rounded-2xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-border bg-secondary/30 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-foreground">Commandes récentes</h2>
                        <Link href="/orders" class="inline-flex items-center gap-1 text-sm font-semibold text-primary hover:gap-2 transition-all">
                            Voir tout <ChevronRight class="w-4 h-4" />
                        </Link>
                    </div>

                    <div v-if="recentOrders.length > 0" class="divide-y divide-border">
                        <div v-for="order in recentOrders" :key="order.id" class="p-5 hover:bg-secondary/30 transition-colors">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div>
                                    <div class="text-sm font-bold text-foreground">#{{ order.id }}</div>
                                    <div class="flex items-center gap-1 text-xs text-muted-foreground mt-1">
                                        <Calendar class="w-3 h-3" />
                                        {{ new Date(order.created_at).toLocaleDateString('fr-FR') }}
                                    </div>
                                </div>
                                <div class="text-base font-bold text-primary">
                                    {{ Number(order.total_amount).toLocaleString() }} FCFA
                                </div>
                                <StatusBadge :status="order.status" type="order" />
                                <Link :href="`/orders/${order.id}`" class="inline-flex items-center gap-1 text-sm font-medium text-muted-foreground hover:text-primary transition-colors">
                                    Détails <ChevronRight class="w-3 h-3" />
                                </Link>
                            </div>
                        </div>
                    </div>

                    <div v-else class="flex flex-col items-center justify-center py-12 text-center">
                        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                            <ShoppingCart class="w-8 h-8 text-primary" />
                        </div>
                        <h3 class="text-lg font-bold text-foreground mb-2">Aucune commande</h3>
                        <p class="text-sm text-muted-foreground mb-6">Votre premier achat vous attend</p>
                        <Link href="/products" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary to-primary-dark text-white font-bold rounded-xl transition-all hover:-translate-y-0.5">
                            <Heart class="w-4 h-4" />
                            Découvrir la boutique
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-5">
                <!-- Support Card -->
                <Link href="/contact" class="block bg-gradient-to-r from-primary to-primary-dark rounded-2xl p-5 text-white transition-all hover:-translate-y-1 hover:shadow-xl">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                            <Headphones class="w-6 h-6" />
                        </div>
                        <div>
                            <h3 class="text-base font-bold">Service client</h3>
                            <p class="text-xs text-orange-100 mt-1">Une question ? Contactez-nous</p>
                        </div>
                    </div>
                </Link>

                <!-- Profile Card -->
                <Link href="/settings/profile" class="block bg-card border border-border rounded-2xl p-5 transition-all hover:border-primary/30 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center">
                            <Settings class="w-6 h-6 text-primary" />
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-foreground">Mon profil</h3>
                            <p class="text-xs text-muted-foreground mt-1">Gérer vos informations personnelles</p>
                        </div>
                    </div>
                </Link>

                <!-- Fidelity Card -->
                <div class="bg-secondary/50 border border-border rounded-2xl p-5">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-950/30 flex items-center justify-center">
                            <TrendingUp class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-foreground">Programme fidélité</h3>
                            <p class="text-xs text-muted-foreground">Gagnez des points à chaque achat</p>
                        </div>
                    </div>
                    <div class="w-full bg-secondary rounded-full h-2 mt-2">
                        <div class="bg-gradient-to-r from-primary to-primary-dark rounded-full h-2" style="width: 30%"></div>
                    </div>
                    <p class="text-xs text-muted-foreground mt-2">Encore 2 commandes pour le niveau Or</p>
                </div>
            </div>
        </div>
    </div>
</template>
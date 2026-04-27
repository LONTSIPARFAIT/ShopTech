<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import StatusBadge from '@/components/ui/StatusBadge.vue';
import { Package, ChevronRight, Calendar, CreditCard } from 'lucide-vue-next';

const props = defineProps<{
    orders: {
        data: any[];
        links: any[];
    };
}>();

defineOptions({
    layout: AppSidebarLayout,
});
</script>

<template>
    <Head title="Mes Commandes" />

    <div class="max-w-5xl mx-auto p-6 lg:p-12 space-y-12">
        <div class="space-y-2">
            <h1 class="text-4xl font-black tracking-tight">Historique des Commandes</h1>
            <p class="text-slate-500 font-medium text-lg">Retrouvez tous vos achats effectués sur ShopTech.</p>
        </div>

        <div v-if="orders.data.length > 0" class="space-y-6">
            <div 
                v-for="order in orders.data" 
                :key="order.id"
                class="group bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 p-8 hover:shadow-2xl hover:shadow-blue-500/5 transition-all duration-500"
            >
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center font-black text-slate-400 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                            #{{ order.id }}
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl font-black">{{ Number(order.total_amount).toLocaleString() }} XAF</span>
                                <StatusBadge :status="order.status" type="order" />
                            </div>
                            <div class="flex items-center gap-4 text-sm text-slate-400 font-bold">
                                <span class="flex items-center gap-1.5">
                                    <Calendar class="w-3.5 h-3.5" />
                                    {{ new Date(order.created_at).toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' }) }}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <CreditCard class="w-3.5 h-3.5" />
                                    {{ order.payment_status === 'paid' ? 'Payé' : 'En attente' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <Link 
                            :href="`/orders/${order.id}`"
                            class="px-8 py-4 bg-slate-100 dark:bg-slate-800 rounded-2xl font-black uppercase tracking-widest text-xs group-hover:bg-slate-900 group-hover:text-white dark:group-hover:bg-white dark:group-hover:text-slate-950 transition-all flex items-center gap-2"
                        >
                            Détails de la commande
                            <ChevronRight class="w-4 h-4" />
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="p-32 text-center bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm space-y-6">
            <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-3xl flex items-center justify-center mx-auto text-slate-200">
                <Package class="w-12 h-12" />
            </div>
            <div class="space-y-2">
                <h3 class="text-2xl font-black">Aucune commande trouvée</h3>
                <p class="text-slate-500 font-medium">Il est temps de remplir votre panier !</p>
            </div>
            <Link href="/products" class="inline-block px-12 py-5 bg-blue-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs shadow-xl shadow-blue-500/20 hover:scale-105 transition-all">
                Explorer les produits
            </Link>
        </div>
    </div>
</template>

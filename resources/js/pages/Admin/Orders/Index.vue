<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import StatusBadge from '@/components/ui/StatusBadge.vue';

const props = defineProps<{
    orders: any[];
}>();
</script>

<template>
    <Head title="Gestion des Commandes - Admin" />

    <div class="p-6 lg:p-12 space-y-8">
        <div class="space-y-1">
            <h1 class="text-3xl font-black tracking-tight">Commandes</h1>
            <p class="text-slate-500">Suivez et gérez les commandes de vos clients.</p>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50">
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-slate-400">ID</th>
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Client</th>
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Total</th>
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Paiement</th>
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Statut</th>
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Date</th>
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        <tr v-for="order in orders" :key="order.id" class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-8 py-5 font-bold">#{{ order.id }}</td>
                            <td class="px-8 py-5">
                                <div class="font-bold">{{ order.user.name }}</div>
                                <div class="text-xs text-slate-500">{{ order.user.email }}</div>
                            </td>
                            <td class="px-8 py-5 font-black">
                                {{ Number(order.total_amount).toLocaleString() }} XAF
                            </td>
                            <td class="px-8 py-5">
                                <StatusBadge :status="order.payment_status" type="payment" />
                            </td>
                            <td class="px-8 py-5">
                                <StatusBadge :status="order.status" type="order" />
                            </td>
                            <td class="px-8 py-5 text-sm opacity-60">
                                {{ new Date(order.created_at).toLocaleDateString() }}
                            </td>
                            <td class="px-8 py-5">
                                <Link 
                                    :href="`/admin/orders/${order.id}`"
                                    class="px-4 py-2 bg-slate-100 dark:bg-slate-800 rounded-xl font-bold text-xs hover:bg-blue-600 hover:text-white transition-all"
                                >
                                    Détails
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="orders.length === 0" class="p-24 text-center space-y-4">
                <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto text-slate-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold">Aucune commande</h3>
                <p class="text-slate-500">Les commandes de vos clients apparaîtront ici.</p>
            </div>
        </div>
    </div>
</template>

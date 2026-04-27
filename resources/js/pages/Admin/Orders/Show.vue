<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import StatusBadge from '@/components/ui/StatusBadge.vue';

const props = defineProps<{
    order: any;
}>();

const form = useForm({
    status: props.order.status,
    payment_status: props.order.payment_status,
});

const updateOrder = () => {
    form.put(`/admin/orders/${props.order.id}`);
};
</script>

<template>
    <Head :title="`Commande #${order.id}`" />

    <div class="p-6 lg:p-12 space-y-8 max-w-7xl mx-auto">
        <div class="flex items-center justify-between gap-6">
            <div class="space-y-1">
                <h1 class="text-3xl font-black tracking-tight">Commande #{{ order.id }}</h1>
                <p class="text-slate-500">{{ new Date(order.created_at).toLocaleString() }}</p>
            </div>
            <div class="flex gap-3">
                <StatusBadge :status="order.payment_status" type="payment" />
                <StatusBadge :status="order.status" type="order" />
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Items -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
                    <div class="p-8 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-xl font-bold">Produits Commandés</h2>
                    </div>
                    <div class="divide-y divide-slate-100 dark:divide-slate-800">
                        <div v-for="item in order.items" :key="item.id" class="p-8 flex items-center gap-6">
                            <div class="w-16 h-16 rounded-2xl bg-slate-100 dark:bg-slate-800 flex-shrink-0 overflow-hidden">
                                <img v-if="item.product.featured_image" :src="item.product.featured_image.path" class="w-full h-full object-cover" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold truncate">{{ item.product.name }}</h4>
                                <p class="text-sm text-slate-500">
                                    {{ item.variant.name }}: {{ item.variant.value }}
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="font-bold">{{ Number(item.price).toLocaleString() }} XAF</div>
                                <div class="text-xs text-slate-500">Qté: {{ item.quantity }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="p-8 bg-slate-50 dark:bg-slate-800/50 flex justify-between items-center">
                        <span class="font-bold text-slate-500 uppercase tracking-widest text-xs">Total de la commande</span>
                        <span class="text-3xl font-black text-blue-600">{{ Number(order.total_amount).toLocaleString() }} XAF</span>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Customer Info -->
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm p-8 space-y-6">
                    <h2 class="text-xl font-bold">Client</h2>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 text-blue-600 rounded-full flex items-center justify-center font-black">
                            {{ order.user.name.charAt(0) }}
                        </div>
                        <div>
                            <div class="font-bold">{{ order.user.name }}</div>
                            <div class="text-sm text-slate-500">{{ order.user.email }}</div>
                        </div>
                    </div>
                </div>

                <!-- Update Status -->
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm p-8 space-y-6">
                    <h2 class="text-xl font-bold">Gérer le Statut</h2>
                    
                    <form @submit.prevent="updateOrder" class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black uppercase tracking-widest opacity-50">Statut Commande</label>
                            <select v-model="form.status" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl p-4 focus:ring-2 focus:ring-blue-500 transition-all">
                                <option value="pending">En attente</option>
                                <option value="processing">En cours</option>
                                <option value="delivered">Livrée</option>
                                <option value="cancelled">Annulée</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black uppercase tracking-widest opacity-50">Statut Paiement</label>
                            <select v-model="form.payment_status" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl p-4 focus:ring-2 focus:ring-blue-500 transition-all">
                                <option value="unpaid">Non payé</option>
                                <option value="paid">Payé</option>
                                <option value="failed">Échoué</option>
                            </select>
                        </div>

                        <button 
                            type="submit" 
                            :disabled="form.processing"
                            class="w-full py-4 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-2xl font-black uppercase tracking-widest text-xs hover:opacity-90 transition-all disabled:opacity-50 shadow-xl shadow-slate-500/10"
                        >
                            {{ form.processing ? 'Chargement...' : 'Mettre à jour' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

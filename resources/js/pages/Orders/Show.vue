<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppHeaderLayout from '@/layouts/app/AppHeaderLayout.vue';
import StatusBadge from '@/components/ui/StatusBadge.vue';
import { ChevronLeft, Package, MapPin, CreditCard, Clock } from 'lucide-vue-next';

const props = defineProps<{
    order: any;
}>();

defineOptions({
    layout: AppHeaderLayout,
});
</script>

<template>
    <Head :title="`Commande #${order.id}`" />

    <div class="max-w-5xl mx-auto p-6 lg:p-12 space-y-12">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div class="space-y-4">
                <Link href="/orders" class="group inline-flex items-center gap-2 text-sm font-black uppercase tracking-widest text-slate-400 hover:text-blue-600 transition-colors">
                    <ChevronLeft class="w-4 h-4 group-hover:-translate-x-1 transition-transform" />
                    Retour aux commandes
                </Link>
                <div class="flex items-center gap-4">
                    <h1 class="text-4xl font-black tracking-tight">Commande #{{ order.id }}</h1>
                    <StatusBadge :status="order.status" type="order" />
                </div>
            </div>
            
            <div v-if="order.payment_status === 'unpaid'" class="flex gap-4">
                <Link 
                    :href="`/payment/notchpay/init/${order.id}`"
                    class="px-10 py-5 bg-blue-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs shadow-2xl shadow-blue-500/20 hover:scale-105 transition-all"
                >
                    Payer Maintenant
                </Link>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Order Details -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
                    <div class="p-10 border-b border-slate-100 dark:border-slate-800">
                        <h2 class="text-2xl font-black tracking-tight">Articles</h2>
                    </div>
                    <div class="divide-y divide-slate-100 dark:divide-slate-800">
                        <div v-for="item in order.items" :key="item.id" class="p-10 flex items-center gap-8 group">
                            <div class="w-20 h-20 rounded-3xl bg-slate-50 dark:bg-slate-800 flex-shrink-0 overflow-hidden group-hover:scale-105 transition-transform duration-500">
                                <img v-if="item.product.featured_image" :src="item.product.featured_image.path" class="w-full h-full object-cover" />
                                <div v-else class="w-full h-full flex items-center justify-center text-slate-200">
                                    <Package class="w-10 h-10" />
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-lg font-black truncate group-hover:text-blue-600 transition-colors">{{ item.product.name }}</h4>
                                <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest mt-1">
                                    {{ item.variant.name }}: {{ item.variant.value }}
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="text-xl font-black">{{ Number(item.price).toLocaleString() }} XAF</div>
                                <div class="text-xs font-black text-slate-400 opacity-60">Qté: {{ item.quantity }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="p-10 bg-slate-900 dark:bg-white text-white dark:text-slate-900 flex justify-between items-center">
                        <span class="text-xs font-black uppercase tracking-[0.2em] opacity-70">Total payé</span>
                        <span class="text-4xl font-black tracking-tighter">{{ Number(order.total_amount).toLocaleString() }} XAF</span>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-8">
                <!-- Status Timeline (Simple) -->
                <div class="p-10 bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm space-y-8">
                    <h3 class="text-xl font-black tracking-tight">Suivi</h3>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/30 text-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                <Clock class="w-5 h-5" />
                            </div>
                            <div>
                                <p class="font-bold text-sm">Commande Placée</p>
                                <p class="text-xs text-slate-400 font-medium">{{ new Date(order.created_at).toLocaleString() }}</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-10 h-10 bg-slate-50 dark:bg-slate-800 rounded-xl flex items-center justify-center flex-shrink-0 opacity-50">
                                <CreditCard class="w-5 h-5" />
                            </div>
                            <div>
                                <p class="font-bold text-sm">Paiement</p>
                                <p class="text-xs text-slate-400 font-medium">
                                    <StatusBadge :status="order.payment_status" type="payment" />
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivery Address (Placeholder for now) -->
                <div class="p-10 bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm space-y-6">
                    <div class="flex items-center gap-3">
                        <MapPin class="w-5 h-5 text-blue-600" />
                        <h3 class="text-xl font-black tracking-tight">Livraison</h3>
                    </div>
                    <div class="space-y-2 text-sm font-medium text-slate-500">
                        <p class="font-bold text-slate-900 dark:text-white">{{ $page.props.auth.user.name }}</p>
                        <p>Yaoundé, Cameroun</p>
                        <p>Bastos, Avenue de l'Indépendance</p>
                        <p>+237 6XX XXX XXX</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

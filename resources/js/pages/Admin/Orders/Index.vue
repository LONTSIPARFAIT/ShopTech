<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import StatusBadge from '@/components/ui/StatusBadge.vue';
import { ShoppingBag, Search, Filter, Package, User } from 'lucide-vue-next';
import { ref, computed } from 'vue';

const props = defineProps<{
    orders: any[];
}>();

const search = ref('');
const statusFilter = ref('all');

const filteredOrders = computed(() => {
    let result = props.orders;
    
    if (search.value) {
        const q = search.value.toLowerCase();
        result = result.filter(o => 
            `#${o.id}`.includes(q) || 
            o.user.name.toLowerCase().includes(q)
        );
    }
    
    if (statusFilter.value !== 'all') {
        result = result.filter(o => o.status === statusFilter.value);
    }
    
    return result;
});
</script>

<template>
    <Head title="Commandes - Admin" />

    <div class="py-6 md:py-8 px-4 max-w-7xl">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2.5 bg-primary/10 text-primary rounded-xl">
                        <ShoppingBag class="w-6 h-6" />
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-black tracking-tight text-foreground">Commandes</h1>
                        <p class="text-sm text-muted-foreground mt-1">
                            Suivez et gérez les commandes de vos clients
                        </p>
                    </div>
                </div>
            </div>
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-secondary rounded-xl">
                <ShoppingBag class="w-4 h-4 text-primary" />
                <span class="text-sm font-bold text-foreground">{{ orders.length }} commandes</span>
            </div>
        </div>

        <!-- Filters -->
        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <div class="relative flex-1">
                <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" />
                <input 
                    v-model="search"
                    type="text" 
                    placeholder="Rechercher une commande..."
                    class="w-full pl-11 pr-4 py-3 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-foreground placeholder:text-muted-foreground/50"
                />
            </div>
            <select v-model="statusFilter" class="px-4 py-3 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary text-foreground">
                <option value="all">Tous les statuts</option>
                <option value="pending">En attente</option>
                <option value="processing">En cours</option>
                <option value="delivered">Livrée</option>
                <option value="cancelled">Annulée</option>
            </select>
        </div>

        <!-- Orders List -->
        <div class="bg-card border border-border rounded-2xl overflow-hidden">
            <div v-if="filteredOrders.length === 0" class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                    <ShoppingBag class="w-10 h-10 text-primary" />
                </div>
                <h3 class="text-lg font-bold text-foreground mb-2">Aucune commande</h3>
                <p class="text-sm text-muted-foreground">Les commandes de vos clients apparaîtront ici</p>
            </div>

            <div v-else class="divide-y divide-border">
                <div v-for="order in filteredOrders" :key="order.id" class="p-5 hover:bg-secondary/30 transition-colors">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center">
                                <Package class="w-5 h-5 text-primary" />
                            </div>
                            <div>
                                <div class="text-sm font-bold text-foreground">#{{ order.id }}</div>
                                <div class="text-xs text-muted-foreground">{{ new Date(order.created_at).toLocaleDateString() }}</div>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <User class="w-3 h-3 text-muted-foreground" />
                                <span class="text-sm font-medium text-foreground">{{ order.user.name }}</span>
                            </div>
                            <div class="text-xs text-muted-foreground">{{ order.user.email }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-base font-bold text-primary">{{ Number(order.total_amount).toLocaleString() }} FCFA</div>
                            <div class="flex gap-2 mt-1">
                                <StatusBadge :status="order.payment_status" type="payment" />
                                <StatusBadge :status="order.status" type="order" />
                            </div>
                        </div>
                        <Link :href="`/admin/orders/${order.id}`" class="px-4 py-2 text-sm font-semibold text-primary bg-primary/10 rounded-xl hover:bg-primary hover:text-white transition-all">
                            Détails
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
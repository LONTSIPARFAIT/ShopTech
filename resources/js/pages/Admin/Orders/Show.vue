<script setup lang="ts">
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import StatusBadge from '@/components/ui/StatusBadge.vue';
import { ArrowLeft, Package, User, CreditCard, Truck, MapPin, Phone, Mail } from 'lucide-vue-next';

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

    <div class="py-6 md:py-8 px-4 max-w-6xl ">
        <Link href="/admin/orders" class="inline-flex items-center gap-2 text-muted-foreground hover:text-primary transition-colors mb-6">
            <ArrowLeft class="w-4 h-4" />
            Retour aux commandes
        </Link>

        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-black text-foreground">Commande #{{ order.id }}</h1>
                <p class="text-sm text-muted-foreground mt-1">{{ new Date(order.created_at).toLocaleString() }}</p>
            </div>
            <div class="flex gap-2">
                <StatusBadge :status="order.payment_status" type="payment" />
                <StatusBadge :status="order.status" type="order" />
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Items -->
            <div class="lg:col-span-2">
                <div class="bg-card border border-border rounded-2xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-border bg-secondary/30">
                        <div class="flex items-center gap-2">
                            <Package class="w-5 h-5 text-primary" />
                            <h2 class="text-lg font-bold text-foreground">Produits commandés</h2>
                        </div>
                    </div>
                    <div class="divide-y divide-border">
                        <div v-for="item in order.items" :key="item.id" class="p-5 flex flex-wrap items-center gap-4">
                            <div class="w-14 h-14 rounded-xl overflow-hidden bg-secondary border border-border shrink-0">
                                <img v-if="item.product.featured_image" :src="item.product.featured_image.url" class="w-full h-full object-cover" />
                                <div v-else class="w-full h-full flex items-center justify-center text-muted-foreground">
                                    <Package class="w-6 h-6" />
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-bold text-foreground">{{ item.product.name }}</div>
                                <div class="text-xs text-muted-foreground">{{ item.variant.name }}: {{ item.variant.value }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-primary">{{ Number(item.price).toLocaleString() }} FCFA</div>
                                <div class="text-xs text-muted-foreground">Qté: {{ item.quantity }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-border bg-secondary/30 flex justify-between">
                        <span class="text-sm font-bold text-foreground">Total de la commande</span>
                        <span class="text-lg font-black text-primary">{{ Number(order.total_amount).toLocaleString() }} FCFA</span>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Client Info -->
                <div class="bg-card border border-border rounded-2xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-border bg-secondary/30">
                        <div class="flex items-center gap-2">
                            <User class="w-5 h-5 text-primary" />
                            <h2 class="text-lg font-bold text-foreground">Client</h2>
                        </div>
                    </div>
                    <div class="p-5 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-bold text-lg">
                            {{ order.user.name.charAt(0).toUpperCase() }}
                        </div>
                        <div>
                            <div class="text-sm font-bold text-foreground">{{ order.user.name }}</div>
                            <div class="flex items-center gap-1 text-xs text-muted-foreground mt-1">
                                <Mail class="w-3 h-3" />
                                {{ order.user.email }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Livraison -->
                <div class="bg-card border border-border rounded-2xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-border bg-secondary/30">
                        <div class="flex items-center gap-2">
                            <Truck class="w-5 h-5 text-primary" />
                            <h2 class="text-lg font-bold text-foreground">Livraison</h2>
                        </div>
                    </div>
                    <div class="p-5 space-y-2">
                        <div class="flex items-center gap-2 text-sm text-foreground">
                            <MapPin class="w-4 h-4 text-muted-foreground" />
                            <span>{{ order.shipping_address || 'Non renseigné' }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-foreground">
                            <Phone class="w-4 h-4 text-muted-foreground" />
                            <span>{{ order.phone || 'Non renseigné' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Update Status -->
                <div class="bg-card border border-border rounded-2xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-border bg-secondary/30">
                        <div class="flex items-center gap-2">
                            <CreditCard class="w-5 h-5 text-primary" />
                            <h2 class="text-lg font-bold text-foreground">Gérer le statut</h2>
                        </div>
                    </div>
                    <form @submit.prevent="updateOrder" class="p-5 space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-muted-foreground mb-2">Statut commande</label>
                            <select v-model="form.status" class="w-full px-4 py-2 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary text-foreground">
                                <option value="pending">En attente</option>
                                <option value="processing">En cours</option>
                                <option value="delivered">Livrée</option>
                                <option value="cancelled">Annulée</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-muted-foreground mb-2">Statut paiement</label>
                            <select v-model="form.payment_status" class="w-full px-4 py-2 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary text-foreground">
                                <option value="unpaid">Non payé</option>
                                <option value="paid">Payé</option>
                                <option value="failed">Échoué</option>
                            </select>
                        </div>
                        <button type="submit" :disabled="form.processing" class="w-full py-3 bg-gradient-to-r from-primary to-primary-dark text-white font-bold rounded-xl transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-primary/30 disabled:opacity-50">
                            {{ form.processing ? 'Chargement...' : 'Mettre à jour' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
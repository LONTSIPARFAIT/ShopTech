<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { store as checkoutStore } from '@/routes/checkout';
import ShopHeader from '@/components/Shop/ShopHeader.vue';
import ShopFooter from '@/components/Shop/ShopFooter.vue';

const props = defineProps<{
    cart: any;
    total: number;
    discount: number;
}>();

const form = useForm({
    payment_method: 'notchpay',
    shipping_address: '',
    customer_phone: '',
});

const submit = () => {
    form.post(checkoutStore().url);
};
</script>

<template>
    <Head title="Paiement - ShopTech" />

    <div class="min-h-screen bg-slate-50 dark:bg-slate-950 transition-colors duration-300">
        <ShopHeader />
        <div class="pt-32 pb-12 px-6 mx-auto max-w-7xl lg:px-12">
            <h1 class="text-4xl font-black mb-12">Finaliser votre commande</h1>

            <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Details -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 border border-slate-100 dark:border-slate-800 shadow-xl space-y-8">
                        <h2 class="text-2xl font-bold">Informations de livraison</h2>
                        
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-sm font-bold opacity-70">Adresse complète</label>
                                <textarea 
                                    v-model="form.shipping_address"
                                    required
                                    rows="3"
                                    class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all"
                                    placeholder="Quartier, Rue, Ville, Pays..."
                                ></textarea>
                                <div v-if="form.errors.shipping_address" class="text-red-500 text-xs">{{ form.errors.shipping_address }}</div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold opacity-70">Numéro de téléphone</label>
                                <input 
                                    v-model="form.customer_phone"
                                    required
                                    type="tel"
                                    class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all"
                                    placeholder="+237 ..."
                                />
                                <div v-if="form.errors.customer_phone" class="text-red-500 text-xs">{{ form.errors.customer_phone }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 border border-slate-100 dark:border-slate-800 shadow-xl space-y-8">
                        <h2 class="text-2xl font-bold">Méthode de paiement</h2>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <label 
                                class="relative p-6 rounded-2xl border-2 cursor-pointer transition-all flex flex-col gap-2"
                                :class="form.payment_method === 'notchpay' ? 'border-blue-600 bg-blue-50 dark:bg-blue-900/20' : 'border-slate-100 dark:border-slate-800'"
                            >
                                <input type="radio" v-model="form.payment_method" value="notchpay" class="hidden" />
                                <div class="font-bold flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full border-2 flex items-center justify-center" :class="form.payment_method === 'notchpay' ? 'border-blue-600' : 'border-slate-300'">
                                        <span v-if="form.payment_method === 'notchpay'" class="w-2 h-2 bg-blue-600 rounded-full"></span>
                                    </span>
                                    Notch Pay
                                </div>
                                <p class="text-xs opacity-60">Mobile Money, Orange, MTN, Carte Bancaire</p>
                            </label>

                            <label 
                                class="relative p-6 rounded-2xl border-2 cursor-pointer transition-all flex flex-col gap-2"
                                :class="form.payment_method === 'cod' ? 'border-amber-600 bg-amber-50 dark:bg-amber-900/20' : 'border-slate-100 dark:border-slate-800'"
                            >
                                <input type="radio" v-model="form.payment_method" value="cod" class="hidden" />
                                <div class="font-bold flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full border-2 flex items-center justify-center" :class="form.payment_method === 'cod' ? 'border-amber-600' : 'border-slate-300'">
                                        <span v-if="form.payment_method === 'cod'" class="w-2 h-2 bg-amber-600 rounded-full"></span>
                                    </span>
                                    Paiement à la livraison
                                </div>
                                <p class="text-xs opacity-60">Payez en espèces lorsque vous recevez votre colis</p>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-slate-900 text-white rounded-[2.5rem] p-8 shadow-2xl space-y-6">
                        <h2 class="text-xl font-bold">Résumé</h2>
                        
                        <div class="space-y-3 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                            <div v-for="item in cart.items" :key="item.id" class="flex justify-between text-sm opacity-70">
                                <span class="line-clamp-1">{{ item.product.name }} x{{ item.quantity }}</span>
                                <span>{{ (Number(item.variant?.price_override || item.product.base_price) * item.quantity).toLocaleString() }} XAF</span>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-white/10 space-y-3">
                            <div v-if="discount > 0" class="flex justify-between text-sm text-green-400">
                                <span>Réduction</span>
                                <span>- {{ discount.toLocaleString() }} XAF</span>
                            </div>
                            <div class="flex justify-between text-2xl font-black pt-2">
                                <span>Total</span>
                                <span class="text-blue-400">{{ total.toLocaleString() }} XAF</span>
                            </div>
                        </div>

                        <button 
                            type="submit"
                            :disabled="form.processing"
                            class="w-full py-5 bg-blue-600 text-white rounded-2xl font-black text-lg hover:bg-blue-700 transition-all shadow-xl active:scale-[0.98] disabled:opacity-50"
                        >
                            {{ form.processing ? 'Traitement...' : 'Payer Maintenant' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
</style>

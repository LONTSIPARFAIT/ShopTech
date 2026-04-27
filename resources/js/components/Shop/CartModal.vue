<script setup lang="ts">
import { computed } from 'vue';
import { usePage, Link, router } from '@inertiajs/vue3';
import { 
    Dialog, 
    DialogContent, 
    DialogHeader, 
    DialogTitle, 
    DialogFooter,
    DialogClose 
} from '@/components/ui/dialog';
import { ShoppingBag, X, Plus, Minus, Trash2, ShoppingCart, ArrowRight, ShieldCheck } from 'lucide-vue-next';
import { update as cartUpdate, destroy as cartDestroy } from '@/routes/cart';
import { index as checkoutIndex } from '@/routes/checkout';

const page = usePage();
const cart = computed(() => (page.props as any).cart);
const cartCount = computed(() => (page.props as any).cartCount || 0);

const updateQuantity = (itemId: number, quantity: number) => {
    if (quantity < 1) return;
    router.patch(cartUpdate(itemId).url, { quantity }, {
        preserveScroll: true,
    });
};

const removeItem = (itemId: number) => {
    router.delete(cartDestroy(itemId).url, {
        preserveScroll: true,
    });
};
</script>

<template>
    <Dialog>
        <slot name="trigger" />
        
        <DialogContent class="sm:max-w-md h-[85vh] p-0 flex flex-col bg-white dark:bg-slate-950 border-slate-200 dark:border-slate-800 shadow-2xl rounded-[3rem] top-[55%] translate-y-[-50%] right-6 left-auto translate-x-0">
            <DialogHeader class="p-8 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <DialogTitle class="text-3xl font-black flex items-center gap-4 italic uppercase">
                        <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                            <ShoppingCart class="w-6 h-6 text-white" />
                        </div>
                        Panier
                        <span v-if="cartCount > 0" class="text-xs font-black bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-full text-blue-600">
                            {{ cartCount }}
                        </span>
                    </DialogTitle>
                </div>
            </DialogHeader>

            <div class="flex-1 overflow-y-auto custom-scrollbar p-8 space-y-8">
                <div v-if="!cart || cart.items.length === 0" class="h-full flex flex-col items-center justify-center text-center space-y-6">
                    <div class="w-32 h-32 bg-slate-50 dark:bg-slate-900 rounded-[2.5rem] flex items-center justify-center relative">
                        <ShoppingBag class="w-16 h-16 text-slate-200 dark:text-slate-800" />
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-blue-600 rounded-full animate-bounce flex items-center justify-center text-white font-bold text-xs">?</div>
                    </div>
                    <div class="space-y-2">
                        <p class="font-black text-2xl uppercase italic">Panier Vide</p>
                        <p class="text-sm text-slate-400 font-medium max-w-[200px] mx-auto">Votre prochaine pépite technologique vous attend en boutique.</p>
                    </div>
                    <DialogClose as-child>
                        <Link href="/products" class="px-10 py-4 bg-slate-900 dark:bg-white text-white dark:text-slate-950 rounded-2xl font-black text-xs uppercase tracking-widest hover:scale-105 transition-all">
                            Explorer la Boutique
                        </Link>
                    </DialogClose>
                </div>

                <div v-else class="space-y-8">
                    <div v-for="item in cart.items" :key="item.id" class="flex gap-6 group relative">
                        <div class="w-24 h-24 rounded-3xl bg-slate-50 dark:bg-slate-900 flex-shrink-0 overflow-hidden border border-slate-100 dark:border-slate-800 group-hover:scale-105 transition-transform duration-500">
                            <img 
                                v-if="item.product.featured_image" 
                                :src="item.product.featured_image.path" 
                                class="w-full h-full object-cover"
                            />
                        </div>
                        <div class="flex-1 min-w-0 flex flex-col justify-between py-1">
                            <div class="space-y-1">
                                <h4 class="font-black text-base uppercase italic truncate group-hover:text-blue-600 transition-colors">{{ item.product.name }}</h4>
                                <div class="flex items-center gap-2">
                                    <span v-if="item.variant" class="text-[9px] font-black uppercase tracking-widest bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded text-slate-500">
                                        {{ item.variant.name }}: {{ item.variant.value }}
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-400">
                                        {{ (Number(item.variant?.price_override || item.product.base_price)).toLocaleString() }} / u
                                    </span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between mt-4">
                                <div class="flex items-center bg-slate-50 dark:bg-slate-900 rounded-xl p-1 border border-slate-100 dark:border-slate-800">
                                    <button 
                                        @click="updateQuantity(item.id, item.quantity - 1)"
                                        class="w-8 h-8 flex items-center justify-center hover:bg-white dark:hover:bg-slate-800 rounded-lg transition-all shadow-sm active:scale-90"
                                    >
                                        <Minus class="w-3.5 h-3.5" />
                                    </button>
                                    <span class="w-10 text-center text-sm font-black">{{ item.quantity }}</span>
                                    <button 
                                        @click="updateQuantity(item.id, item.quantity + 1)"
                                        class="w-8 h-8 flex items-center justify-center hover:bg-white dark:hover:bg-slate-800 rounded-lg transition-all shadow-sm active:scale-90"
                                    >
                                        <Plus class="w-3.5 h-3.5" />
                                    </button>
                                </div>
                                <button @click="removeItem(item.id)" class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all">
                                    <Trash2 class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                        <div class="text-right py-1 flex flex-col items-end justify-between">
                            <div class="font-black text-lg text-blue-600">
                                {{ (Number(item.variant?.price_override || item.product.base_price) * item.quantity).toLocaleString() }}
                            </div>
                            <div class="text-[8px] font-black uppercase tracking-widest opacity-30">XAF</div>
                        </div>
                    </div>
                </div>
            </div>

            <DialogFooter v-if="cart && cart.items.length > 0" class="p-8 border-t border-slate-100 dark:border-slate-800 flex-col gap-6 bg-slate-50/50 dark:bg-slate-900/30 backdrop-blur-md rounded-b-[3rem]">
                <div class="space-y-4 w-full">
                    <div class="flex justify-between items-center text-slate-400 text-xs font-black uppercase tracking-widest">
                        <span>Sous-total</span>
                        <span class="text-slate-600 dark:text-slate-300">{{ Number(cart.total).toLocaleString() }} XAF</span>
                    </div>
                    <div class="h-px bg-slate-200 dark:bg-slate-800 w-full"></div>
                    <div class="flex justify-between items-center">
                        <div class="space-y-0.5">
                            <span class="text-xs font-black uppercase tracking-widest opacity-40">Total à payer</span>
                            <div class="text-3xl font-black text-slate-900 dark:text-white italic uppercase">
                                {{ Number(cart.total).toLocaleString() }} <span class="text-sm text-blue-600 not-italic">XAF</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-2">
                    <ShieldCheck class="w-4 h-4 text-emerald-500" /> Paiement 100% Sécurisé & Garanti
                </div>

                <DialogClose as-child>
                    <Link 
                        :href="checkoutIndex().url" 
                        class="group w-full py-5 bg-blue-600 text-white text-center rounded-[2rem] font-black text-sm uppercase tracking-[0.2em] hover:bg-blue-700 transition-all shadow-2xl shadow-blue-500/30 active:scale-[0.98] flex items-center justify-center gap-3"
                    >
                        Paiement <ArrowRight class="w-4 h-4 group-hover:translate-x-2 transition-transform" />
                    </Link>
                </DialogClose>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0, 0, 0, 0.05); border-radius: 10px; }
.dark .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.05); }
</style>



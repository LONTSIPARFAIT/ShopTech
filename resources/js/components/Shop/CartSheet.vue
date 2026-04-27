<script setup lang="ts">
import { computed } from 'vue';
import { usePage, Link, router } from '@inertiajs/vue3';
import { 
    Sheet, 
    SheetContent, 
    SheetHeader, 
    SheetTitle, 
    SheetFooter,
    SheetClose 
} from '@/components/ui/sheet';
import { ShoppingBag, X, Plus, Minus, Trash2 } from 'lucide-vue-next';
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
    <Sheet>
        <slot name="trigger" />
        
        <SheetContent side="right" class="w-full sm:max-w-md p-0 flex flex-col bg-white dark:bg-slate-950 border-slate-200 dark:border-slate-800">
            <SheetHeader class="p-6 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <SheetTitle class="text-2xl font-black flex items-center gap-3">
                        <ShoppingBag class="w-6 h-6 text-blue-600" />
                        Mon Panier
                        <span v-if="cartCount > 0" class="text-sm font-bold bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-full opacity-60">
                            {{ cartCount }}
                        </span>
                    </SheetTitle>
                </div>
            </SheetHeader>

            <div class="flex-1 overflow-y-auto custom-scrollbar p-6 space-y-6">
                <div v-if="!cart || cart.items.length === 0" class="h-full flex flex-col items-center justify-center text-center space-y-4 opacity-50">
                    <div class="w-20 h-20 bg-slate-50 dark:bg-slate-900 rounded-full flex items-center justify-center">
                        <ShoppingBag class="w-10 h-10" />
                    </div>
                    <div>
                        <p class="font-bold text-lg">Votre panier est vide</p>
                        <p class="text-sm">Découvrez nos produits pour commencer vos achats.</p>
                    </div>
                    <SheetClose as-child>
                        <Link href="/products" class="px-6 py-2 bg-blue-600 text-white rounded-xl font-bold text-sm">
                            Boutique
                        </Link>
                    </SheetClose>
                </div>

                <div v-else class="space-y-6">
                    <div v-for="item in cart.items" :key="item.id" class="flex gap-4 group">
                        <div class="w-20 h-20 rounded-2xl bg-slate-50 dark:bg-slate-900 flex-shrink-0 overflow-hidden border border-slate-100 dark:border-slate-800">
                            <img 
                                v-if="item.product.featured_image" 
                                :src="item.product.featured_image.path" 
                                class="w-full h-full object-cover"
                            />
                        </div>
                        <div class="flex-1 min-w-0 flex flex-col justify-between py-1">
                            <div>
                                <h4 class="font-bold text-sm truncate group-hover:text-blue-600 transition-colors">{{ item.product.name }}</h4>
                                <p v-if="item.variant" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-0.5">
                                    {{ item.variant.name }}: {{ item.variant.value }}
                                </p>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center bg-slate-50 dark:bg-slate-900 rounded-lg p-0.5 border border-slate-100 dark:border-slate-800">
                                    <button 
                                        @click="updateQuantity(item.id, item.quantity - 1)"
                                        class="w-6 h-6 flex items-center justify-center hover:bg-white dark:hover:bg-slate-800 rounded transition-all"
                                    >
                                        <Minus class="w-3 h-3" />
                                    </button>
                                    <span class="w-8 text-center text-xs font-bold">{{ item.quantity }}</span>
                                    <button 
                                        @click="updateQuantity(item.id, item.quantity + 1)"
                                        class="w-6 h-6 flex items-center justify-center hover:bg-white dark:hover:bg-slate-800 rounded transition-all"
                                    >
                                        <Plus class="w-3 h-3" />
                                    </button>
                                </div>
                                <button @click="removeItem(item.id)" class="p-1.5 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all">
                                    <Trash2 class="w-3.5 h-3.5" />
                                </button>
                            </div>
                        </div>
                        <div class="text-right py-1">
                            <div class="font-black text-sm text-blue-600">
                                {{ (Number(item.variant?.price_override || item.product.base_price) * item.quantity).toLocaleString() }}
                            </div>
                            <div class="text-[9px] opacity-50 uppercase font-bold tracking-tighter">XAF</div>
                        </div>
                    </div>
                </div>
            </div>

            <SheetFooter v-if="cart && cart.items.length > 0" class="p-6 border-t border-slate-100 dark:border-slate-800 flex-col gap-4">
                <div class="space-y-2 w-full">
                    <div class="flex justify-between items-center opacity-60 text-sm">
                        <span>Sous-total</span>
                        <span>{{ Number(cart.total).toLocaleString() }} XAF</span>
                    </div>
                    <div class="flex justify-between items-center text-xl font-black">
                        <span>Total</span>
                        <span class="text-blue-600">{{ Number(cart.total).toLocaleString() }} XAF</span>
                    </div>
                </div>
                <SheetClose as-child>
                    <Link 
                        :href="checkoutIndex().url" 
                        class="w-full py-4 bg-slate-900 dark:bg-white text-white dark:text-slate-950 text-center rounded-2xl font-black text-sm uppercase tracking-[0.2em] hover:scale-[1.02] transition-all shadow-xl shadow-black/10 active:scale-[0.98]"
                    >
                        Passer à la caisse
                    </Link>
                </SheetClose>
            </SheetFooter>
        </SheetContent>
    </Sheet>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0, 0, 0, 0.05); border-radius: 10px; }
.dark .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.05); }
</style>

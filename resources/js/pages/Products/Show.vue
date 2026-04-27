<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import { store as cartStore } from '@/routes/cart';
import { ShoppingBag, ChevronRight, Plus, Minus, ShieldCheck, Truck, RefreshCcw, Sparkles } from 'lucide-vue-next';
import ShopLayout from '@/Layouts/ShopLayout.vue';
import ProductCard from '@/components/Shop/ProductCard.vue';

const props = defineProps<{
    product: any;
    relatedProducts: any[];
}>();

const selectedVariant = ref(props.product.variants[0] || null);

const totalPrice = computed(() => {
    let price = Number(props.product.base_price);
    if (selectedVariant.value && selectedVariant.value.price_override) {
        price = Number(selectedVariant.value.price_override);
    }
    return price;
});

const quantity = ref(1);

const form = useForm({
    product_id: props.product.id,
    variant_id: selectedVariant.value?.id,
    quantity: 1,
});

watch([selectedVariant, quantity], () => {
    form.variant_id = selectedVariant.value?.id;
    form.quantity = quantity.value;
});

const addToCart = () => {
    form.post(cartStore().url, {
        preserveScroll: true,
    });
};

const activeImage = ref(props.product.images[0]?.path || null);
</script>


<template>
    <ShopLayout>
        <Head :title="`${product.name} - ShopTech`" />

        <div class="pt-48 pb-32 px-6 mx-auto max-w-7xl lg:px-12">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-4 text-[10px] font-black uppercase tracking-[0.2em] mb-16 overflow-x-auto whitespace-nowrap pb-4 scrollbar-hide">
                <Link href="/" class="text-slate-400 hover:text-blue-600 transition-colors">Accueil</Link>
                <ChevronRight class="w-3 h-3 text-slate-300 flex-shrink-0" />
                <Link href="/products" class="text-slate-400 hover:text-blue-600 transition-colors">Boutique</Link>
                <ChevronRight class="w-3 h-3 text-slate-300 flex-shrink-0" />
                <Link :href="`/products?category=${product.category.slug}`" class="text-slate-400 hover:text-blue-600 transition-colors">{{ product.category.name }}</Link>
                <ChevronRight class="w-3 h-3 text-slate-300 flex-shrink-0" />
                <span class="text-blue-600 truncate italic">{{ product.name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20">
                <!-- Gallery -->
                <div class="space-y-8">
                    <div class="relative group aspect-square bg-slate-50 dark:bg-slate-900 rounded-[4rem] overflow-hidden border border-slate-100 dark:border-slate-800 shadow-2xl shadow-black/[0.03]">
                        <img 
                            v-if="activeImage" 
                            :src="activeImage" 
                            :alt="product.name"
                            class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                        />
                        <div v-else class="flex items-center justify-center h-full text-slate-200 dark:text-slate-800">
                            <ShoppingBag class="w-32 h-32" />
                        </div>
                        
                        <!-- Floating Highlight -->
                        <div v-if="product.original_price" class="absolute top-10 left-10">
                            <div class="w-20 h-20 bg-red-500 text-white rounded-[2rem] flex flex-col items-center justify-center shadow-2xl shadow-red-500/30 rotate-12">
                                <span class="text-xs font-black uppercase tracking-tighter">OFFRE</span>
                                <span class="text-xl font-black italic">-{{ Math.round((1 - (product.base_price / product.original_price)) * 100) }}%</span>
                            </div>
                        </div>
                    </div>
                    
                    <div v-if="product.images.length > 1" class="grid grid-cols-4 gap-6">
                        <button 
                            v-for="(image, index) in product.images" 
                            :key="index"
                            @click="activeImage = image.path"
                            class="aspect-square rounded-3xl overflow-hidden border-4 transition-all duration-300 shadow-lg"
                            :class="activeImage === image.path ? 'border-blue-600 scale-105' : 'border-white dark:border-slate-900 opacity-60 hover:opacity-100'"
                        >
                            <img :src="image.path" class="w-full h-full object-cover" />
                        </button>
                    </div>
                </div>

                <!-- Info -->
                <div class="flex flex-col">
                    <div class="space-y-6 flex-1">
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <span class="px-5 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-600 rounded-full text-[9px] font-black uppercase tracking-[0.2em] border border-blue-100/50 dark:border-blue-800/30">
                                    {{ product.category.name }}
                                </span>
                                <span v-if="selectedVariant?.stock > 0" class="flex items-center gap-2 text-[9px] font-black uppercase tracking-[0.2em] text-emerald-500">
                                    <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></div> En Stock
                                </span>
                            </div>
                            <h1 class="text-5xl lg:text-7xl font-black tracking-tight uppercase italic leading-[0.9]">{{ product.name }}</h1>
                        </div>

                        <!-- Price Section -->
                        <div class="pt-6 flex items-baseline gap-4">
                            <div class="text-5xl font-black text-blue-600 dark:text-blue-400 italic">
                                {{ totalPrice.toLocaleString() }}
                                <span class="text-base font-black uppercase tracking-widest not-italic">XAF</span>
                            </div>
                            <div v-if="product.original_price" class="text-xl text-slate-300 dark:text-slate-700 line-through font-bold italic">
                                {{ Number(product.original_price).toLocaleString() }}
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="pt-8 space-y-4 border-t border-slate-50 dark:border-slate-900">
                            <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">À propos de l'article</h3>
                            <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed font-medium">
                                {{ product.description }}
                            </p>
                        </div>

                        <!-- Variants -->
                        <div v-if="product.variants.length > 0" class="pt-10 space-y-6">
                            <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Choisir une Option</h3>
                            <div class="flex flex-wrap gap-4">
                                <button 
                                    v-for="variant in product.variants" 
                                    :key="variant.id"
                                    @click="selectedVariant = variant"
                                    class="group relative p-2 rounded-[2rem] border-2 transition-all duration-500 text-left overflow-hidden active:scale-95 flex items-center gap-4"
                                    :class="selectedVariant?.id === variant.id 
                                        ? 'border-blue-600 bg-blue-600 text-white shadow-2xl shadow-blue-500/40' 
                                        : 'border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 hover:border-blue-400'"
                                >
                                    <!-- Color Swatch -->
                                    <div 
                                        v-if="variant.color_code" 
                                        class="w-12 h-12 rounded-[1.2rem] border-2 border-white/20 shadow-inner flex-shrink-0"
                                        :style="{ backgroundColor: variant.color_code }"
                                    ></div>
                                    
                                    <div class="pr-6">
                                        <div class="text-[10px] font-black uppercase tracking-widest">{{ variant.name }}: {{ variant.value }}</div>
                                        <div v-if="variant.price_override" class="text-[9px] font-bold opacity-70 mt-0.5">
                                            + {{ Number(variant.price_override).toLocaleString() }} XAF
                                        </div>
                                    </div>
                                    
                                    <div class="absolute top-0 right-0 p-3 opacity-20 group-hover:rotate-12 transition-transform">
                                        <Sparkles class="w-3 h-3" />
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-12 pt-10 border-t border-slate-50 dark:border-slate-900 space-y-8">
                        <div class="flex items-center gap-8">
                            <div class="flex items-center bg-slate-50 dark:bg-slate-900 rounded-3xl p-1.5 border border-slate-100 dark:border-slate-800 shadow-sm">
                                <button @click="quantity > 1 && quantity--" class="w-14 h-14 flex items-center justify-center hover:bg-white dark:hover:bg-slate-800 rounded-2xl transition-all shadow-sm active:scale-90">
                                    <Minus class="w-5 h-5" />
                                </button>
                                <span class="w-16 text-center text-xl font-black">{{ quantity }}</span>
                                <button @click="quantity++" class="w-14 h-14 flex items-center justify-center hover:bg-white dark:hover:bg-slate-800 rounded-2xl transition-all shadow-sm active:scale-90">
                                    <Plus class="w-5 h-5" />
                                </button>
                            </div>
                            <button 
                                @click="addToCart"
                                :disabled="form.processing"
                                class="flex-1 h-[76px] bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-[2.5rem] font-black text-xs uppercase tracking-[0.3em] hover:bg-blue-600 hover:text-white transition-all shadow-2xl active:scale-[0.98] flex items-center justify-center gap-4 group disabled:opacity-50"
                            >
                                <ShoppingBag class="w-6 h-6 group-hover:scale-110 transition-transform" />
                                {{ form.processing ? 'Chargement...' : 'Ajouter au Panier' }}
                            </button>
                        </div>

                        <!-- Value Props -->
                        <div class="grid grid-cols-3 gap-6 pt-4">
                            <div class="flex flex-col items-center text-center space-y-3">
                                <div class="w-12 h-12 bg-slate-50 dark:bg-slate-900 rounded-2xl flex items-center justify-center text-blue-600">
                                    <Truck class="w-5 h-5" />
                                </div>
                                <span class="text-[9px] font-black uppercase tracking-widest opacity-40">Livraison Express</span>
                            </div>
                            <div class="flex flex-col items-center text-center space-y-3">
                                <div class="w-12 h-12 bg-slate-50 dark:bg-slate-900 rounded-2xl flex items-center justify-center text-blue-600">
                                    <ShieldCheck class="w-5 h-5" />
                                </div>
                                <span class="text-[9px] font-black uppercase tracking-widest opacity-40">Garantie 2 ans</span>
                            </div>
                            <div class="flex flex-col items-center text-center space-y-3">
                                <div class="w-12 h-12 bg-slate-50 dark:bg-slate-900 rounded-2xl flex items-center justify-center text-blue-600">
                                    <RefreshCcw class="w-5 h-5" />
                                </div>
                                <span class="text-[9px] font-black uppercase tracking-widest opacity-40">Retour 30j</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <div v-if="relatedProducts.length > 0" class="mt-48 space-y-16">
                <div class="flex items-end justify-between border-b border-slate-100 dark:border-slate-800 pb-10">
                    <div class="space-y-4">
                        <h2 class="text-6xl font-black uppercase italic tracking-tighter">Complétez <span class="text-blue-600">le Style</span></h2>
                        <p class="text-slate-400 font-medium">D'autres articles qui pourraient vous plaire.</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12">
                    <ProductCard v-for="rel in relatedProducts" :key="rel.id" :product="rel" />
                </div>
            </div>
        </div>
    </ShopLayout>
</template>

<style scoped>
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>


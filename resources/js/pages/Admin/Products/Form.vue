<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { store as admin_products_store, update as admin_products_update } from '@/routes/admin/products';

const props = defineProps<{
    categories: any[];
    product: any;
}>();

const form = useForm({
    category_id: props.product?.category_id ?? '',
    name: props.product?.name ?? '',
    slug: props.product?.slug ?? '',
    description: props.product?.description ?? '',
    base_price: props.product?.base_price ?? '',
    original_price: props.product?.original_price ?? '',
    is_active: props.product?.is_active ?? true,
    variants: props.product?.variants?.map((v: any) => ({
        name: v.name,
        value: v.value,
        color_code: v.color_code ?? '',
        price_override: v.price_override,
        stock: v.stock
    })) ?? [
        { name: 'Standard', value: 'Unique', color_code: '', price_override: 0, stock: 0 }
    ],
});

const addVariant = () => {
    form.variants.push({ name: '', value: '', color_code: '', price_override: 0, stock: 0 });
};

const removeVariant = (index: number) => {
    form.variants.splice(index, 1);
};

const submit = () => {
    if (props.product) {
        form.put(admin_products_update(props.product.id).url);
    } else {
        form.post(admin_products_store().url);
    }
};

const generateSlug = () => {
    form.slug = form.name
        .toLowerCase()
        .replace(/ /g, '-')
        .replace(/[^\w-]+/g, '');
};
</script>

<template>
    <Head :title="product ? 'Modifier le Produit' : 'Ajouter un Produit'" />

    <div class="p-6 lg:p-12 max-w-5xl mx-auto space-y-8">
        <div class="flex items-center gap-4">
            <Link href="/admin/products" class="p-2 bg-slate-100 dark:bg-slate-800 rounded-xl hover:bg-slate-200 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </Link>
            <h1 class="text-3xl font-black tracking-tight">{{ product ? 'Modifier' : 'Ajouter' }} un Produit</h1>
        </div>

        <form @submit.prevent="submit" class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Main Info -->
                <div class="space-y-6 p-8 bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800">
                    <h2 class="text-xl font-bold">Informations Générales</h2>
                    
                    <div class="space-y-2">
                        <label class="text-sm font-bold opacity-50 uppercase tracking-widest">Nom du Produit</label>
                        <input 
                            v-model="form.name" 
                            @input="generateSlug"
                            type="text" 
                            class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all"
                            placeholder="ex: iPhone 15 Pro"
                        />
                        <div v-if="form.errors.name" class="text-red-500 text-xs">{{ form.errors.name }}</div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold opacity-50 uppercase tracking-widest">Slug</label>
                        <input 
                            v-model="form.slug" 
                            type="text" 
                            class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all"
                        />
                        <div v-if="form.errors.slug" class="text-red-500 text-xs">{{ form.errors.slug }}</div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold opacity-50 uppercase tracking-widest">Catégorie</label>
                        <select 
                            v-model="form.category_id"
                            class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all"
                        >
                            <option value="">Sélectionner une catégorie</option>
                            <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                        </select>
                        <div v-if="form.errors.category_id" class="text-red-500 text-xs">{{ form.errors.category_id }}</div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-bold opacity-50 uppercase tracking-widest">Prix de base</label>
                            <input 
                                v-model="form.base_price" 
                                type="number" 
                                step="0.01"
                                class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all"
                            />
                            <div v-if="form.errors.base_price" class="text-red-500 text-xs">{{ form.errors.base_price }}</div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold opacity-50 uppercase tracking-widest">Ancien Prix</label>
                            <input 
                                v-model="form.original_price" 
                                type="number" 
                                step="0.01"
                                class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all"
                                placeholder="(Optionnel)"
                            />
                            <div v-if="form.errors.original_price" class="text-red-500 text-xs">{{ form.errors.original_price }}</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="checkbox" v-model="form.is_active" class="w-6 h-6 rounded-lg text-blue-600 focus:ring-blue-500" />
                        <label class="font-bold">Produit Actif</label>
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-6 p-8 bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800">
                    <h2 class="text-xl font-bold">Détails</h2>
                    <div class="space-y-2">
                        <label class="text-sm font-bold opacity-50 uppercase tracking-widest">Description</label>
                        <textarea 
                            v-model="form.description" 
                            rows="10"
                            class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all"
                        ></textarea>
                    </div>
                </div>
            </div>

            <!-- Variants -->
            <div class="space-y-6 p-8 bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold">Variantes & Stock</h2>
                    <button 
                        @click.prevent="addVariant"
                        class="px-4 py-2 bg-blue-600/10 text-blue-600 rounded-xl font-bold hover:bg-blue-600 hover:text-white transition-all text-sm"
                    >
                        + Ajouter une Variante
                    </button>
                </div>

                <div class="space-y-4">
                    <div v-for="(variant, index) in form.variants" :key="index" class="grid grid-cols-1 md:grid-cols-6 gap-4 p-6 bg-slate-50 dark:bg-slate-800 rounded-2xl relative group">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase opacity-50">Type</label>
                            <input v-model="variant.name" type="text" placeholder="Couleur, Taille..." class="w-full bg-white dark:bg-slate-900 border-none rounded-xl text-sm" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase opacity-50">Valeur</label>
                            <input v-model="variant.value" type="text" placeholder="Rouge, XL..." class="w-full bg-white dark:bg-slate-900 border-none rounded-xl text-sm" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase opacity-50">Couleur (Hex)</label>
                            <div class="flex gap-2">
                                <input v-model="variant.color_code" type="color" class="w-10 h-10 p-1 bg-white dark:bg-slate-900 border-none rounded-lg cursor-pointer" />
                                <input v-model="variant.color_code" type="text" placeholder="#FFFFFF" class="flex-1 bg-white dark:bg-slate-900 border-none rounded-xl text-[10px] font-mono uppercase" />
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase opacity-50">Supplément</label>
                            <input v-model="variant.price_override" type="number" step="0.01" class="w-full bg-white dark:bg-slate-900 border-none rounded-xl text-sm" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase opacity-50">Stock</label>
                            <input v-model="variant.stock" type="number" class="w-full bg-white dark:bg-slate-900 border-none rounded-xl text-sm" />
                        </div>
                        <div class="flex items-end">
                            <button 
                                @click.prevent="removeVariant(index)"
                                v-if="form.variants.length > 1"
                                class="w-full p-3 bg-red-100 dark:bg-red-900/30 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div v-if="form.errors.variants" class="text-red-500 text-sm">{{ form.errors.variants }}</div>
            </div>

            <div class="flex justify-end">
                <button 
                    type="submit"
                    :disabled="form.processing"
                    class="px-12 py-5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-3xl font-black text-xl hover:opacity-90 transition-all shadow-2xl disabled:opacity-50"
                >
                    {{ form.processing ? 'Chargement...' : (product ? 'Mettre à jour' : 'Enregistrer le Produit') }}
                </button>
            </div>
        </form>
    </div>
</template>

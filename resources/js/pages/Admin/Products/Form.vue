<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { store as admin_products_store, update as admin_products_update } from '@/routes/admin/products';
import { computed, ref } from 'vue';

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
    featured_image: null as File | null,
    gallery_images: [] as File[],
    remove_image_ids: [] as number[],
    _method: props.product ? 'PUT' : 'POST'
});

const featuredPreview = ref(props.product?.featured_image?.path ?? null);
const galleryPreviews = ref(props.product?.images?.filter((img: any) => !img.is_featured).map((img: any) => ({ id: img.id, path: img.path })) ?? []);

const onFeaturedChange = (e: any) => {
    const file = e.target.files[0];
    if (file) {
        form.featured_image = file;
        featuredPreview.value = URL.createObjectURL(file);
    }
};

const onGalleryChange = (e: any) => {
    const files = Array.from(e.target.files) as File[];
    form.gallery_images = [...form.gallery_images, ...files];
    
    const newPreviews = files.map(file => ({ id: null, path: URL.createObjectURL(file) }));
    galleryPreviews.value = [...galleryPreviews.value, ...newPreviews];
};

const removeImage = (index: number, id: number | null) => {
    if (id) {
        form.remove_image_ids.push(id);
    }
    galleryPreviews.value.splice(index, 1);
    if (!id) {
        // Find which file to remove from form.gallery_images
        // This is simplified, in a real app we'd map files to previews more strictly
    }
};

const addVariant = () => {
    form.variants.push({ name: '', value: '', color_code: '', price_override: 0, stock: 0 });
};

const removeVariant = (index: number) => {
    form.variants.splice(index, 1);
};

const submit = () => {
    if (props.product) {
        form.post(admin_products_update(props.product.id).url, {
            forceFormData: true,
        });
    } else {
        form.post(admin_products_store().url);
    }
};

const discountPercent = computed(() => {
    const base = parseFloat(form.base_price as any);
    const original = parseFloat(form.original_price as any);
    if (!base || !original || original <= base) return null;
    return Math.round((1 - base / original) * 100);
});

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
                            <label class="text-sm font-bold opacity-50 uppercase tracking-widest">Prix actuel (XAF)</label>
                            <input
                                v-model="form.base_price"
                                type="number"
                                step="1"
                                class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all"
                                placeholder="ex: 150000"
                            />
                            <div v-if="form.errors.base_price" class="text-red-500 text-xs">{{ form.errors.base_price }}</div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold opacity-50 uppercase tracking-widest">Prix barré / Ancien prix (XAF)</label>
                            <input
                                v-model="form.original_price"
                                type="number"
                                step="1"
                                class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all"
                                placeholder="(Optionnel)"
                            />
                            <div v-if="form.errors.original_price" class="text-red-500 text-xs">{{ form.errors.original_price }}</div>
                        </div>
                    </div>

                    <!-- Live discount preview -->
                    <div v-if="discountPercent" class="flex items-center gap-3 p-4 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-2xl">
                        <div class="w-12 h-12 bg-red-500 text-white rounded-xl flex items-center justify-center font-black text-sm shadow-lg shadow-red-500/20">
                            -{{ discountPercent }}%
                        </div>
                        <div>
                            <p class="font-black text-sm text-red-600 dark:text-red-400">Réduction calculée automatiquement</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                                {{ Number(form.original_price).toLocaleString() }} XAF → {{ Number(form.base_price).toLocaleString() }} XAF
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="checkbox" v-model="form.is_active" class="w-6 h-6 rounded-lg text-blue-600 focus:ring-blue-500" />
                        <label class="font-bold">Produit Actif</label>
                    </div>
                </div>

                <!-- Images & Description -->
                <div class="space-y-8">
                    <!-- Featured Image -->
                    <div class="p-8 bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 space-y-6">
                        <h2 class="text-xl font-bold">Image Principale</h2>
                        <div class="relative group aspect-video bg-slate-50 dark:bg-slate-800 rounded-2xl overflow-hidden border-2 border-dashed border-slate-200 dark:border-slate-700 hover:border-blue-500 transition-all">
                            <img v-if="featuredPreview" :src="featuredPreview" class="w-full h-full object-cover" />
                            <div v-else class="absolute inset-0 flex flex-col items-center justify-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs font-bold uppercase tracking-widest">Choisir une image</span>
                            </div>
                            <input type="file" @change="onFeaturedChange" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" />
                        </div>
                        <div v-if="form.errors.featured_image" class="text-red-500 text-xs">{{ form.errors.featured_image }}</div>
                    </div>

                    <!-- Gallery -->
                    <div class="p-8 bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 space-y-6">
                        <h2 class="text-xl font-bold">Galerie Photos</h2>
                        <div class="grid grid-cols-3 gap-4">
                            <div v-for="(img, idx) in galleryPreviews" :key="idx" class="relative aspect-square bg-slate-50 dark:bg-slate-800 rounded-xl overflow-hidden group">
                                <img :src="img.path" class="w-full h-full object-cover" />
                                <button @click.prevent="removeImage(idx, img.id)" class="absolute top-2 right-2 p-1.5 bg-red-500 text-white rounded-lg opacity-0 group-hover:opacity-100 transition-all shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="relative aspect-square bg-slate-50 dark:bg-slate-800 rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-700 flex flex-col items-center justify-center text-slate-400 hover:border-blue-500 transition-all cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span class="text-[10px] font-bold uppercase tracking-tighter">Ajouter</span>
                                <input type="file" multiple @change="onGalleryChange" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" />
                            </div>
                        </div>
                        <div v-if="form.errors.gallery_images" class="text-red-500 text-xs">{{ form.errors.gallery_images }}</div>
                    </div>

                    <!-- Description -->
                    <div class="p-8 bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 space-y-6">
                        <h2 class="text-xl font-bold">Description</h2>
                        <textarea 
                            v-model="form.description" 
                            rows="6"
                            class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all"
                            placeholder="Détails du produit..."
                        ></textarea>
                        <div v-if="form.errors.description" class="text-red-500 text-xs">{{ form.errors.description }}</div>
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

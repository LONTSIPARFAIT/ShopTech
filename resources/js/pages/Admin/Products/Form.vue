<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { store as admin_products_store, update as admin_products_update } from '@/routes/admin/products';
import { computed, ref } from 'vue';
import { ArrowLeft, Camera, Trash2, Plus, Minus } from 'lucide-vue-next';

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
    is_active: props.product ? !!props.product.is_active : true,
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

const featuredPreview = ref(props.product?.featured_image?.url ?? null);
const galleryPreviews = ref(props.product?.images?.filter((img: any) => !img.is_featured).map((img: any) => ({ id: img.id, path: img.url })) ?? []);

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
};

const addVariant = () => {
    form.variants.push({ name: '', value: '', color_code: '', price_override: 0, stock: 0 });
};

const removeVariant = (index: number) => {
    form.variants.splice(index, 1);
};

const submit = () => {
    form.transform((data) => ({
        ...data,
        is_active: data.is_active ? 1 : 0,
        original_price: data.original_price === '' ? null : data.original_price,
        base_price: data.base_price === '' ? null : data.base_price,
        variants: data.variants.map((v: any) => ({
            ...v,
            price_override: v.price_override === '' ? null : v.price_override
        }))
    })).post(props.product ? admin_products_update(props.product.id).url : admin_products_store().url, {
        forceFormData: true,
    });
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

    <div class="max-w-5xl mx-auto p-4 md:p-6">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <Link href="/admin/products"
                class="w-10 h-10 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800">
                <ArrowLeft class="w-5 h-5" />
            </Link>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white md:text-3xl">
                {{ product ? 'Modifier' : 'Ajouter' }} un Produit
            </h1>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <!-- Two column grid -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Left Column: Main Information -->
                <div
                    class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm dark:bg-gray-900/50 dark:border-gray-800">
                    <h2
                        class="text-lg font-semibold text-gray-900 pb-4 border-b border-gray-200 mb-6 dark:text-white dark:border-gray-800">
                        Informations Générales</h2>

                    <!-- Name -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Nom du
                            produit</label>
                        <input v-model="form.name" @input="generateSlug" type="text"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-gray-50 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                            placeholder="ex: iPhone 15 Pro" />
                        <p v-if="form.errors.name" class="text-sm text-red-500 mt-1">{{ form.errors.name }}</p>
                    </div>

                    <!-- Slug - Version avec saisie bloquée -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Slug</label>
                        <input v-model="form.slug" type="text" readonly
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-gray-100 cursor-not-allowed text-gray-500 focus:border-gray-300 focus:ring-0 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
                            placeholder="iphone-15-pro" />
                        <p class="text-xs text-gray-400 mt-1">Le slug est généré automatiquement à partir du nom</p>
                        <p v-if="form.errors.slug" class="text-sm text-red-500 mt-1">{{ form.errors.slug }}</p>
                    </div>

                    <!-- Category -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Catégorie</label>
                        <select v-model="form.category_id"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-gray-50 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                            <option value="">Sélectionner une catégorie</option>
                            <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                        </select>
                        <p v-if="form.errors.category_id" class="text-sm text-red-500 mt-1">{{ form.errors.category_id
                            }}</p>
                    </div>

                    <!-- Prices -->
                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Prix actuel
                                (XAF)</label>
                            <input v-model="form.base_price" type="number" step="1"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-gray-50 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                                placeholder="150000" />
                            <p v-if="form.errors.base_price" class="text-sm text-red-500 mt-1">{{ form.errors.base_price
                                }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Ancien prix
                                (XAF)</label>
                            <input v-model="form.original_price" type="number" step="1"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-gray-50 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                                placeholder="Optionnel" />
                            <p v-if="form.errors.original_price" class="text-sm text-red-500 mt-1">{{
                                form.errors.original_price }}</p>
                        </div>
                    </div>

                    <!-- Discount preview -->
                    <div v-if="discountPercent"
                        class="flex items-center gap-3 p-3 mb-5 rounded-lg bg-red-50 border border-red-200 dark:bg-red-950/20 dark:border-red-800/30">
                        <div
                            class="w-10 h-10 rounded-lg bg-red-500 text-white flex items-center justify-center font-bold text-sm">
                            -{{ discountPercent }}%
                        </div>
                        <div>
                            <p class="font-semibold text-sm text-red-700 dark:text-red-400">Réduction automatique</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                {{ Number(form.original_price).toLocaleString() }} XAF → {{
                                    Number(form.base_price).toLocaleString() }} XAF
                            </p>
                        </div>
                    </div>

                    <!-- Active -->
                    <div class="flex items-center gap-3">
                        <input type="checkbox" v-model="form.is_active" id="is_active"
                            class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                        <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Produit
                            actif</label>
                    </div>
                </div>

                <!-- Right Column: Images & Description -->
                <div class="space-y-6">
                    <!-- Featured Image -->
                    <div
                        class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm dark:bg-gray-900/50 dark:border-gray-800">
                        <h2
                            class="text-lg font-semibold text-gray-900 pb-4 border-b border-gray-200 mb-6 dark:text-white dark:border-gray-800">
                            Image principale</h2>

                        <div class="relative cursor-pointer group">
                            <div
                                class="aspect-video bg-gray-100 rounded-lg overflow-hidden border-2 border-dashed border-gray-300 transition-colors group-hover:border-blue-500 dark:bg-gray-800 dark:border-gray-700">
                                <img v-if="featuredPreview" :src="featuredPreview" class="w-full h-full object-cover" />
                                <div v-else
                                    class="absolute inset-0 flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" stroke-width="2" />
                                        <circle cx="8.5" cy="8.5" r="1.5" stroke-width="2" />
                                        <polyline points="21 15 16 10 5 21" stroke-width="2" />
                                    </svg>
                                    <span class="text-sm font-medium">Choisir une image</span>
                                </div>
                            </div>
                            <input type="file" @change="onFeaturedChange"
                                class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" />
                        </div>
                        <p v-if="form.errors.featured_image" class="text-sm text-red-500 mt-2">{{
                            form.errors.featured_image }}</p>
                    </div>

                    <!-- Gallery -->
                    <div
                        class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm dark:bg-gray-900/50 dark:border-gray-800">
                        <h2
                            class="text-lg font-semibold text-gray-900 pb-4 border-b border-gray-200 mb-6 dark:text-white dark:border-gray-800">
                            Galerie photos</h2>

                        <div class="grid grid-cols-4 gap-3">
                            <div v-for="(img, idx) in galleryPreviews" :key="idx"
                                class="relative aspect-square bg-gray-100 rounded-lg overflow-hidden border border-gray-200 group dark:bg-gray-800 dark:border-gray-700">
                                <img :src="img.path" class="w-full h-full object-cover" />
                                <button @click.prevent="removeImage(idx, img.id)"
                                    class="absolute top-1 right-1 p-1.5 bg-red-500 text-white rounded-md opacity-0 group-hover:opacity-100 transition-opacity">
                                    <Trash2 class="w-3 h-3" />
                                </button>
                            </div>

                            <div
                                class="relative aspect-square bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex flex-col items-center justify-center text-gray-400 cursor-pointer transition-colors hover:border-blue-500 hover:text-blue-500 dark:bg-gray-800 dark:border-gray-700">
                                <Plus class="w-6 h-6 mb-1" />
                                <span class="text-xs font-medium">Ajouter</span>
                                <input type="file" multiple @change="onGalleryChange"
                                    class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" />
                            </div>
                        </div>
                        <p v-if="form.errors.gallery_images" class="text-sm text-red-500 mt-3">{{
                            form.errors.gallery_images }}</p>
                    </div>

                    <!-- Description -->
                    <div
                        class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm dark:bg-gray-900/50 dark:border-gray-800">
                        <h2
                            class="text-lg font-semibold text-gray-900 pb-4 border-b border-gray-200 mb-6 dark:text-white dark:border-gray-800">
                            Description</h2>
                        <textarea v-model="form.description" rows="6"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-gray-50 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all resize-y dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                            placeholder="Détails du produit..."></textarea>
                        <p v-if="form.errors.description" class="text-sm text-red-500 mt-2">{{ form.errors.description
                            }}</p>
                    </div>
                </div>
            </div>

            <!-- Variants -->
            <div
                class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm dark:bg-gray-900/50 dark:border-gray-800">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200 dark:border-gray-800">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Variantes & Stock</h2>
                    <button @click.prevent="addVariant"
                        class="px-4 py-2 rounded-lg bg-blue-50 text-blue-600 font-medium text-sm hover:bg-blue-600 hover:text-white transition-all dark:bg-blue-950/30 dark:text-blue-400">
                        + Ajouter une variante
                    </button>
                </div>

                <div class="space-y-3">
                    <div v-for="(variant, index) in form.variants" :key="index"
                        class="grid grid-cols-1 gap-3 p-4 bg-gray-50 rounded-lg dark:bg-gray-800/50 md:grid-cols-5">
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-bold uppercase text-gray-500">Type</label>
                            <input v-model="variant.name" type="text" placeholder="Couleur, Taille..."
                                class="px-3 py-2 rounded-lg border border-gray-200 bg-white text-sm dark:bg-gray-900 dark:border-gray-700" />
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-bold uppercase text-gray-500">Valeur</label>
                            <input v-model="variant.value" type="text" placeholder="Rouge, XL..."
                                class="px-3 py-2 rounded-lg border border-gray-200 bg-white text-sm dark:bg-gray-900 dark:border-gray-700" />
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-bold uppercase text-gray-500">Couleur (Hex)</label>
                            <div class="flex gap-2">
                                <input v-model="variant.color_code" type="color"
                                    class="w-10 h-10 rounded-lg border border-gray-200 cursor-pointer" />
                                <input v-model="variant.color_code" type="text" placeholder="#FFFFFF"
                                    class="flex-1 px-3 py-2 rounded-lg border border-gray-200 bg-white text-xs font-mono uppercase dark:bg-gray-900 dark:border-gray-700" />
                            </div>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-bold uppercase text-gray-500">Stock</label>
                            <input v-model="variant.stock" type="number"
                                class="px-3 py-2 rounded-lg border border-gray-200 bg-white text-sm dark:bg-gray-900 dark:border-gray-700" />
                        </div>

                        <div class="flex items-end">
                            <button @click.prevent="removeVariant(index)" v-if="form.variants.length > 1"
                                class="w-full py-2 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all dark:bg-red-950/30">
                                <Trash2 class="w-4 h-4 mx-auto" />
                            </button>
                        </div>
                    </div>
                </div>
                <p v-if="form.errors.variants" class="text-sm text-red-500 mt-3">{{ form.errors.variants }}</p>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end">
                <button type="submit" :disabled="form.processing"
                    class="px-8 py-3 rounded-lg bg-gradient-to-r from-blue-600 to-blue-500 text-white font-semibold shadow-lg shadow-blue-500/20 transition-all hover:shadow-xl hover:shadow-blue-500/30 hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed">
                    {{ form.processing ? 'Chargement...' : (product ? 'Mettre à jour' : 'Enregistrer le produit') }}
                </button>
            </div>
        </form>
    </div>
</template>
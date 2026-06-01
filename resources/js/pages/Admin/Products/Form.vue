<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { store as admin_products_store, update as admin_products_update } from '@/routes/admin/products';
import { computed, ref } from 'vue';
import { ArrowLeft, Camera, Trash2, Plus, Minus, UploadCloud, Image, Package, Tag, Truck, Percent, CheckCircle } from 'lucide-vue-next';
import type { Category } from '@/types';

const props = defineProps<{
    categories: Category[];
    product: any;
}>();

const isEditing = !!props.product;

const form = useForm({
    category_id: props.product?.category_id ?? '',
    name: props.product?.name ?? '',
    slug: props.product?.slug ?? '',
    description: props.product?.description ?? '',
    base_price: props.product?.base_price ?? '',
    shipping_cost: props.product?.shipping_cost ?? '',
    original_price: props.product?.original_price ?? '',
    promo_min_quantity: props.product?.promo_min_quantity ?? '',
    promo_discount_percent: props.product?.promo_discount_percent ?? '',
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
        shipping_cost: data.shipping_cost === '' ? 0 : data.shipping_cost,
        base_price: data.base_price === '' ? null : data.base_price,
        promo_min_quantity: data.promo_min_quantity === '' ? null : data.promo_min_quantity,
        promo_discount_percent: data.promo_discount_percent === '' ? null : data.promo_discount_percent,
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
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
        .replace(/ /g, '-')
        .replace(/[^\w-]+/g, '');
};
</script>

<template>
    <Head :title="isEditing ? 'Modifier le Produit' : 'Ajouter un Produit'" />

    <div class="py-6 md:py-8 px-4 max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <Link
                href="/admin/products"
                class="w-10 h-10 rounded-xl border border-border bg-card flex items-center justify-center text-muted-foreground hover:text-primary hover:border-primary transition-all duration-300"
            >
                <ArrowLeft class="w-5 h-5" />
            </Link>
            <div>
                <h1 class="text-2xl md:text-3xl font-black tracking-tight text-foreground">
                    {{ isEditing ? 'Modifier' : 'Ajouter' }} un produit
                </h1>
                <p class="text-sm text-muted-foreground mt-1">
                    {{ isEditing ? 'Modifiez les informations du produit' : 'Créez un nouveau produit pour votre catalogue' }}
                </p>
            </div>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Informations Générales -->
                    <div class="bg-card border border-border rounded-2xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-border bg-secondary/30">
                            <div class="flex items-center gap-2">
                                <div class="p-1.5 bg-primary/10 rounded-lg">
                                    <Package class="w-4 h-4 text-primary" />
                                </div>
                                <h2 class="text-lg font-bold text-foreground">Informations générales</h2>
                            </div>
                        </div>
                        <div class="p-6 space-y-5">
                            <!-- Nom -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-muted-foreground mb-2">
                                    Nom du produit <span class="text-primary">*</span>
                                </label>
                                <input
                                    v-model="form.name"
                                    @input="generateSlug"
                                    type="text"
                                    class="w-full px-4 py-3 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-foreground placeholder:text-muted-foreground/50"
                                    placeholder="ex: Câble électrique 2.5mm²"
                                />
                                <p v-if="form.errors.name" class="mt-2 text-xs font-medium text-red-500">{{ form.errors.name }}</p>
                            </div>

                            <!-- Slug -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-muted-foreground mb-2">
                                    Slug
                                </label>
                                <input
                                    v-model="form.slug"
                                    type="text"
                                    readonly
                                    class="w-full px-4 py-3 bg-secondary/50 border border-border rounded-xl cursor-not-allowed text-muted-foreground"
                                />
                                <p class="text-xs text-muted-foreground mt-1">Généré automatiquement à partir du nom</p>
                            </div>

                            <!-- Catégorie -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-muted-foreground mb-2">
                                    Catégorie <span class="text-primary">*</span>
                                </label>
                                <select
                                    v-model="form.category_id"
                                    class="w-full px-4 py-3 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-foreground"
                                >
                                    <option value="">Sélectionner une catégorie</option>
                                    <template v-for="parent in categories" :key="parent.id">
                                        <optgroup :label="parent.name">
                                            <option v-for="child in parent.children ?? []" :key="child.id" :value="child.id">
                                                └ {{ child.name }}
                                            </option>
                                        </optgroup>
                                    </template>
                                </select>
                                <p v-if="form.errors.category_id" class="mt-2 text-xs font-medium text-red-500">{{ form.errors.category_id }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Prix -->
                    <div class="bg-card border border-border rounded-2xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-border bg-secondary/30">
                            <div class="flex items-center gap-2">
                                <div class="p-1.5 bg-primary/10 rounded-lg">
                                    <Tag class="w-4 h-4 text-primary" />
                                </div>
                                <h2 class="text-lg font-bold text-foreground">Tarification</h2>
                            </div>
                        </div>
                        <div class="p-6 space-y-5">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-muted-foreground mb-2">
                                        Prix actuel (XAF)
                                    </label>
                                    <input
                                        v-model="form.base_price"
                                        type="number"
                                        step="1"
                                        class="w-full px-4 py-3 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-foreground"
                                        placeholder="150000"
                                    />
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-muted-foreground mb-2">
                                        Ancien prix (XAF)
                                    </label>
                                    <input
                                        v-model="form.original_price"
                                        type="number"
                                        step="1"
                                        class="w-full px-4 py-3 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-foreground"
                                        placeholder="Optionnel"
                                    />
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-muted-foreground mb-2">
                                    Frais de livraison (XAF)
                                </label>
                                <div class="relative">
                                    <Truck class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" />
                                    <input
                                        v-model="form.shipping_cost"
                                        type="number"
                                        step="1"
                                        class="w-full pl-11 pr-4 py-3 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-foreground"
                                        placeholder="0 = livraison gratuite"
                                    />
                                </div>
                            </div>

                            <!-- Remise -->
                            <div class="pt-2">
                                <div class="flex items-center gap-2 mb-4">
                                    <Percent class="w-4 h-4 text-primary" />
                                    <span class="text-sm font-semibold text-foreground">Promotion en gros</span>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-muted-foreground mb-2">
                                            Quantité minimum
                                        </label>
                                        <input
                                            v-model="form.promo_min_quantity"
                                            type="number"
                                            step="1"
                                            min="1"
                                            class="w-full px-4 py-3 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-foreground"
                                            placeholder="ex: 5"
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-muted-foreground mb-2">
                                            Réduction (%)
                                        </label>
                                        <input
                                            v-model="form.promo_discount_percent"
                                            type="number"
                                            step="1"
                                            min="1"
                                            max="25"
                                            class="w-full px-4 py-3 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-foreground"
                                            placeholder="Max 25%"
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- Badge réduction -->
                            <div v-if="discountPercent" class="flex items-center gap-3 p-3 rounded-xl bg-primary/10 border border-primary/20">
                                <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center">
                                    <Percent class="w-5 h-5 text-white" />
                                </div>
                                <div>
                                    <p class="font-semibold text-sm text-primary">-{{ discountPercent }}% de réduction</p>
                                    <p class="text-xs text-muted-foreground">
                                        {{ Number(form.original_price).toLocaleString() }} XAF → {{ Number(form.base_price).toLocaleString() }} XAF
                                    </p>
                                </div>
                            </div>

                            <!-- Actif -->
                            <div class="flex items-center gap-3 pt-2">
                                <input
                                    type="checkbox"
                                    v-model="form.is_active"
                                    id="is_active"
                                    class="w-4 h-4 rounded border-border text-primary focus:ring-primary focus:ring-offset-0"
                                />
                                <label for="is_active" class="text-sm font-medium text-foreground">Produit actif</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Image principale -->
                    <div class="bg-card border border-border rounded-2xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-border bg-secondary/30">
                            <div class="flex items-center gap-2">
                                <div class="p-1.5 bg-primary/10 rounded-lg">
                                    <Camera class="w-4 h-4 text-primary" />
                                </div>
                                <h2 class="text-lg font-bold text-foreground">Image principale</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="relative cursor-pointer group">
                                <div class="aspect-video bg-secondary rounded-xl overflow-hidden border-2 border-dashed border-border transition-all group-hover:border-primary">
                                    <img v-if="featuredPreview" :src="featuredPreview" class="w-full h-full object-cover" />
                                    <div v-else class="absolute inset-0 flex flex-col items-center justify-center text-muted-foreground">
                                        <UploadCloud class="w-12 h-12 mb-2" />
                                        <span class="text-sm font-medium">Choisir une image</span>
                                    </div>
                                </div>
                                <input type="file" @change="onFeaturedChange" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" />
                            </div>
                            <p v-if="form.errors.featured_image" class="mt-2 text-xs font-medium text-red-500">{{ form.errors.featured_image }}</p>
                        </div>
                    </div>

                    <!-- Galerie -->
                    <div class="bg-card border border-border rounded-2xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-border bg-secondary/30">
                            <div class="flex items-center gap-2">
                                <div class="p-1.5 bg-primary/10 rounded-lg">
                                    <Image class="w-4 h-4 text-primary" />
                                </div>
                                <h2 class="text-lg font-bold text-foreground">Galerie photos</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-4 gap-3">
                                <div v-for="(img, idx) in galleryPreviews" :key="idx" class="relative aspect-square bg-secondary rounded-xl overflow-hidden border border-border group">
                                    <img :src="img.path" class="w-full h-full object-cover" />
                                    <button
                                        @click.prevent="removeImage(idx, img.id)"
                                        class="absolute top-2 right-2 p-1.5 bg-red-500 text-white rounded-lg opacity-0 group-hover:opacity-100 transition-opacity"
                                    >
                                        <Trash2 class="w-3 h-3" />
                                    </button>
                                </div>
                                <div class="relative aspect-square bg-secondary rounded-xl border-2 border-dashed border-border flex flex-col items-center justify-center text-muted-foreground cursor-pointer transition-all hover:border-primary hover:text-primary">
                                    <Plus class="w-6 h-6 mb-1" />
                                    <span class="text-xs font-medium">Ajouter</span>
                                    <input type="file" multiple @change="onGalleryChange" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" />
                                </div>
                            </div>
                            <p v-if="form.errors.gallery_images" class="mt-3 text-xs font-medium text-red-500">{{ form.errors.gallery_images }}</p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-card border border-border rounded-2xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-border bg-secondary/30">
                            <h2 class="text-lg font-bold text-foreground">Description</h2>
                        </div>
                        <div class="p-6">
                            <textarea
                                v-model="form.description"
                                rows="6"
                                class="w-full px-4 py-3 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-foreground placeholder:text-muted-foreground/50 resize-none"
                                placeholder="Décrivez votre produit en détail..."
                            ></textarea>
                            <p v-if="form.errors.description" class="mt-2 text-xs font-medium text-red-500">{{ form.errors.description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Variants -->
            <div class="bg-card border border-border rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-border bg-secondary/30 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-foreground">Variantes & Stock</h2>
                    <button
                        @click.prevent="addVariant"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 text-primary rounded-xl text-sm font-semibold hover:bg-primary hover:text-white transition-all duration-300"
                    >
                        <Plus class="w-4 h-4" />
                        Ajouter une variante
                    </button>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div v-for="(variant, index) in form.variants" :key="index" class="grid grid-cols-1 md:grid-cols-5 gap-3 p-4 bg-secondary rounded-xl">
                            <div>
                                <label class="text-xs font-bold uppercase text-muted-foreground">Type</label>
                                <input
                                    v-model="variant.name"
                                    type="text"
                                    placeholder="Couleur, Taille..."
                                    class="w-full mt-1 px-3 py-2 bg-card border border-border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                                />
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase text-muted-foreground">Valeur</label>
                                <input
                                    v-model="variant.value"
                                    type="text"
                                    placeholder="Rouge, XL..."
                                    class="w-full mt-1 px-3 py-2 bg-card border border-border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                                />
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase text-muted-foreground">Couleur (Hex)</label>
                                <div class="flex gap-2 mt-1">
                                    <input v-model="variant.color_code" type="color" class="w-10 h-10 rounded-lg border border-border cursor-pointer" />
                                    <input
                                        v-model="variant.color_code"
                                        type="text"
                                        placeholder="#FFFFFF"
                                        class="flex-1 px-3 py-2 bg-card border border-border rounded-lg text-sm font-mono uppercase focus:outline-none focus:ring-2 focus:ring-primary"
                                    />
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase text-muted-foreground">Supplément</label>
                                <input
                                    v-model="variant.price_override"
                                    type="number"
                                    step="0.01"
                                    placeholder="0"
                                    class="w-full mt-1 px-3 py-2 bg-card border border-border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                                />
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase text-muted-foreground">Stock</label>
                                <input
                                    v-model="variant.stock"
                                    type="number"
                                    placeholder="0"
                                    class="w-full mt-1 px-3 py-2 bg-card border border-border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                                />
                            </div>
                            <div class="flex items-end">
                                <button
                                    v-if="form.variants.length > 1"
                                    @click.prevent="removeVariant(index)"
                                    class="w-full py-2 rounded-lg bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300"
                                >
                                    <Trash2 class="w-4 h-4 mx-auto" />
                                </button>
                            </div>
                        </div>
                    </div>
                    <p v-if="form.errors.variants" class="mt-3 text-xs font-medium text-red-500">{{ form.errors.variants }}</p>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end pt-4">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="inline-flex items-center gap-2 px-8 py-3.5 bg-gradient-to-r from-primary to-primary-dark text-white font-bold rounded-xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-primary/30 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
                >
                    <CheckCircle v-if="!form.processing" class="w-5 h-5" />
                    <span v-else class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                    {{ form.processing ? 'Enregistrement...' : (isEditing ? 'Mettre à jour' : 'Créer le produit') }}
                </button>
            </div>
        </form>
    </div>
</template>

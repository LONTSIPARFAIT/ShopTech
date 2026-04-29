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

    <div class="form-container">
        <!-- Header -->
        <div class="form-header">
            <Link href="/admin/products" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </Link>
            <h1 class="page-title">{{ product ? 'Modifier' : 'Ajouter' }} un Produit</h1>
        </div>

        <form @submit.prevent="submit">
            <div class="grid-2cols">
                <!-- Left Column: Main Information -->
                <div class="form-card">
                    <h2 class="form-card-title">Informations Générales</h2>
                    
                    <div class="form-group">
                        <label class="form-label">Nom du produit</label>
                        <input 
                            v-model="form.name" 
                            @input="generateSlug"
                            type="text" 
                            class="form-input"
                            placeholder="ex: iPhone 15 Pro"
                        />
                        <p v-if="form.errors.name" class="form-error">{{ form.errors.name }}</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Slug</label>
                        <input 
                            v-model="form.slug" 
                            type="text" 
                            class="form-input"
                            placeholder="iphone-15-pro"
                        />
                        <p v-if="form.errors.slug" class="form-error">{{ form.errors.slug }}</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Catégorie</label>
                        <select 
                            v-model="form.category_id"
                            class="form-select"
                        >
                            <option value="">Sélectionner une catégorie</option>
                            <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                        </select>
                        <p v-if="form.errors.category_id" class="form-error">{{ form.errors.category_id }}</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Prix actuel (XAF)</label>
                            <input
                                v-model="form.base_price"
                                type="number"
                                step="1"
                                class="form-input"
                                placeholder="150000"
                            />
                            <p v-if="form.errors.base_price" class="form-error">{{ form.errors.base_price }}</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Ancien prix (XAF)</label>
                            <input
                                v-model="form.original_price"
                                type="number"
                                step="1"
                                class="form-input"
                                placeholder="Optionnel"
                            />
                            <p v-if="form.errors.original_price" class="form-error">{{ form.errors.original_price }}</p>
                        </div>
                    </div>

                    <!-- Discount preview -->
                    <div v-if="discountPercent" class="discount-badge">
                        <div class="discount-percent">-{{ discountPercent }}%</div>
                        <div class="discount-info">
                            <p class="discount-title">Réduction automatique</p>
                            <p class="discount-details">
                                {{ Number(form.original_price).toLocaleString() }} XAF → {{ Number(form.base_price).toLocaleString() }} XAF
                            </p>
                        </div>
                    </div>

                    <div class="form-checkbox">
                        <input type="checkbox" v-model="form.is_active" id="is_active" />
                        <label for="is_active">Produit actif</label>
                    </div>
                </div>

                <!-- Right Column: Images & Description -->
                <div class="space-y-forms">
                    <!-- Featured Image -->
                    <div class="form-card">
                        <h2 class="form-card-title">Image principale</h2>
                        
                        <div class="image-upload-area">
                            <div class="image-preview">
                                <img v-if="featuredPreview" :src="featuredPreview" class="w-full h-full object-cover" />
                                <div v-else class="image-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                        <polyline points="21 15 16 10 5 21"/>
                                    </svg>
                                    <span>Choisir une image</span>
                                </div>
                            </div>
                            <input type="file" @change="onFeaturedChange" class="image-input" accept="image/*" />
                        </div>
                        <p v-if="form.errors.featured_image" class="form-error">{{ form.errors.featured_image }}</p>
                    </div>

                    <!-- Gallery -->
                    <div class="form-card">
                        <h2 class="form-card-title">Galerie photos</h2>
                        
                        <div class="gallery-grid">
                            <div v-for="(img, idx) in galleryPreviews" :key="idx" class="gallery-item">
                                <img :src="img.path" />
                                <button @click.prevent="removeImage(idx, img.id)" class="gallery-remove">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="gallery-add">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Ajouter</span>
                                <input type="file" multiple @change="onGalleryChange" accept="image/*" />
                            </div>
                        </div>
                        <p v-if="form.errors.gallery_images" class="form-error">{{ form.errors.gallery_images }}</p>
                    </div>

                    <!-- Description -->
                    <div class="form-card">
                        <h2 class="form-card-title">Description</h2>
                        <textarea 
                            v-model="form.description" 
                            rows="6"
                            class="form-textarea"
                            placeholder="Détails du produit..."
                        ></textarea>
                        <p v-if="form.errors.description" class="form-error">{{ form.errors.description }}</p>
                    </div>
                </div>
            </div>

            <!-- Variants -->
            <div class="form-card mt-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="form-card-title mb-0">Variantes & Stock</h2>
                    <button @click.prevent="addVariant" class="btn-add">
                        + Ajouter une variante
                    </button>
                </div>

                <div class="variants-list">
                    <div v-for="(variant, index) in form.variants" :key="index" class="variant-item">
                        <div class="variant-field">
                            <label class="variant-label">Type</label>
                            <input v-model="variant.name" type="text" placeholder="Couleur, Taille..." class="variant-input" />
                        </div>
                        
                        <div class="variant-field">
                            <label class="variant-label">Valeur</label>
                            <input v-model="variant.value" type="text" placeholder="Rouge, XL..." class="variant-input" />
                        </div>
                        
                        <div class="variant-field">
                            <label class="variant-label">Couleur (Hex)</label>
                            <div class="color-input-group">
                                <input v-model="variant.color_code" type="color" class="color-picker" />
                                <input v-model="variant.color_code" type="text" placeholder="#FFFFFF" class="color-hex" />
                            </div>
                        </div>
                        
                        <div class="variant-field">
                            <label class="variant-label">Supplément</label>
                            <input v-model="variant.price_override" type="number" step="0.01" class="variant-input" />
                        </div>
                        
                        <div class="variant-field">
                            <label class="variant-label">Stock</label>
                            <input v-model="variant.stock" type="number" class="variant-input" />
                        </div>
                        
                        <div class="flex items-end">
                            <button 
                                @click.prevent="removeVariant(index)"
                                v-if="form.variants.length > 1"
                                class="btn-remove-variant"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <p v-if="form.errors.variants" class="form-error">{{ form.errors.variants }}</p>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button 
                    type="submit"
                    :disabled="form.processing"
                    class="btn-submit"
                >
                    {{ form.processing ? 'Chargement...' : (product ? 'Mettre à jour' : 'Enregistrer le produit') }}
                </button>
            </div>
        </form>
    </div>
</template>
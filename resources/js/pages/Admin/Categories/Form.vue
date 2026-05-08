<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { store as admin_categories_store, update as admin_categories_update } from '@/routes/admin/categories';
import type { Category } from '@/types';
import { Save, ArrowLeft, Image as ImageIcon, X, Layers, Info, UploadCloud } from 'lucide-vue-next';

const props = defineProps<{
    category: Category | null;
}>();

const isEditing = !!props.category;

const form = useForm({
    name: props.category?.name ?? '',
    description: props.category?.description ?? '',
    image_file: null as File | null,
});

const imagePreview = ref<string | null>(props.category?.url ?? null);

const handleImageChange = (e: Event) => {
    const file = (e.target as HTMLInputElement).files?.[0];
    if (file) {
        form.image_file = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    if (isEditing) {
        form.transform((data) => ({
            ...data,
            _method: 'PUT',
        })).post(admin_categories_update(props.category!.id).url, {
            forceFormData: true,
        });
    } else {
        form.post(admin_categories_store().url);
    }
};
</script>

<template>
    <Head :title="`${isEditing ? 'Modifier' : 'Ajouter'} une Catégorie - Admin`" />

    <div class="admin-container max-w-4xl mx-auto">
        <!-- Header -->
        <div class="admin-header flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="admin-header-content text-left">
                <div class="flex items-center gap-2 mb-1">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 rounded-lg">
                        <Layers class="w-5 h-5" />
                    </div>
                    <h1 class="admin-title text-3xl font-extrabold tracking-tight">
                        {{ isEditing ? 'Modifier la catégorie' : 'Nouvelle catégorie' }}
                    </h1>
                </div>
                <p class="admin-subtitle text-gray-500">Remplissez les informations ci-dessous pour {{ isEditing ? 'mettre à jour' : 'créer' }} une catégorie.</p>
            </div>
            <Link 
                href="/admin/categories"
                class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-gray-500 hover:text-blue-600 transition-colors bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl"
            >
                <ArrowLeft class="w-4 h-4" />
                Retour à la liste
            </Link>
        </div>

        <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Side: Basic Info -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-800">
                    <div class="flex items-center gap-2 mb-6">
                        <Info class="w-5 h-5 text-blue-500" />
                        <h2 class="text-xl font-bold">Informations Générales</h2>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wider">Nom de la catégorie</label>
                            <input 
                                v-model="form.name"
                                type="text" 
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all font-medium"
                                placeholder="ex: Électricité, Plomberie..."
                                required
                            />
                            <div v-if="form.errors.name" class="mt-2 text-sm font-bold text-red-500">{{ form.errors.name }}</div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wider">Description (Optionnel)</label>
                            <textarea 
                                v-model="form.description"
                                rows="6"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all font-medium"
                                placeholder="Décrivez l'usage de cette catégorie pour vos clients..."
                            ></textarea>
                            <div v-if="form.errors.description" class="mt-2 text-sm font-bold text-red-500">{{ form.errors.description }}</div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button 
                        type="submit"
                        :disabled="form.processing"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold flex items-center justify-center gap-2 w-full md:w-auto px-10 py-4 shadow-xl shadow-blue-500/30 hover:shadow-blue-500/50 transform hover:-translate-y-1 transition-all rounded-2xl"
                    >
                        <Save v-if="!form.processing" class="w-5 h-5" />
                        <span v-else class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                        <span class="text-lg">{{ isEditing ? 'Enregistrer les modifications' : 'Créer la catégorie' }}</span>
                    </button>
                </div>
            </div>

            <!-- Right Side: Image -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-800 sticky top-8">
                    <div class="flex items-center gap-2 mb-6">
                        <ImageIcon class="w-5 h-5 text-blue-500" />
                        <h2 class="text-xl font-bold">Image</h2>
                    </div>

                    <div 
                        class="relative aspect-square rounded-2xl overflow-hidden bg-gray-50 dark:bg-gray-800 border-2 border-dashed border-gray-200 dark:border-gray-700 flex flex-col items-center justify-center group cursor-pointer hover:border-blue-500 transition-colors"
                        @click="$refs.fileInput.click()"
                    >
                        <img v-if="imagePreview" :src="imagePreview" class="w-full h-full object-cover" />
                        <div v-else class="flex flex-col items-center gap-2 text-gray-400 group-hover:text-blue-500 transition-colors">
                            <UploadCloud class="w-12 h-12" />
                            <span class="text-xs font-bold uppercase tracking-widest">Choisir une image</span>
                        </div>

                        <!-- Hover Overlay -->
                        <div v-if="imagePreview" class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="flex flex-col items-center gap-2 text-white">
                                <UploadCloud class="w-8 h-8" />
                                <span class="text-xs font-bold uppercase">Remplacer</span>
                            </div>
                        </div>
                    </div>

                    <input 
                        type="file" 
                        ref="fileInput"
                        class="hidden"
                        accept="image/*"
                        @change="handleImageChange"
                    />

                    <div class="mt-6 space-y-4">
                        <div class="flex items-start gap-2 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                            <Info class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" />
                            <p class="text-[10px] leading-relaxed text-blue-800 dark:text-blue-300 font-bold uppercase tracking-wider">
                                Une image carrée (1:1) est recommandée pour un affichage optimal dans la boutique.
                            </p>
                        </div>
                        <div v-if="form.errors.image_file" class="p-3 bg-red-50 dark:bg-red-900/20 rounded-xl">
                            <p class="text-xs font-bold text-red-600 dark:text-red-400">{{ form.errors.image_file }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

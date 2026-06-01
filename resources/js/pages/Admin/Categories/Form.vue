<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { store as admin_categories_store, update as admin_categories_update } from '@/routes/admin/categories';
import type { Category } from '@/types';
import { Save, ArrowLeft, Image as ImageIcon, X, Layers, Info, UploadCloud, FolderTree, FileText } from 'lucide-vue-next';

const props = defineProps<{
    category: Category | null;
    parents?: Category[];
}>();

const isEditing = !!props.category;

const form = useForm({
    name: props.category?.name ?? '',
    description: props.category?.description ?? '',
    parent_id: props.category?.parent_id ?? null,
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

const removeImage = () => {
    imagePreview.value = null;
    form.image_file = null;
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

    <div class="py-6 md:py-8 px-4 max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2.5 bg-primary/10 text-primary rounded-xl">
                        <Layers class="w-6 h-6" />
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-black tracking-tight text-foreground">
                            {{ isEditing ? 'Modifier la catégorie' : 'Nouvelle catégorie' }}
                        </h1>
                        <p class="text-sm text-muted-foreground mt-1">
                            {{ isEditing ? 'Modifiez les informations de la catégorie' : 'Créez une nouvelle catégorie pour organiser vos produits' }}
                        </p>
                    </div>
                </div>
            </div>
            <Link
                href="/admin/categories"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-muted-foreground bg-secondary hover:bg-secondary/80 rounded-xl transition-all duration-300 hover:-translate-y-0.5"
            >
                <ArrowLeft class="w-4 h-4" />
                Retour à la liste
            </Link>
        </div>

        <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            <!-- Left Side: Basic Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Formulaire principal -->
                <div class="bg-card border border-border rounded-2xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-border bg-secondary/30">
                        <div class="flex items-center gap-2">
                            <div class="p-1.5 bg-primary/10 rounded-lg">
                                <FileText class="w-4 h-4 text-primary" />
                            </div>
                            <h2 class="text-lg font-bold text-foreground">Informations générales</h2>
                        </div>
                    </div>

                    <div class="p-6 space-y-5">
                        <!-- Nom -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-muted-foreground mb-2">
                                Nom de la catégorie <span class="text-primary">*</span>
                            </label>
                            <input
                                v-model="form.name"
                                type="text"
                                class="w-full px-4 py-3 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-foreground placeholder:text-muted-foreground/50"
                                placeholder="ex: Électricité, Plomberie, Outillage..."
                                required
                            />
                            <p v-if="form.errors.name" class="mt-2 text-xs font-medium text-red-500">{{ form.errors.name }}</p>
                        </div>

                        <!-- Catégorie parente -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-muted-foreground mb-2">
                                Catégorie parente
                            </label>
                            <div class="relative">
                                <FolderTree class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" />
                                <select
                                    v-model="form.parent_id"
                                    class="w-full pl-10 pr-4 py-3 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent appearance-none text-foreground cursor-pointer"
                                >
                                    <option :value="null">📁 Aucune (catégorie racine)</option>
                                    <option v-for="parent in (props.parents ?? [])" :key="parent.id" :value="parent.id">
                                        📂 {{ parent.name }}
                                    </option>
                                </select>
                            </div>
                            <p v-if="form.errors.parent_id" class="mt-2 text-xs font-medium text-red-500">{{ form.errors.parent_id }}</p>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-muted-foreground mb-2">
                                Description
                            </label>
                            <textarea
                                v-model="form.description"
                                rows="5"
                                class="w-full px-4 py-3 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-foreground placeholder:text-muted-foreground/50 resize-none"
                                placeholder="Décrivez cette catégorie pour aider vos clients..."
                            ></textarea>
                            <p v-if="form.errors.description" class="mt-2 text-xs font-medium text-red-500">{{ form.errors.description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Bouton de validation -->
                <div class="flex justify-end pt-2">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="group relative inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-gradient-to-r from-primary to-primary-dark text-white font-bold rounded-xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-primary/30 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
                    >
                        <Save v-if="!form.processing" class="w-5 h-5" />
                        <span v-else class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                        <span>{{ isEditing ? 'Mettre à jour' : 'Créer la catégorie' }}</span>
                    </button>
                </div>
            </div>

            <!-- Right Side: Image -->
            <div class="lg:col-span-1">
                <div class="bg-card border border-border rounded-2xl overflow-hidden sticky top-6">
                    <div class="px-6 py-4 border-b border-border bg-secondary/30">
                        <div class="flex items-center gap-2">
                            <div class="p-1.5 bg-primary/10 rounded-lg">
                                <ImageIcon class="w-4 h-4 text-primary" />
                            </div>
                            <h2 class="text-lg font-bold text-foreground">Image</h2>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Zone de preview / upload -->
                        <div
                            class="relative aspect-square rounded-xl overflow-hidden bg-secondary border-2 border-dashed border-border hover:border-primary transition-all duration-300 group cursor-pointer"
                            @click="$refs.fileInput.click()"
                        >
                            <!-- Image preview -->
                            <img
                                v-if="imagePreview"
                                :src="imagePreview"
                                class="w-full h-full object-cover"
                                alt="Aperçu"
                            />

                            <!-- Placeholder -->
                            <div v-else class="flex flex-col items-center justify-center h-full gap-3">
                                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center">
                                    <UploadCloud class="w-8 h-8 text-primary" />
                                </div>
                                <div class="text-center">
                                    <p class="text-sm font-medium text-foreground">Cliquez pour uploader</p>
                                    <p class="text-xs text-muted-foreground">PNG, JPG jusqu'à 2MB</p>
                                </div>
                            </div>

                            <!-- Overlay au survol -->
                            <div class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <div class="text-center text-white">
                                    <UploadCloud class="w-8 h-8 mx-auto mb-2" />
                                    <span class="text-xs font-semibold">Changer l'image</span>
                                </div>
                            </div>

                            <!-- Bouton supprimer -->
                            <button
                                v-if="imagePreview"
                                type="button"
                                @click.stop="removeImage"
                                class="absolute top-2 right-2 w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center hover:bg-red-600 transition-colors shadow-lg"
                            >
                                <X class="w-4 h-4 text-white" />
                            </button>
                        </div>

                        <input
                            type="file"
                            ref="fileInput"
                            class="hidden"
                            accept="image/jpeg,image/png,image/webp,image/gif"
                            @change="handleImageChange"
                        />

                        <!-- Info -->
                        <div class="mt-4 p-3 bg-secondary/50 rounded-xl">
                            <div class="flex items-start gap-2">
                                <Info class="w-4 h-4 text-primary shrink-0 mt-0.5" />
                                <div class="text-xs text-muted-foreground leading-relaxed">
                                    <p class="font-semibold text-foreground mb-1">Conseils :</p>
                                    <ul class="list-disc list-inside space-y-0.5">
                                        <li>Format carré (1:1) recommandé</li>
                                        <li>Résolution minimale : 400x400px</li>
                                        <li>Poids maximum : 2 Mo</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Erreur image -->
                        <p v-if="form.errors.image_file" class="mt-3 text-xs font-medium text-red-500">{{ form.errors.image_file }}</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

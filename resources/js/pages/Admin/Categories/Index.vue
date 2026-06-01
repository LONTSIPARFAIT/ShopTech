<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Plus, Pencil, Trash2, FolderSearch, Layers, Search, ChevronDown, Package, Calendar, ChevronRight } from 'lucide-vue-next';
import { ref, computed } from 'vue';
import { create as admin_categories_create, edit as admin_categories_edit, destroy as admin_categories_destroy } from '@/routes/admin/categories';
import type { Category } from '@/types';

const props = defineProps<{
    categories: Category[];
}>();

const search = ref('');
const expandedCategoryIds = ref<number[]>([]);

const toggleCategory = (id: number) => {
    if (expandedCategoryIds.value.includes(id)) {
        expandedCategoryIds.value = expandedCategoryIds.value.filter(item => item !== id);
    } else {
        expandedCategoryIds.value.push(id);
    }
};

const filteredCategories = computed(() => {
    if (!search.value) return props.categories;
    const q = search.value.toLowerCase();
    return props.categories.filter((c) =>
        c.name.toLowerCase().includes(q) ||
        (c.description?.toLowerCase().includes(q) ?? false) ||
        (c.children ?? []).some((child) => child.name.toLowerCase().includes(q) || (child.description?.toLowerCase().includes(q) ?? false))
    );
});

const categoryCount = computed(() => {
    return props.categories.reduce((count, category) => {
        return count + 1 + (category.children?.length ?? 0);
    }, 0);
});

const productCount = computed(() => {
    return props.categories.reduce((count, category) => {
        const parentProducts = category.products_count ?? 0;
        const childrenProducts = (category.children ?? []).reduce((childCount, child) => {
            return childCount + (child.products_count ?? 0);
        }, 0);
        return count + parentProducts + childrenProducts;
    }, 0);
});

const deleteCategory = (id: number) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')) {
        router.delete(admin_categories_destroy(id).url);
    }
};
</script>

<template>
    <Head title="Gestion des Catégories - Admin" />

    <div class="py-6 md:py-8 px-4 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2.5 bg-primary/10 text-primary rounded-xl">
                        <Layers class="w-6 h-6" />
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-black tracking-tight text-foreground">Catégories</h1>
                        <p class="text-sm text-muted-foreground mt-1">
                            Organisez vos produits par secteurs d'activité (Électricité, Plomberie, etc.)
                        </p>
                    </div>
                </div>
            </div>
            <Link
                :href="admin_categories_create().url"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary to-primary-dark text-white font-bold rounded-xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-primary/30"
            >
                <Plus class="w-5 h-5" />
                <span>Ajouter une catégorie</span>
            </Link>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-card border border-border rounded-xl p-5">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 bg-primary/10 rounded-lg">
                        <Layers class="w-4 h-4 text-primary" />
                    </div>
                    <span class="text-2xl font-black text-primary">{{ categoryCount }}</span>
                </div>
                <div class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Total catégories</div>
            </div>
            <div class="bg-card border border-border rounded-xl p-5">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 bg-primary/10 rounded-lg">
                        <Package class="w-4 h-4 text-primary" />
                    </div>
                    <span class="text-2xl font-black text-primary">{{ productCount }}</span>
                </div>
                <div class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Total produits</div>
            </div>
            <div class="bg-card border border-border rounded-xl p-5">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 bg-primary/10 rounded-lg">
                        <Calendar class="w-4 h-4 text-primary" />
                    </div>
                    <span class="text-lg font-bold text-foreground">
                        {{ categories.length > 0 ? new Date(categories[0].created_at).toLocaleDateString('fr-FR') : '-' }}
                    </span>
                </div>
                <div class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Dernière mise à jour</div>
            </div>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <div class="relative">
                <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" />
                <input
                    v-model="search"
                    type="text"
                    placeholder="Rechercher une catégorie..."
                    class="w-full pl-11 pr-4 py-3 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-foreground placeholder:text-muted-foreground/50"
                />
            </div>
        </div>

        <!-- Table -->
        <div class="bg-card border border-border rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-border bg-secondary/30">
                            <th class="px-6 py-4 text-left text-xs font-bold text-muted-foreground uppercase tracking-wider">Catégorie</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-muted-foreground uppercase tracking-wider">Description</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-muted-foreground uppercase tracking-wider">Produits</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-muted-foreground uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        <template v-for="category in filteredCategories" :key="category.id">
                            <!-- Catégorie parente -->
                            <tr class="group hover:bg-secondary/30 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-secondary border border-border shrink-0">
                                                <img v-if="category.url" :src="category.url" class="w-full h-full object-cover" />
                                                <div v-else class="w-full h-full flex items-center justify-center text-muted-foreground">
                                                    <FolderSearch class="w-5 h-5" />
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-foreground">{{ category.name }}</div>
                                                <div class="text-xs text-muted-foreground">{{ category.slug }}</div>
                                            </div>
                                        </div>

                                        <button
                                            v-if="category.children?.length"
                                            @click.stop="toggleCategory(category.id)"
                                            class="flex items-center justify-center w-8 h-8 rounded-full border border-border text-muted-foreground hover:text-primary hover:bg-primary/10 transition"
                                        >
                                            <ChevronRight :class="['w-4 h-4 transition-transform duration-200', expandedCategoryIds.includes(category.id) ? 'rotate-90' : '']" />
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-muted-foreground line-clamp-2 max-w-xs">
                                        {{ category.description || 'Aucune description.' }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary">
                                        {{ (category.products_count ?? 0) + ((category.children ?? []).reduce((sum, child) => sum + (child.products_count ?? 0), 0)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <Link
                                            :href="admin_categories_edit(category.id).url"
                                            class="p-2 text-muted-foreground hover:text-primary hover:bg-primary/10 rounded-lg transition-all"
                                            title="Modifier"
                                        >
                                            <Pencil class="w-4 h-4" />
                                        </Link>
                                        <button
                                            @click="deleteCategory(category.id)"
                                            class="p-2 text-muted-foreground hover:text-red-500 hover:bg-red-500/10 rounded-lg transition-all"
                                            title="Supprimer"
                                        >
                                            <Trash2 class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Sous-catégories -->
                            <tr v-if="category.children?.length && expandedCategoryIds.includes(category.id)">
                                <td colspan="4" class="px-6 py-4 bg-secondary/20">
                                    <div class="ml-8 space-y-2">
                                        <div class="text-xs font-semibold uppercase tracking-wider text-muted-foreground mb-2">Sous-catégories</div>
                                        <div class="space-y-2">
                                            <div v-for="child in category.children" :key="child.id" class="p-4 bg-card border border-border rounded-xl">
                                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                                    <div>
                                                        <div class="text-sm font-bold text-foreground">{{ child.name }}</div>
                                                        <div class="text-xs text-muted-foreground">{{ child.description || 'Aucune description.' }}</div>
                                                    </div>
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary">
                                                            {{ child.products_count ?? 0 }} produits
                                                        </span>
                                                        <Link
                                                            :href="admin_categories_edit(child.id).url"
                                                            class="px-3 py-1.5 text-xs font-semibold text-primary bg-primary/10 rounded-lg hover:bg-primary/20 transition"
                                                        >
                                                            Modifier
                                                        </Link>
                                                        <button
                                                            @click="deleteCategory(child.id)"
                                                            class="px-3 py-1.5 text-xs font-semibold text-red-500 bg-red-500/10 rounded-lg hover:bg-red-500/20 transition"
                                                        >
                                                            Supprimer
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div v-if="filteredCategories.length === 0" class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                    <FolderSearch class="w-10 h-10 text-primary" />
                </div>
                <h3 class="text-lg font-bold text-foreground mb-2">Aucune catégorie trouvée</h3>
                <p class="text-sm text-muted-foreground max-w-sm mb-6">
                    Aucune catégorie ne correspond à votre recherche. Essayez d'autres mots-clés ou créez-en une nouvelle.
                </p>
                <Link
                    :href="admin_categories_create().url"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary to-primary-dark text-white font-bold rounded-xl transition-all hover:-translate-y-0.5"
                >
                    <Plus class="w-5 h-5" />
                    Créer une catégorie
                </Link>
            </div>
        </div>
    </div>
</template>

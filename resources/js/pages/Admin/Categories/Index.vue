<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { create as admin_categories_create, edit as admin_categories_edit, destroy as admin_categories_destroy } from '@/routes/admin/categories';
import type { Category } from '@/types';
import { Plus, Pencil, Trash2, FolderSearch, LayoutGrid, Layers, Search, MoreVertical } from 'lucide-vue-next';
import { ref, computed } from 'vue';

const props = defineProps<{
    categories: Category[];
}>();

const search = ref('');

const filteredCategories = computed(() => {
    if (!search.value) return props.categories;
    const q = search.value.toLowerCase();
    return props.categories.filter(c => 
        c.name.toLowerCase().includes(q) || (c.description?.toLowerCase().includes(q) ?? false)
    );
});

const deleteCategory = (id: number) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')) {
        router.delete(admin_categories_destroy(id).url);
    }
};
</script>

<template>
    <Head title="Gestion des Catégories - Admin" />

    <div class="admin-container">
        <!-- Header -->
        <div class="admin-header flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="admin-header-content">
                <div class="flex items-center gap-2 mb-1">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 rounded-lg">
                        <Layers class="w-5 h-5" />
                    </div>
                    <h1 class="admin-title text-3xl font-extrabold tracking-tight">Catégories</h1>
                </div>
                <p class="admin-subtitle text-gray-500">Organisez vos produits par secteurs d'activité (Électricité, Plomberie, etc.)</p>
            </div>
            <Link 
                :href="admin_categories_create().url"
                class="btn-primary shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 transform hover:-translate-y-0.5 transition-all"
            >
                <Plus class="w-5 h-5" />
                <span>Ajouter une Catégorie</span>
            </Link>
        </div>

        <!-- Stats Quick Look -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white dark:bg-gray-900 p-4 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Catégories</div>
                <div class="text-2xl font-black text-gray-900 dark:text-white">{{ categories.length }}</div>
            </div>
            <div class="bg-white dark:bg-gray-900 p-4 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Produits</div>
                <div class="text-2xl font-black text-blue-600">{{ categories.reduce((acc, c) => acc + (c.products_count || 0), 0) }}</div>
            </div>
            <div class="bg-white dark:bg-gray-900 p-4 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Dernière mise à jour</div>
                <div class="text-lg font-bold text-gray-700 dark:text-gray-300">
                    {{ categories.length > 0 ? new Date(categories[0].created_at).toLocaleDateString('fr-FR') : '-' }}
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="mb-6 relative">
            <Search class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />
            <input 
                v-model="search"
                type="text" 
                placeholder="Rechercher une catégorie..." 
                class="w-full pl-10 pr-4 py-3 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all shadow-sm"
            />
        </div>

        <!-- Table container -->
        <div class="admin-table-container shadow-xl shadow-gray-200/50 dark:shadow-none overflow-hidden rounded-2xl border-none">
            <div class="overflow-x-auto">
                <table class="admin-table border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Catégorie</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Description</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">Produits</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <tr v-for="category in filteredCategories" :key="category.id" class="admin-table-row group transition-all hover:bg-blue-50/30 dark:hover:bg-blue-900/10">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 flex-shrink-0 relative group-hover:scale-105 transition-transform duration-300">
                                        <img v-if="category.url" :src="category.url" class="w-full h-full object-cover" />
                                        <div v-else class="w-full h-full flex items-center justify-center text-gray-400">
                                            <FolderSearch class="w-6 h-6" />
                                        </div>
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors"></div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ category.name }}</div>
                                        <div class="text-xs font-medium text-blue-600 dark:text-blue-400 opacity-0 group-hover:opacity-100 transition-opacity">
                                            {{ category.slug }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
                                    {{ category.description || 'Aucune description disponible pour cette catégorie.' }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                    {{ category.products_count }} items
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <Link 
                                        :href="admin_categories_edit(category.id).url"
                                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-100 dark:hover:bg-blue-900/40 rounded-lg transition-all"
                                        title="Modifier"
                                    >
                                        <Pencil class="w-4 h-4" />
                                    </Link>
                                    <button 
                                        @click="deleteCategory(category.id)"
                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-100 dark:hover:bg-red-900/40 rounded-lg transition-all"
                                        title="Supprimer"
                                    >
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div v-if="filteredCategories.length === 0" class="flex flex-col items-center justify-center py-20 text-center bg-white dark:bg-gray-900">
                <div class="relative mb-6">
                    <div class="absolute -inset-4 bg-blue-100 dark:bg-blue-900/20 rounded-full animate-pulse"></div>
                    <FolderSearch class="relative w-16 h-16 text-blue-500" />
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Aucune catégorie trouvée</h3>
                <p class="text-gray-500 dark:text-gray-400 max-w-sm mb-8">
                    Nous n'avons trouvé aucune catégorie correspondant à votre recherche. Essayez d'autres mots-clés ou créez-en une nouvelle.
                </p>
                <Link 
                    :href="admin_categories_create().url"
                    class="btn-primary"
                >
                    <Plus class="w-5 h-5 mr-2" />
                    Créer ma première catégorie
                </Link>
            </div>
        </div>
    </div>
</template>

<style scoped>
.admin-table-row {
    transition: all 0.2s ease;
}
.admin-table-row:hover {
    transform: scale(1.002);
    z-index: 10;
}
</style>

<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { create as admin_products_create, edit as admin_products_edit, destroy as admin_products_destroy } from '@/routes/admin/products';

const props = defineProps<{
    products: any[];
}>();

const deleteProduct = (id: number) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
        router.delete(admin_products_destroy(id).url);
    }
};
</script>

<template>
    <Head title="Gestion des Produits - Admin" />

    <div class="p-6 lg:p-12 space-y-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-1">
                <h1 class="text-3xl font-black tracking-tight">Produits</h1>
                <p class="text-slate-500">Gérez le catalogue de votre boutique.</p>
            </div>
            <Link 
                :href="admin_products_create().url"
                class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-2xl font-bold shadow-lg shadow-blue-500/20 hover:bg-blue-700 transition-all"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter un Produit
            </Link>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50">
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Produit</th>
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Catégorie</th>
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Prix</th>
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Stock</th>
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Statut</th>
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        <tr v-for="product in products" :key="product.id" class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-800 overflow-hidden flex-shrink-0">
                                        <img v-if="product.featured_image" :src="product.featured_image.path" class="w-full h-full object-cover" />
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ product.name }}</div>
                                        <div class="text-xs text-slate-500">{{ product.slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 bg-slate-100 dark:bg-slate-800 rounded-full text-xs font-medium">
                                    {{ product.category.name }}
                                </span>
                            </td>
                            <td class="px-8 py-5 font-bold">
                                {{ Number(product.base_price).toLocaleString() }} XAF
                            </td>
                            <td class="px-8 py-5">
                                <span class="font-medium" :class="product.variants.reduce((acc, v) => acc + v.stock, 0) < 10 ? 'text-red-500' : ''">
                                    {{ product.variants.reduce((acc, v) => acc + v.stock, 0) }} unités
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <span 
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest"
                                    :class="product.is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'"
                                >
                                    <span class="w-1.5 h-1.5 rounded-full" :class="product.is_active ? 'bg-green-500' : 'bg-red-500'"></span>
                                    {{ product.is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-2">
                                    <Link 
                                        :href="admin_products_edit(product.id).url"
                                        class="p-2 bg-slate-100 dark:bg-slate-800 rounded-xl hover:bg-blue-600 hover:text-white transition-all"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </Link>
                                    <button 
                                        @click="deleteProduct(product.id)"
                                        class="p-2 bg-slate-100 dark:bg-slate-800 rounded-xl hover:bg-red-600 hover:text-white transition-all"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div v-if="products.length === 0" class="p-24 text-center space-y-4">
                <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto text-slate-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold">Aucun produit</h3>
                <p class="text-slate-500">Commencez par ajouter votre premier produit au catalogue.</p>
            </div>
        </div>
    </div>
</template>

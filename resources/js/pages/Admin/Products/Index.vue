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

    <div class="admin-container">
        <!-- Header responsive -->
        <div class="admin-header">
            <div class="admin-header-content">
                <h1 class="admin-title">Produits</h1>
                <p class="admin-subtitle">Gérez le catalogue de votre boutique.</p>
            </div>
            <Link 
                :href="admin_products_create().url"
                class="btn-primary"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter un Produit
            </Link>
        </div>

        <!-- Table responsive avec scroll horizontal sur mobile -->
        <div class="admin-table-container">
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr class="admin-table-header">
                            <th class="admin-table-cell">Produit</th>
                            <th class="admin-table-cell">Catégorie</th>
                            <th class="admin-table-cell">Prix</th>
                            <th class="admin-table-cell">Stock</th>
                            <th class="admin-table-cell">Statut</th>
                            <th class="admin-table-cell">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products" :key="product.id" class="admin-table-row">
                            <td class="admin-table-cell">
                                <div class="admin-product-info">
                                    <div class="admin-product-image">
                                        <img v-if="product.featured_image" :src="product.featured_image.path" />
                                    </div>
                                    <div>
                                        <div class="admin-product-name">{{ product.name }}</div>
                                        <div class="admin-product-slug">{{ product.slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="admin-table-cell">
                                <span class="admin-badge">
                                    {{ product.category.name }}
                                </span>
                            </td>
                            <td class="admin-table-cell admin-price">
                                {{ Number(product.base_price).toLocaleString() }} XAF
                            </td>
                            <td class="admin-table-cell">
                                <span class="admin-stock" :class="{ 'admin-stock-low': product.variants.reduce((acc, v) => acc + v.stock, 0) < 10 }">
                                    {{ product.variants.reduce((acc, v) => acc + v.stock, 0) }} unités
                                </span>
                            </td>
                            <td class="admin-table-cell">
                                <span class="admin-status" :class="product.is_active ? 'admin-status-active' : 'admin-status-inactive'">
                                    <span class="admin-status-dot" :class="product.is_active ? 'admin-status-dot-active' : 'admin-status-dot-inactive'"></span>
                                    {{ product.is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td class="admin-table-cell">
                                <div class="admin-actions">
                                    <Link 
                                        :href="admin_products_edit(product.id).url"
                                        class="admin-action-btn admin-action-edit"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </Link>
                                    <button 
                                        @click="deleteProduct(product.id)"
                                        class="admin-action-btn admin-action-delete"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Empty State responsive -->
            <div v-if="products.length === 0" class="admin-empty-state">
                <div class="admin-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <h3 class="admin-empty-title">Aucun produit</h3>
                <p class="admin-empty-text">Commencez par ajouter votre premier produit au catalogue.</p>
            </div>
        </div>
    </div>
</template>
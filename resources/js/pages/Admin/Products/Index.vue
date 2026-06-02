<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { create as admin_products_create, edit as admin_products_edit, destroy as admin_products_destroy } from '@/routes/admin/products';
import { Plus, Package, Search, Edit, Trash2, AlertCircle, CheckCircle, XCircle, Layers, Eye, TrendingUp } from 'lucide-vue-next';
import { ref, computed } from 'vue';

const props = defineProps<{
    products: any[];
}>();

const search = ref('');

const filteredProducts = computed(() => {
    if (!search.value) return props.products;
    const q = search.value.toLowerCase();
    return props.products.filter(p =>
        p.name.toLowerCase().includes(q) ||
        p.slug.toLowerCase().includes(q) ||
        p.category?.name.toLowerCase().includes(q)
    );
});

const deleteProduct = (id: number) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
        router.delete(admin_products_destroy(id).url);
    }
};

const getTotalStock = (product: any) => {
    return product.variants?.reduce((acc: number, v: any) => acc + (v.stock || 0), 0) || 0;
};
</script>

<template>
    <Head title="Gestion des Produits - Admin" />

    <div class="py-6 md:py-8 px-4 max-w-7xl ">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2.5 bg-primary/10 text-primary rounded-xl">
                        <Package class="w-6 h-6" />
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-black tracking-tight text-foreground">Produits</h1>
                        <p class="text-sm text-muted-foreground mt-1">
                            Gérez le catalogue de votre boutique
                        </p>
                    </div>
                </div>
            </div>
            <Link
                :href="admin_products_create().url"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary to-primary-dark text-white font-bold rounded-xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-primary/30"
            >
                <Plus class="w-5 h-5" />
                <span>Ajouter un produit</span>
            </Link>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-8">
            <div class="bg-card border border-border rounded-xl p-4">
                <div class="flex items-center justify-between">
                    <div class="p-2 bg-primary/10 rounded-lg">
                        <Package class="w-4 h-4 text-primary" />
                    </div>
                    <span class="text-2xl font-black text-primary">{{ products.length }}</span>
                </div>
                <div class="text-xs font-bold text-muted-foreground uppercase tracking-wider mt-2">Total produits</div>
            </div>
            <div class="bg-card border border-border rounded-xl p-4">
                <div class="flex items-center justify-between">
                    <div class="p-2 bg-green-100 dark:bg-green-950/30 rounded-lg">
                        <CheckCircle class="w-4 h-4 text-green-600 dark:text-green-400" />
                    </div>
                    <span class="text-2xl font-black text-green-600 dark:text-green-400">
                        {{ products.filter(p => p.is_active).length }}
                    </span>
                </div>
                <div class="text-xs font-bold text-muted-foreground uppercase tracking-wider mt-2">Actifs</div>
            </div>
            <div class="bg-card border border-border rounded-xl p-4">
                <div class="flex items-center justify-between">
                    <div class="p-2 bg-red-100 dark:bg-red-950/30 rounded-lg">
                        <XCircle class="w-4 h-4 text-red-600 dark:text-red-400" />
                    </div>
                    <span class="text-2xl font-black text-red-600 dark:text-red-400">
                        {{ products.filter(p => !p.is_active).length }}
                    </span>
                </div>
                <div class="text-xs font-bold text-muted-foreground uppercase tracking-wider mt-2">Inactifs</div>
            </div>
            <div class="bg-card border border-border rounded-xl p-4">
                <div class="flex items-center justify-between">
                    <div class="p-2 bg-primary/10 rounded-lg">
                        <TrendingUp class="w-4 h-4 text-primary" />
                    </div>
                    <span class="text-2xl font-black text-primary">
                        {{ products.reduce((sum, p) => sum + getTotalStock(p), 0) }}
                    </span>
                </div>
                <div class="text-xs font-bold text-muted-foreground uppercase tracking-wider mt-2">Stock total</div>
            </div>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <div class="relative">
                <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" />
                <input
                    v-model="search"
                    type="text"
                    placeholder="Rechercher un produit..."
                    class="w-full pl-11 pr-4 py-3 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all text-foreground placeholder:text-muted-foreground/50"
                />
            </div>
        </div>

        <!-- Table responsive -->
        <div class="bg-card border border-border rounded-2xl overflow-hidden">
            <!-- Version desktop -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-border bg-secondary/30">
                            <th class="px-6 py-4 text-left text-xs font-bold text-muted-foreground uppercase tracking-wider">Produit</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-muted-foreground uppercase tracking-wider">Catégorie</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-muted-foreground uppercase tracking-wider">Prix</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-muted-foreground uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-muted-foreground uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-muted-foreground uppercase tracking-wider">Actions</th>
                        </tr> 
                    </thead>
                    <tbody class="divide-y divide-border">
                        <tr v-for="product in filteredProducts" :key="product.id" class="hover:bg-secondary/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg overflow-hidden bg-secondary border border-border shrink-0">
                                        <img 
                                            v-if="product.featured_image?.url" 
                                            :src="product.featured_image.url" 
                                            class="w-full h-full object-cover"
                                            :alt="product.name"
                                        />
                                        <div v-else class="w-full h-full flex items-center justify-center text-muted-foreground">
                                            <Package class="w-4 h-4" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-foreground line-clamp-1">{{ product.name }}</div>
                                        <div class="text-xs text-muted-foreground">{{ product.slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs font-medium bg-primary/10 text-primary">
                                    <Layers class="w-3 h-3" />
                                    {{ product.category?.name || '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-sm font-bold text-foreground">
                                    {{ Number(product.base_price).toLocaleString() }} FCFA
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span 
                                    class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs font-medium"
                                    :class="getTotalStock(product) > 10 
                                        ? 'bg-green-100 text-green-700 dark:bg-green-950/30 dark:text-green-400' 
                                        : getTotalStock(product) > 0 
                                        ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-950/30 dark:text-yellow-400'
                                        : 'bg-red-100 text-red-700 dark:bg-red-950/30 dark:text-red-400'"
                                >
                                    <AlertCircle class="w-3 h-3" />
                                    {{ getTotalStock(product) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span 
                                    class="inline-flex items-center gap-1.5 px-2 py-1 rounded-lg text-xs font-medium"
                                    :class="product.is_active 
                                        ? 'bg-green-100 text-green-700 dark:bg-green-950/30 dark:text-green-400' 
                                        : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400'"
                                >
                                    <span class="w-1.5 h-1.5 rounded-full" :class="product.is_active ? 'bg-green-500' : 'bg-gray-400'"></span>
                                    {{ product.is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <Link
                                        :href="admin_products_edit(product.id).url"
                                        class="p-2 text-muted-foreground hover:text-primary hover:bg-primary/10 rounded-lg transition-all"
                                        title="Modifier"
                                    >
                                        <Edit class="w-4 h-4" />
                                    </Link>
                                    <button
                                        @click="deleteProduct(product.id)"
                                        class="p-2 text-muted-foreground hover:text-red-500 hover:bg-red-500/10 rounded-lg transition-all"
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

            <!-- Version mobile (cartes) -->
            <div class="md:hidden divide-y divide-border">
                <div v-for="product in filteredProducts" :key="product.id" class="p-4 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-secondary border border-border shrink-0">
                            <img 
                                v-if="product.featured_image?.url" 
                                :src="product.featured_image.url" 
                                class="w-full h-full object-cover"
                                :alt="product.name"
                            />
                            <div v-else class="w-full h-full flex items-center justify-center text-muted-foreground">
                                <Package class="w-5 h-5" />
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-bold text-foreground">{{ product.name }}</div>
                            <div class="text-xs text-muted-foreground">{{ product.slug }}</div>
                        </div>
                        <div class="flex gap-2">
                            <Link
                                :href="admin_products_edit(product.id).url"
                                class="p-2 text-muted-foreground hover:text-primary hover:bg-primary/10 rounded-lg transition-all"
                            >
                                <Edit class="w-4 h-4" />
                            </Link>
                            <button
                                @click="deleteProduct(product.id)"
                                class="p-2 text-muted-foreground hover:text-red-500 hover:bg-red-500/10 rounded-lg transition-all"
                            >
                                <Trash2 class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <div class="text-xs text-muted-foreground">Catégorie</div>
                            <div class="text-sm font-medium">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-xs bg-primary/10 text-primary">
                                    {{ product.category?.name || '-' }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-muted-foreground">Prix</div>
                            <div class="text-sm font-bold text-foreground">{{ Number(product.base_price).toLocaleString() }} FCFA</div>
                        </div>
                        <div>
                            <div class="text-xs text-muted-foreground">Stock</div>
                            <div class="text-sm font-medium">{{ getTotalStock(product) }} unités</div>
                        </div>
                        <div>
                            <div class="text-xs text-muted-foreground">Statut</div>
                            <span 
                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-xs font-medium"
                                :class="product.is_active 
                                    ? 'bg-green-100 text-green-700 dark:bg-green-950/30 dark:text-green-400' 
                                    : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400'"
                            >
                                <span class="w-1.5 h-1.5 rounded-full" :class="product.is_active ? 'bg-green-500' : 'bg-gray-400'"></span>
                                {{ product.is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-if="filteredProducts.length === 0" class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                    <Package class="w-10 h-10 text-primary" />
                </div>
                <h3 class="text-lg font-bold text-foreground mb-2">Aucun produit trouvé</h3>
                <p class="text-sm text-muted-foreground max-w-sm mb-6">
                    {{ search ? 'Aucun produit ne correspond à votre recherche.' : 'Commencez par ajouter votre premier produit au catalogue.' }}
                </p>
                <Link
                    v-if="!search"
                    :href="admin_products_create().url"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary to-primary-dark text-white font-bold rounded-xl transition-all hover:-translate-y-0.5"
                >
                    <Plus class="w-5 h-5" />
                    Ajouter un produit
                </Link>
            </div>
        </div>
    </div>
</template>
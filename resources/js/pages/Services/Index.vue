<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Search, ChevronDown, FilterX, Wrench, Zap } from 'lucide-vue-next';
import { ref, computed } from 'vue';
import ShopLayout from '@/layouts/ShopLayout.vue';

defineOptions({
    layout: ShopLayout,
});

interface Service {
    id: number;
    name: string;
    slug: string;
    description: string;
    details: string;
    type: 'plomberie' | 'electricite';
    base_price: number;
    image_url: string;
    is_active: boolean;
}

interface Props {
    plumerieServices: Service[];
    electriciteServices: Service[];
}

const props = defineProps<Props>();

const formatPrice = (price: number): string => {
    return new Intl.NumberFormat('fr-FR').format(price);
};

// Filtres
const search = ref('');
const sort = ref('latest');
const activeType = ref<'all' | 'plomberie' | 'electricite'>('all');

// Services filtrés
const filteredServices = computed(() => {
    let services = [...props.plumerieServices, ...props.electriciteServices];
    
    if (activeType.value !== 'all') {
        services = services.filter(s => s.type === activeType.value);
    }
    
    if (search.value) {
        services = services.filter(s => 
            s.name.toLowerCase().includes(search.value.toLowerCase()) ||
            s.description.toLowerCase().includes(search.value.toLowerCase())
        );
    }
    
    if (sort.value === 'price_asc') {
        services.sort((a, b) => a.base_price - b.base_price);
    } else if (sort.value === 'price_desc') {
        services.sort((a, b) => b.base_price - a.base_price);
    } else if (sort.value === 'name_asc') {
        services.sort((a, b) => a.name.localeCompare(b.name));
    }
    
    return services;
});

const clearFilters = () => {
    search.value = '';
    activeType.value = 'all';
    sort.value = 'latest';
};
</script>

<template>
    <ShopLayout>
        <Head title="Nos Services - ShopTech" />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8 pt-24 md:pt-28">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-black tracking-tight text-foreground">
                    Nos <span class="text-primary">Services</span>
                </h1>
                <p class="text-muted-foreground text-sm mt-2">
                    Plomberie et Électricité - Intervention rapide et qualité garantie
                </p>
            </div>

            <!-- Search & Filters -->
            <div class="bg-card border border-border rounded-2xl p-4 mb-8">
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Search -->
                    <div class="flex-1 relative">
                        <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" />
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Rechercher un service..."
                            class="w-full pl-11 pr-4 py-2.5 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-foreground placeholder:text-muted-foreground/50"
                        />
                    </div>

                    <!-- Sort -->
                    <div class="relative w-full md:w-48">
                        <select
                            v-model="sort"
                            class="w-full appearance-none px-4 py-2.5 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary text-foreground cursor-pointer"
                        >
                            <option value="latest">Les plus récents</option>
                            <option value="price_asc">Prix croissant</option>
                            <option value="price_desc">Prix décroissant</option>
                            <option value="name_asc">Nom A-Z</option>
                        </select>
                        <ChevronDown class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground pointer-events-none" />
                    </div>

                    <!-- Clear filters -->
                    <button v-if="search || activeType !== 'all'" @click="clearFilters" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-500/10 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all">
                        <FilterX class="w-4 h-4" />
                        <span class="text-sm font-medium">Effacer</span>
                    </button>
                </div>

                <!-- Type filter -->
                <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-border">
                    <button
                        @click="activeType = 'all'"
                        class="px-3 py-1.5 text-xs font-semibold rounded-full transition-all"
                        :class="activeType === 'all' 
                            ? 'bg-primary text-white' 
                            : 'bg-secondary text-muted-foreground hover:bg-primary/10 hover:text-primary'"
                    >
                        Tous
                    </button>
                    <button
                        @click="activeType = 'plomberie'"
                        class="px-3 py-1.5 text-xs font-semibold rounded-full transition-all"
                        :class="activeType === 'plomberie' 
                            ? 'bg-primary text-white' 
                            : 'bg-secondary text-muted-foreground hover:bg-primary/10 hover:text-primary'"
                    >
                        <div class="flex items-center gap-1.5">
                            <Wrench class="w-3 h-3" />
                            Plomberie
                        </div>
                    </button>
                    <button
                        @click="activeType = 'electricite'"
                        class="px-3 py-1.5 text-xs font-semibold rounded-full transition-all"
                        :class="activeType === 'electricite' 
                            ? 'bg-primary text-white' 
                            : 'bg-secondary text-muted-foreground hover:bg-primary/10 hover:text-primary'"
                    >
                        <div class="flex items-center gap-1.5">
                            <Zap class="w-3 h-3" />
                            Électricité
                        </div>
                    </button>
                </div>
            </div>

            <!-- Results count -->
            <div class="flex items-center justify-between mb-6">
                <span class="text-sm text-muted-foreground">{{ filteredServices.length }} service(s) trouvé(s)</span>
                <div class="w-px h-4 bg-border"></div>
                <span class="text-sm text-muted-foreground">Prestations de qualité</span>
            </div>

            <!-- Services Grid -->
            <div v-if="filteredServices.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="service in filteredServices" :key="service.id" class="group bg-card border border-border rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <!-- Image -->
                    <div class="relative aspect-[4/3] overflow-hidden bg-secondary">
                        <img 
                            :src="service.image_url" 
                            :alt="service.name"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        />
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-1 bg-white/90 backdrop-blur-sm rounded-lg text-xs font-bold" :class="service.type === 'plomberie' ? 'text-primary' : 'text-yellow-600'">
                                {{ service.type === 'plomberie' ? 'Plomberie' : 'Électricité' }}
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-foreground mb-2 line-clamp-1 group-hover:text-primary transition-colors">
                            {{ service.name }}
                        </h3>
                        <p class="text-sm text-muted-foreground mb-3 line-clamp-2">
                            {{ service.description }}
                        </p>
                        <p class="text-xs text-muted-foreground/70 mb-4 line-clamp-2">
                            {{ service.details }}
                        </p>
                        
                        <div class="flex items-center justify-between pt-3 border-t border-border">
                            <div>
                                <span class="text-xl font-black text-primary">{{ formatPrice(service.base_price) }}</span>
                                <span class="text-xs text-muted-foreground ml-0.5">FCFA</span>
                            </div>
                            <Link 
                                :href="'/services/' + service.slug"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl text-sm font-semibold hover:bg-primary-dark transition-all hover:-translate-y-0.5"
                            >
                                Détails
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="flex flex-col items-center justify-center py-16 text-center bg-card border border-border rounded-2xl">
                <div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                    <Search class="w-10 h-10 text-primary" />
                </div>
                <h3 class="text-lg font-bold text-foreground mb-2">Aucun service trouvé</h3>
                <p class="text-sm text-muted-foreground max-w-md mb-6">
                    Aucun service ne correspond à votre recherche. Essayez d'autres mots-clés ou parcourez notre catalogue.
                </p>
                <button @click="clearFilters" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary to-primary-dark text-white font-bold rounded-xl transition-all hover:-translate-y-0.5">
                    Voir tous les services
                </button>
            </div>
        </div>
    </ShopLayout>
</template>
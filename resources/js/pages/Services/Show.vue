<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ChevronRight, Wrench, Zap, Phone, ShieldCheck, Clock, Award, Calendar, X } from 'lucide-vue-next';
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
    service: Service;
    relatedServices: Service[];
}

const props = defineProps<Props>();

const formatPrice = (price: number): string => {
    return new Intl.NumberFormat('fr-FR').format(price);
};

// Formulaire de contact rapide
const form = useForm({
    name: '',
    email: '',
    phone: '',
    message: `Je souhaite un devis pour le service : ${props.service.name}`,
});

const showQuoteForm = ref(false);

const requestQuote = () => {
    form.post('/contact', {
        preserveScroll: true,
        onSuccess: () => {
            showQuoteForm.value = false;
            form.reset();
        }
    });
};
</script>

<template>
    <ShopLayout>
        <Head :title="`${service.name} - ShopTech`" />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8 pt-24 md:pt-28">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 flex-wrap mb-6 text-xs font-semibold uppercase tracking-wider">
                <Link href="/" class="text-muted-foreground hover:text-primary transition-colors">Accueil</Link>
                <ChevronRight class="w-3 h-3 text-border" />
                <Link href="/services" class="text-muted-foreground hover:text-primary transition-colors">Services</Link>
                <ChevronRight class="w-3 h-3 text-border" />
                <span class="text-primary">{{ service.name }}</span>
            </nav>

            <!-- Service Main Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <!-- Gallery -->
                <div class="space-y-4">
                    <div class="relative aspect-square bg-secondary rounded-2xl overflow-hidden">
                        <img
                            :src="service.image_url"
                            :alt="service.name"
                            class="w-full h-full object-cover"
                        />
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1.5 bg-white/90 backdrop-blur-sm rounded-lg text-sm font-bold" :class="service.type === 'plomberie' ? 'text-primary' : 'text-yellow-600'">
                                {{ service.type === 'plomberie' ? 'Plomberie' : 'Électricité' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Service Info -->
                <div class="space-y-5">
                    <!-- Title -->
                    <h1 class="text-2xl md:text-3xl font-bold text-foreground">{{ service.name }}</h1>

                    <!-- Price -->
                    <div class="flex items-baseline gap-3">
                        <span class="text-3xl font-black text-primary">
                            {{ formatPrice(service.base_price) }} <span class="text-base font-normal">FCFA</span>
                        </span>
                        <span class="text-sm text-muted-foreground">*Tarif de base</span>
                    </div>

                    <!-- Description -->
                    <div class="pt-3">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-muted-foreground mb-2">Description</h3>
                        <p class="text-sm text-muted-foreground leading-relaxed">{{ service.description }}</p>
                    </div>

                    <!-- Details -->
                    <div class="pt-2">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-muted-foreground mb-2">Ce qui est inclus</h3>
                        <p class="text-sm text-muted-foreground leading-relaxed">{{ service.details }}</p>
                    </div>

                    <!-- Actions -->
                    <div class="space-y-4 pt-4">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button
                                @click="showQuoteForm = true"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-primary to-primary-dark text-white rounded-xl font-semibold transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-primary/30"
                            >
                                Demander un devis gratuit
                            </button>

                            <a
                                href="tel:+237XXXXXXXXX"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-secondary border border-border rounded-xl font-semibold text-foreground hover:bg-primary hover:text-white hover:border-primary transition-all"
                            >
                                <Phone class="w-5 h-5" />
                                Appeler maintenant
                            </a>
                        </div>

                        <!-- Features -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-3">
                            <div class="flex flex-col items-center gap-2 p-3 bg-secondary rounded-xl">
                                <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center">
                                    <Clock class="w-4 h-4 text-primary" />
                                </div>
                                <span class="text-[10px] font-semibold uppercase text-center text-muted-foreground">Intervention<br>rapide</span>
                            </div>
                            <div class="flex flex-col items-center gap-2 p-3 bg-secondary rounded-xl">
                                <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center">
                                    <ShieldCheck class="w-4 h-4 text-primary" />
                                </div>
                                <span class="text-[10px] font-semibold uppercase text-center text-muted-foreground">Garantie<br>2 ans</span>
                            </div>
                            <div class="flex flex-col items-center gap-2 p-3 bg-secondary rounded-xl">
                                <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center">
                                    <Award class="w-4 h-4 text-primary" />
                                </div>
                                <span class="text-[10px] font-semibold uppercase text-center text-muted-foreground">Techniciens<br>certifiés</span>
                            </div>
                            <div class="flex flex-col items-center gap-2 p-3 bg-secondary rounded-xl">
                                <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center">
                                    <Calendar class="w-4 h-4 text-primary" />
                                </div>
                                <span class="text-[10px] font-semibold uppercase text-center text-muted-foreground">RDV<br>flexible</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quote Form Modal -->
            <div v-if="showQuoteForm" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" @click.self="showQuoteForm = false">
                <div class="max-w-md w-full bg-card border border-border rounded-2xl p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-foreground">Demande de devis</h3>
                        <button @click="showQuoteForm = false" class="p-1 rounded-lg hover:bg-secondary transition-colors">
                            <X class="w-5 h-5 text-muted-foreground" />
                        </button>
                    </div>
                    <p class="text-sm text-muted-foreground mb-4">Pour le service : <span class="font-semibold text-primary">{{ service.name }}</span></p>

                    <form @submit.prevent="requestQuote" class="space-y-4">
                        <div>
                            <label class="text-xs font-bold uppercase tracking-wider text-muted-foreground mb-1 block">Nom complet</label>
                            <input
                                v-model="form.name"
                                type="text"
                                required
                                class="w-full px-4 py-2.5 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary"
                            />
                        </div>
                        <div>
                            <label class="text-xs font-bold uppercase tracking-wider text-muted-foreground mb-1 block">Email</label>
                            <input
                                v-model="form.email"
                                type="email"
                                required
                                class="w-full px-4 py-2.5 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary"
                            />
                        </div>
                        <div>
                            <label class="text-xs font-bold uppercase tracking-wider text-muted-foreground mb-1 block">Téléphone</label>
                            <input
                                v-model="form.phone"
                                type="tel"
                                required
                                class="w-full px-4 py-2.5 bg-secondary border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary"
                            />
                        </div>
                        <div class="flex gap-3 pt-2">
                            <button type="button" @click="showQuoteForm = false" class="flex-1 px-4 py-2.5 bg-secondary border border-border rounded-xl font-semibold">
                                Annuler
                            </button>
                            <button type="submit" :disabled="form.processing" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-primary to-primary-dark text-white rounded-xl font-semibold transition-all hover:-translate-y-0.5 disabled:opacity-50">
                                Envoyer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Related Services -->
            <div v-if="relatedServices.length > 0" class="pt-8 border-t border-border">
                <h2 class="text-xl font-bold text-foreground mb-6">Services similaires</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="relService in relatedServices" :key="relService.id" class="group bg-card border border-border rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="relative aspect-[4/3] overflow-hidden bg-secondary">
                            <img
                                :src="relService.image_url"
                                :alt="relService.name"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            />
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-foreground mb-2 line-clamp-1 group-hover:text-primary transition-colors">
                                {{ relService.name }}
                            </h3>
                            <div class="flex items-center justify-between pt-3">
                                <div>
                                    <span class="text-xl font-black text-primary">{{ formatPrice(relService.base_price) }}</span>
                                    <span class="text-xs text-muted-foreground ml-0.5">FCFA</span>
                                </div>
                                <Link
                                    :href="'/services/' + relService.slug"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl text-sm font-semibold hover:bg-primary-dark transition-all hover:-translate-y-0.5"
                                >
                                    Détail
                                    <ChevronRight class="w-3.5 h-3.5" />
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ShopLayout>
</template>

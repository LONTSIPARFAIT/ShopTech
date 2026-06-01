<template>
  <div class="min-h-screen bg-gradient-to-b from-slate-50 to-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-12">
      <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold mb-2">Nos Services Professionnels</h1>
        <p class="text-lg text-blue-100">Plomberie et Électricité - Intervention rapide et qualité garantie</p>
      </div>
    </div>

    <!-- Services Sections -->
    <div class="container mx-auto px-4 py-12">
      <!-- Plomberie Section -->
      <div class="mb-16">
        <div class="flex items-center mb-8">
          <div class="bg-blue-100 p-4 rounded-lg mr-4">
            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 11.894 1.788l-1.314.657 1.314.657a1 1 0 11-.894 1.788l-1.599-.8-3.954 1.582V9a1 1 0 11-2 0V7.677L6.046 6.095l-1.599.8a1 1 0 1-.894-1.788l1.314-.657-1.314-.657a1 1 0 11.894-1.788l1.599.8L9 4.323V3a1 1 0 011-1h0z"></path>
            </svg>
          </div>
          <h2 class="text-3xl font-bold text-slate-800">Services de Plomberie</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="service in plumerieServices"
            :key="service.id"
            class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden"
          >
            <img
              :src="service.image_url"
              :alt="service.name"
              class="w-full h-48 object-cover"
            />
            <div class="p-6">
              <h3 class="text-xl font-semibold text-slate-800 mb-2">{{ service.name }}</h3>
              <p class="text-slate-600 text-sm mb-4">{{ service.description }}</p>
              <p class="text-slate-500 text-xs mb-4 line-clamp-2">{{ service.details }}</p>
              <div class="flex items-center justify-between">
                <span class="text-2xl font-bold text-blue-600">{{ formatPrice(service.base_price) }} XAF</span>
                <Link
                  :href="route('services.show', service.slug)"
                  class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors"
                >
                  Détails
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Électricité Section -->
      <div>
        <div class="flex items-center mb-8">
          <div class="bg-yellow-100 p-4 rounded-lg mr-4">
            <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
              <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
              <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path>
            </svg>
          </div>
          <h2 class="text-3xl font-bold text-slate-800">Services d'Électricité</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="service in electriciteServices"
            :key="service.id"
            class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden"
          >
            <img
              :src="service.image_url"
              :alt="service.name"
              class="w-full h-48 object-cover"
            />
            <div class="p-6">
              <h3 class="text-xl font-semibold text-slate-800 mb-2">{{ service.name }}</h3>
              <p class="text-slate-600 text-sm mb-4">{{ service.description }}</p>
              <p class="text-slate-500 text-xs mb-4 line-clamp-2">{{ service.details }}</p>
              <div class="flex items-center justify-between">
                <span class="text-2xl font-bold text-yellow-600">{{ formatPrice(service.base_price) }} XAF</span>
                <Link
                  :href="route('services.show', service.slug)"
                  class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors"
                >
                  Détails
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-12 mt-16">
      <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Besoin d'un service?</h2>
        <p class="text-lg text-blue-100 mb-8">Contactez-nous pour une intervention rapide et un devis gratuit</p>
        <Link
          href="/contact"
          class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors"
        >
          Nous Contacter
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

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

defineProps<Props>();

const formatPrice = (price: number): string => {
  return new Intl.NumberFormat('fr-FR').format(price);
};
</script>

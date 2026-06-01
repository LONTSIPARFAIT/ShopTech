<template>
  <div class="min-h-screen bg-gradient-to-b from-slate-50 to-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-8">
      <div class="container mx-auto px-4">
        <Link href="/services" class="text-blue-100 hover:text-white mb-4 inline-flex items-center">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
          </svg>
          Retour aux services
        </Link>
        <h1 class="text-4xl font-bold">{{ service.name }}</h1>
      </div>
    </div>

    <!-- Service Detail -->
    <div class="container mx-auto px-4 py-12">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Image & Info -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            <img
              :src="service.image_url"
              :alt="service.name"
              class="w-full h-96 object-cover"
            />
          </div>

          <!-- Description -->
          <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <h2 class="text-2xl font-bold text-slate-800 mb-4">À propos de ce service</h2>
            <p class="text-slate-600 text-lg mb-6">{{ service.description }}</p>
            
            <h3 class="text-xl font-semibold text-slate-800 mb-4">Ce qui est inclus</h3>
            <p class="text-slate-600 leading-relaxed">{{ service.details }}</p>
          </div>

          <!-- Service Type Badge -->
          <div class="bg-white rounded-lg shadow-md p-8">
            <div class="flex items-center">
              <div
                :class="{
                  'bg-blue-100': service.type === 'plomberie',
                  'bg-yellow-100': service.type === 'electricite',
                }"
                class="p-4 rounded-lg mr-4"
              >
                <svg
                  v-if="service.type === 'plomberie'"
                  class="w-8 h-8 text-blue-600"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                >
                  <path d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 11.894 1.788l-1.314.657 1.314.657a1 1 0 11-.894 1.788l-1.599-.8-3.954 1.582V9a1 1 0 11-2 0V7.677L6.046 6.095l-1.599.8a1 1 0 1-.894-1.788l1.314-.657-1.314-.657a1 1 0 11.894-1.788l1.599.8L9 4.323V3a1 1 0 011-1h0z"></path>
                </svg>
                <svg
                  v-else
                  class="w-8 h-8 text-yellow-600"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                >
                  <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                </svg>
              </div>
              <div>
                <p class="text-sm text-slate-500 uppercase tracking-wider">Type de service</p>
                <p class="text-2xl font-bold text-slate-800 capitalize">{{ service.type }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Sidebar: Price & CTA -->
        <div>
          <!-- Price Card -->
          <div class="bg-white rounded-lg shadow-lg p-8 mb-8 sticky top-8">
            <p class="text-sm text-slate-500 uppercase tracking-wider mb-2">Tarif de base</p>
            <div class="text-4xl font-bold text-blue-600 mb-6">
              {{ formatPrice(service.base_price) }}
              <span class="text-lg text-slate-600">XAF</span>
            </div>
            <p class="text-sm text-slate-600 mb-6">*Prix indicatif, devis gratuit sur demande</p>

            <Link
              href="/contact"
              class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors mb-4 inline-block text-center"
            >
              Demander une Intervention
            </Link>

            <a
              href="tel:+237XXXXXXXXX"
              class="w-full bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold py-3 px-6 rounded-lg transition-colors inline-block text-center"
            >
              Nous Appeler
            </a>

            <!-- Info Box -->
            <div class="bg-blue-50 p-4 rounded-lg mt-8">
              <h4 class="font-semibold text-slate-800 mb-3">Avantages</h4>
              <ul class="space-y-2 text-sm text-slate-600">
                <li class="flex items-start">
                  <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span>Techniciens qualifiés</span>
                </li>
                <li class="flex items-start">
                  <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span>Intervention rapide</span>
                </li>
                <li class="flex items-start">
                  <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span>Garantie 2 ans</span>
                </li>
                <li class="flex items-start">
                  <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span>Devis gratuit</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Related Services -->
      <div v-if="relatedServices.length > 0" class="mt-16">
        <h2 class="text-3xl font-bold text-slate-800 mb-8">Services Similaires</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <Link
            v-for="relService in relatedServices"
            :key="relService.id"
            :href="route('services.show', relService.slug)"
            class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden"
          >
            <img
              :src="relService.image_url"
              :alt="relService.name"
              class="w-full h-40 object-cover"
            />
            <div class="p-4">
              <h3 class="text-lg font-semibold text-slate-800 mb-2">{{ relService.name }}</h3>
              <p class="text-blue-600 font-bold">{{ formatPrice(relService.base_price) }} XAF</p>
            </div>
          </Link>
        </div>
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
  service: Service;
  relatedServices: Service[];
}

defineProps<Props>();

const formatPrice = (price: number): string => {
  return new Intl.NumberFormat('fr-FR').format(price);
};
</script>

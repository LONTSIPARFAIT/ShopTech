<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import ShopLayout from '@/layouts/ShopLayout.vue';
import { MapPin, Phone, Mail, Clock, Send, MessageCircle } from 'lucide-vue-next';

defineOptions({ layout: ShopLayout });

const WHATSAPP_NUMBER = '237679324517';
const WHATSAPP_MSG = encodeURIComponent("Bonjour ShopTech, j'ai une question.");

const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
});

const submit = () => {
    form.post('/contact/send', {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Contact – ShopTech" />

    <div class="pt-20">
        <!-- Hero -->
        <section class="relative py-20 md:py-28 overflow-hidden bg-gradient-to-br from-orange-50 to-white dark:from-slate-900 dark:to-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <span class="inline-block px-3 py-1 rounded-full bg-orange-100 dark:bg-orange-950/30 text-orange-600 dark:text-orange-400 text-xs font-bold uppercase tracking-wider mb-4">
                    Nous sommes là pour vous
                </span>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-foreground mb-4">
                    Contactez-<span class="text-orange-500">nous</span>
                </h1>
                <p class="text-muted-foreground text-base md:text-lg max-w-2xl mx-auto">
                    Une question ? Un problème ? Notre équipe est disponible du lundi au samedi.
                </p>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="py-16 md:py-20 bg-card">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-8">
                    <!-- Info Cards -->
                    <div class="space-y-4">
                        <div class="flex gap-4 p-4 bg-secondary rounded-xl">
                            <div class="w-10 h-10 rounded-lg bg-orange-100 dark:bg-orange-950/30 flex items-center justify-center flex-shrink-0">
                                <MapPin class="w-5 h-5 text-orange-500" />
                            </div>
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-muted-foreground">Adresse</h3>
                                <p class="text-foreground font-medium">Rue de la Cathédrale<br/>Yaoundé, Cameroun</p>
                            </div>
                        </div>

                        <div class="flex gap-4 p-4 bg-secondary rounded-xl">
                            <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-950/30 flex items-center justify-center flex-shrink-0">
                                <Phone class="w-5 h-5 text-green-500" />
                            </div>
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-muted-foreground">Téléphone</h3>
                                <a href="tel:+237600000000" class="text-foreground font-medium hover:text-orange-500 transition-colors">+237 6 00 00 00 00</a>
                            </div>
                        </div>

                        <div class="flex gap-4 p-4 bg-secondary rounded-xl">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-950/30 flex items-center justify-center flex-shrink-0">
                                <Mail class="w-5 h-5 text-purple-500" />
                            </div>
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-muted-foreground">Email</h3>
                                <a href="mailto:contact@shoptech.cm" class="text-foreground font-medium hover:text-orange-500 transition-colors">contact@shoptech.cm</a>
                            </div>
                        </div>

                        <div class="flex gap-4 p-4 bg-secondary rounded-xl">
                            <div class="w-10 h-10 rounded-lg bg-amber-100 dark:bg-amber-950/30 flex items-center justify-center flex-shrink-0">
                                <Clock class="w-5 h-5 text-amber-500" />
                            </div>
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-muted-foreground">Horaires</h3>
                                <p class="text-foreground font-medium">Lun–Sam : 8h – 18h<br/>Dim : Fermé</p>
                            </div>
                        </div>

                        <!-- WhatsApp -->
                        <a :href="`https://wa.me/${WHATSAPP_NUMBER}?text=${WHATSAPP_MSG}`" target="_blank" class="flex items-center gap-4 p-4 bg-[#25d366] rounded-xl text-white hover:bg-[#20bd59] transition-all duration-300">
                            <MessageCircle class="w-6 h-6" />
                            <div>
                                <p class="font-bold">WhatsApp</p>
                                <p class="text-sm opacity-90">Réponse rapide garantie</p>
                            </div>
                        </a>
                    </div>

                    <!-- Contact Form -->
                    <div class="p-6 md:p-8 bg-secondary rounded-xl">
                        <h2 class="text-xl font-bold text-foreground mb-6">Envoyer un message</h2>

                        <form @submit.prevent="submit" class="space-y-4">
                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold uppercase text-muted-foreground mb-1">Nom complet</label>
                                    <input v-model="form.name" type="text" class="w-full px-4 py-2 bg-card border border-border rounded-lg text-foreground focus:outline-none focus:border-orange-500 transition-colors" placeholder="Jean Dupont" />
                                    <p v-if="form.errors.name" class="text-xs text-red-500 mt-1">{{ form.errors.name }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold uppercase text-muted-foreground mb-1">Email</label>
                                    <input v-model="form.email" type="email" class="w-full px-4 py-2 bg-card border border-border rounded-lg text-foreground focus:outline-none focus:border-orange-500 transition-colors" placeholder="votre@email.com" />
                                    <p v-if="form.errors.email" class="text-xs text-red-500 mt-1">{{ form.errors.email }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase text-muted-foreground mb-1">Sujet</label>
                                <input v-model="form.subject" type="text" class="w-full px-4 py-2 bg-card border border-border rounded-lg text-foreground focus:outline-none focus:border-orange-500 transition-colors" placeholder="Question sur ma commande" />
                                <p v-if="form.errors.subject" class="text-xs text-red-500 mt-1">{{ form.errors.subject }}</p>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase text-muted-foreground mb-1">Message</label>
                                <textarea v-model="form.message" rows="5" class="w-full px-4 py-2 bg-card border border-border rounded-lg text-foreground focus:outline-none focus:border-orange-500 transition-colors resize-none" placeholder="Décrivez votre demande..."></textarea>
                                <p v-if="form.errors.message" class="text-xs text-red-500 mt-1">{{ form.errors.message }}</p>
                            </div>

                            <button type="submit" :disabled="form.processing" class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-orange-500 text-white rounded-lg font-bold hover:bg-orange-600 transition-all duration-300 disabled:opacity-50">
                                <Send class="w-4 h-4" />
                                {{ form.processing ? 'Envoi en cours...' : 'Envoyer le message' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

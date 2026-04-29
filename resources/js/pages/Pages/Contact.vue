<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import ShopLayout from '@/layouts/ShopLayout.vue';
import { MapPin, Phone, Mail, Clock, Send, MessageCircle } from 'lucide-vue-next';
import { computed } from 'vue';

defineOptions({ layout: ShopLayout });

const WHATSAPP_NUMBER = '237600000000';
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

    <div class="contact-page">
        <!-- Hero -->
        <section class="contact-hero">
            <div class="contact-hero-bg"></div>
            <div class="contact-hero-container">
                <div class="contact-hero-content">
                    <span class="contact-hero-badge">Nous sommes là pour vous</span>
                    <h1 class="contact-hero-title">
                        Contactez-<span class="text-blue-600">nous</span>
                    </h1>
                    <p class="contact-hero-description">
                        Une question ? Un problème ? Notre équipe est disponible du lundi au samedi.
                    </p>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="contact-section">
            <div class="contact-container">
                <div class="contact-grid">
                    <!-- Info Cards -->
                    <div class="contact-info">
                        <div class="contact-card">
                            <div class="contact-card-icon icon-blue">
                                <MapPin class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="contact-card-title">Adresse</h3>
                                <p class="contact-card-text">Rue de la Cathédrale<br/>Yaoundé, Cameroun</p>
                            </div>
                        </div>

                        <div class="contact-card">
                            <div class="contact-card-icon icon-green">
                                <Phone class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="contact-card-title">Téléphone</h3>
                                <a href="tel:+237600000000" class="contact-card-link">+237 6 00 00 00 00</a>
                            </div>
                        </div>

                        <div class="contact-card">
                            <div class="contact-card-icon icon-purple">
                                <Mail class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="contact-card-title">Email</h3>
                                <a href="mailto:contact@shoptech.cm" class="contact-card-link">contact@shoptech.cm</a>
                            </div>
                        </div>

                        <div class="contact-card">
                            <div class="contact-card-icon icon-amber">
                                <Clock class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="contact-card-title">Horaires</h3>
                                <p class="contact-card-text">Lun–Sam : 8h – 18h<br/>Dim : Fermé</p>
                            </div>
                        </div>

                        <!-- WhatsApp -->
                        <a :href="`https://wa.me/${WHATSAPP_NUMBER}?text=${WHATSAPP_MSG}`" target="_blank" class="contact-whatsapp">
                            <MessageCircle class="w-6 h-6" />
                            <div>
                                <p class="contact-whatsapp-title">WhatsApp</p>
                                <p class="contact-whatsapp-text">Réponse rapide garantie</p>
                            </div>
                        </a>
                    </div>

                    <!-- Contact Form -->
                    <div class="contact-form-container">
                        <div class="contact-form-card">
                            <h2 class="contact-form-title">Envoyer un message</h2>

                            <form @submit.prevent="submit" class="contact-form">
                                <div class="contact-form-row">
                                    <div class="contact-form-group">
                                        <label class="contact-label">Nom complet</label>
                                        <input v-model="form.name" type="text" class="contact-input" placeholder="Jean Dupont" />
                                        <p v-if="form.errors.name" class="contact-error">{{ form.errors.name }}</p>
                                    </div>
                                    <div class="contact-form-group">
                                        <label class="contact-label">Email</label>
                                        <input v-model="form.email" type="email" class="contact-input" placeholder="votre@email.com" />
                                        <p v-if="form.errors.email" class="contact-error">{{ form.errors.email }}</p>
                                    </div>
                                </div>

                                <div class="contact-form-group">
                                    <label class="contact-label">Sujet</label>
                                    <input v-model="form.subject" type="text" class="contact-input" placeholder="Question sur ma commande" />
                                    <p v-if="form.errors.subject" class="contact-error">{{ form.errors.subject }}</p>
                                </div>

                                <div class="contact-form-group">
                                    <label class="contact-label">Message</label>
                                    <textarea v-model="form.message" rows="5" class="contact-textarea" placeholder="Décrivez votre demande..."></textarea>
                                    <p v-if="form.errors.message" class="contact-error">{{ form.errors.message }}</p>
                                </div>

                                <button type="submit" :disabled="form.processing" class="contact-submit">
                                    <Send class="w-4 h-4" />
                                    {{ form.processing ? 'Envoi en cours...' : 'Envoyer le message' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
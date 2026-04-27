<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import ShopLayout from '@/layouts/ShopLayout.vue';
import { MapPin, Phone, Mail, Clock, Send } from 'lucide-vue-next';
import { computed } from 'vue';

defineOptions({ layout: ShopLayout });

const page = usePage();
const flash = computed(() => (page.props as any).flash ?? {});

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

    <div class="pt-24">
        <!-- Hero -->
        <section class="py-20 bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute top-1/3 left-1/4 w-80 h-80 bg-blue-400/10 rounded-full blur-[80px]"></div>
            </div>
            <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
                <span class="inline-block px-4 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-[10px] font-black uppercase tracking-widest mb-6">Nous sommes là pour vous</span>
                <h1 class="text-4xl lg:text-5xl font-black tracking-tight uppercase italic mb-4">
                    Contactez-<span class="text-blue-600">nous</span>
                </h1>
                <p class="text-slate-600 dark:text-slate-400 font-medium leading-relaxed">
                    Une question ? Un problème ? Notre équipe est disponible du lundi au samedi de 8h à 18h.
                </p>
            </div>
        </section>

        <section class="py-16 max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Info Cards -->
                <div class="space-y-5">
                    <div class="shop-card p-6 flex items-start gap-4 hover:-translate-y-1">
                        <div class="w-11 h-11 bg-blue-600/10 rounded-2xl flex items-center justify-center shrink-0">
                            <MapPin class="w-5 h-5 text-blue-600" />
                        </div>
                        <div>
                            <h3 class="font-black text-sm mb-1">Adresse</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Rue de la Cathédrale<br/>Yaoundé, Cameroun</p>
                        </div>
                    </div>
                    <div class="shop-card p-6 flex items-start gap-4 hover:-translate-y-1">
                        <div class="w-11 h-11 bg-green-500/10 rounded-2xl flex items-center justify-center shrink-0">
                            <Phone class="w-5 h-5 text-green-500" />
                        </div>
                        <div>
                            <h3 class="font-black text-sm mb-1">Téléphone</h3>
                            <a href="tel:+237600000000" class="text-sm text-slate-500 dark:text-slate-400 font-medium hover:text-blue-600 transition-colors">+237 6 00 00 00 00</a>
                        </div>
                    </div>
                    <div class="shop-card p-6 flex items-start gap-4 hover:-translate-y-1">
                        <div class="w-11 h-11 bg-indigo-500/10 rounded-2xl flex items-center justify-center shrink-0">
                            <Mail class="w-5 h-5 text-indigo-500" />
                        </div>
                        <div>
                            <h3 class="font-black text-sm mb-1">Email</h3>
                            <a href="mailto:contact@shoptech.cm" class="text-sm text-slate-500 dark:text-slate-400 font-medium hover:text-blue-600 transition-colors">contact@shoptech.cm</a>
                        </div>
                    </div>
                    <div class="shop-card p-6 flex items-start gap-4 hover:-translate-y-1">
                        <div class="w-11 h-11 bg-amber-500/10 rounded-2xl flex items-center justify-center shrink-0">
                            <Clock class="w-5 h-5 text-amber-500" />
                        </div>
                        <div>
                            <h3 class="font-black text-sm mb-1">Horaires</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Lun–Sam : 8h – 18h<br/>Dim : Fermé</p>
                        </div>
                    </div>

                    <!-- WhatsApp quick access -->
                    <a
                        :href="`https://wa.me/${WHATSAPP_NUMBER}?text=${WHATSAPP_MSG}`"
                        target="_blank"
                        class="flex items-center gap-3 p-5 bg-green-500 text-white rounded-3xl shadow-xl shadow-green-500/30 hover:bg-green-600 transition-all group"
                    >
                        <svg class="w-7 h-7 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <div>
                            <p class="font-black text-sm uppercase tracking-wider">WhatsApp</p>
                            <p class="text-xs text-green-100 font-medium">Réponse rapide garantie</p>
                        </div>
                    </a>
                </div>

                <!-- Contact Form -->
                <div class="lg:col-span-2">
                    <div class="shop-card p-8 lg:p-10">
                        <h2 class="text-xl font-black mb-6 uppercase tracking-tight">Envoyer un message</h2>

                        <div v-if="flash.success" class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-2xl text-green-700 dark:text-green-400 font-semibold text-sm">
                            ✅ {{ flash.success }}
                        </div>

                        <form @submit.prevent="submit" class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="space-y-1.5">
                                    <label class="shop-label block">Nom complet</label>
                                    <input
                                        v-model="form.name"
                                        type="text"
                                        class="shop-input"
                                        placeholder="Jean Dupont"
                                    />
                                    <p v-if="form.errors.name" class="text-red-500 text-xs font-semibold">{{ form.errors.name }}</p>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="shop-label block">Email</label>
                                    <input
                                        v-model="form.email"
                                        type="email"
                                        class="shop-input"
                                        placeholder="votre@email.com"
                                    />
                                    <p v-if="form.errors.email" class="text-red-500 text-xs font-semibold">{{ form.errors.email }}</p>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="shop-label block">Sujet</label>
                                <input
                                    v-model="form.subject"
                                    type="text"
                                    class="shop-input"
                                    placeholder="ex: Question sur ma commande"
                                />
                                <p v-if="form.errors.subject" class="text-red-500 text-xs font-semibold">{{ form.errors.subject }}</p>
                            </div>
                            <div class="space-y-1.5">
                                <label class="shop-label block">Message</label>
                                <textarea
                                    v-model="form.message"
                                    rows="6"
                                    class="shop-input resize-none"
                                    placeholder="Décrivez votre demande..."
                                ></textarea>
                                <p v-if="form.errors.message" class="text-red-500 text-xs font-semibold">{{ form.errors.message }}</p>
                            </div>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="shop-btn-primary w-full py-4 flex items-center justify-center gap-2 text-xs rounded-2xl disabled:opacity-50"
                            >
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

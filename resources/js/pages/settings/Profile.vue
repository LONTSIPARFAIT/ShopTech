<script setup lang="ts">
import { Head, Link, usePage, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { edit } from '@/routes/profile';
import { update as profileUpdate } from '@/routes/profile';
import { send } from '@/routes/verification';
import { Camera, Loader2, User, Mail, ShieldCheck, ArrowLeft } from 'lucide-vue-next';
import ShopLayout from '@/Layouts/ShopLayout.vue';

type Props = {
    mustVerifyEmail: boolean;
    status?: string;
};

defineProps<Props>();

const page = usePage();
const user = computed(() => (page.props.auth as any).user);

const form = useForm({
    _method: 'PATCH',
    name: user.value.name,
    email: user.value.email,
    avatar: null as File | null,
});

const avatarPreview = ref(user.value.avatar_url);

const handleAvatarChange = (e: Event) => {
    const file = (e.target as HTMLInputElement).files?.[0];
    if (file) {
        form.avatar = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            avatarPreview.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    form.post(profileUpdate().url, {
        preserveScroll: true,
        onSuccess: () => {
            form.avatar = null;
        }
    });
};
</script>

<template>
    <ShopLayout>
        <Head title="Paramètres du profil" />

        <div class="pt-48 pb-32 px-6 mx-auto max-w-4xl lg:px-12">
            <div class="flex flex-col space-y-12">
                <!-- Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                    <div class="space-y-4">
                        <Link href="/dashboard" class="group flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-blue-600 transition-colors">
                            <ArrowLeft class="w-4 h-4 group-hover:-translate-x-1 transition-transform" /> Retour
                        </Link>
                        <h1 class="text-6xl font-black tracking-tight uppercase italic leading-none">
                            Mon <span class="text-blue-600">Profil</span>
                        </h1>
                        <p class="text-slate-500 font-medium max-w-md">Personnalisez votre présence sur ShopTech et gérez vos informations de contact.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 pt-12">
                    <!-- Left: Avatar & Quick Info -->
                    <div class="lg:col-span-1 space-y-8">
                        <div class="p-10 bg-slate-50 dark:bg-slate-900 rounded-[3.5rem] border border-slate-100 dark:border-slate-800 text-center space-y-6 shadow-2xl shadow-black/[0.02]">
                            <div class="relative inline-block group">
                                <div class="w-40 h-40 rounded-[3rem] overflow-hidden border-8 border-white dark:border-slate-950 shadow-2xl relative">
                                    <img v-if="avatarPreview" :src="avatarPreview" class="w-full h-full object-cover" />
                                    <div v-else class="w-full h-full bg-blue-600 flex items-center justify-center text-white text-4xl font-black italic">
                                        {{ user.name.substring(0, 1) }}
                                    </div>
                                    <div v-if="form.processing" class="absolute inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center text-white">
                                        <Loader2 class="w-10 h-10 animate-spin" />
                                    </div>
                                </div>
                                <label class="absolute -bottom-2 -right-2 w-12 h-12 bg-blue-600 text-white rounded-2xl flex items-center justify-center cursor-pointer hover:scale-110 transition-all shadow-xl border-4 border-white dark:border-slate-950 group-hover:rotate-12">
                                    <Camera class="w-6 h-6" />
                                    <input type="file" class="hidden" @change="handleAvatarChange" accept="image/*" />
                                </label>
                            </div>
                            
                            <div class="space-y-2">
                                <h3 class="text-2xl font-black uppercase italic">{{ user.name }}</h3>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ user.email }}</p>
                            </div>

                            <div class="pt-6 flex justify-center gap-4">
                                <div class="px-4 py-2 bg-white dark:bg-slate-950 rounded-full border border-slate-100 dark:border-slate-800 flex items-center gap-2">
                                    <ShieldCheck class="w-4 h-4 text-emerald-500" />
                                    <span class="text-[9px] font-black uppercase tracking-widest opacity-60">Vérifié</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Form -->
                    <div class="lg:col-span-2">
                        <form @submit.prevent="submit" class="p-10 bg-white dark:bg-slate-900 rounded-[3.5rem] border border-slate-100 dark:border-slate-800 shadow-2xl shadow-black/[0.02] space-y-10">
                            <div class="space-y-8">
                                <div class="space-y-3">
                                    <Label for="name" class="text-[10px] font-black uppercase tracking-[0.2em] opacity-40 px-2 flex items-center gap-2">
                                        <User class="w-3 h-3" /> Nom Complet
                                    </Label>
                                    <Input
                                        id="name"
                                        v-model="form.name"
                                        class="h-16 px-8 bg-slate-50 dark:bg-slate-950 border-none rounded-[1.8rem] font-bold text-lg focus:ring-2 focus:ring-blue-600 transition-all"
                                        required
                                        autocomplete="name"
                                        placeholder="Votre nom complet"
                                    />
                                    <InputError :message="form.errors.name" />
                                </div>

                                <div class="space-y-3">
                                    <Label for="email" class="text-[10px] font-black uppercase tracking-[0.2em] opacity-40 px-2 flex items-center gap-2">
                                        <Mail class="w-3 h-3" /> Adresse Email
                                    </Label>
                                    <Input
                                        id="email"
                                        type="email"
                                        v-model="form.email"
                                        class="h-16 px-8 bg-slate-50 dark:bg-slate-950 border-none rounded-[1.8rem] font-bold text-lg focus:ring-2 focus:ring-blue-600 transition-all"
                                        required
                                        autocomplete="username"
                                        placeholder="votre@email.com"
                                    />
                                    <InputError :message="form.errors.email" />
                                </div>

                                <div v-if="mustVerifyEmail && !user.email_verified_at" class="p-6 bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-800/30 rounded-3xl space-y-2">
                                    <p class="text-sm text-amber-700 dark:text-amber-400 font-medium">
                                        Votre adresse email n'est pas vérifiée.
                                    </p>
                                    <Link
                                        :href="send()"
                                        as="button"
                                        class="text-xs font-black uppercase tracking-widest text-amber-900 dark:text-amber-200 underline decoration-amber-500/30 underline-offset-8 hover:text-amber-600 transition-colors"
                                    >
                                        Renvoyer le lien de vérification.
                                    </Link>
                                    <div v-if="status === 'verification-link-sent'" class="mt-4 text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600">
                                        ✓ Un nouveau lien a été envoyé.
                                    </div>
                                </div>
                            </div>

                            <div class="pt-6">
                                <Button 
                                    :disabled="form.processing" 
                                    class="w-full h-16 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-[1.8rem] font-black uppercase tracking-[0.2em] text-xs hover:scale-[1.02] active:scale-95 transition-all shadow-2xl shadow-black/10"
                                >
                                    <Loader2 v-if="form.processing" class="w-4 h-4 mr-3 animate-spin" />
                                    {{ form.processing ? 'Enregistrement...' : 'Mettre à jour le profil' }}
                                </Button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </ShopLayout>
</template>


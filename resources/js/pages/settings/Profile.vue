<script setup lang="ts">
import { Head, Link, usePage, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { update as profileUpdate } from '@/routes/profile';
import { send } from '@/routes/verification';
import { Camera, Loader2, User, Mail, ShieldCheck, ArrowLeft } from 'lucide-vue-next';

const page = usePage();
const user = computed(() => (page.props.auth as any).user);

const form = useForm({
    _method: 'PATCH',
    name: user.value.name,
    email: user.value.email,
    avatar: null as File | null,
});

const avatarPreview = ref(user.value.avatar_url);
const isUploading = ref(false);

const props = defineProps<{
    mustVerifyEmail: boolean;
    status?: string;
}>();

const handleAvatarChange = (e: Event) => {
    const file = (e.target as HTMLInputElement).files?.[0];
    if (file) {
        form.avatar = file;
        isUploading.value = true;
        const reader = new FileReader();
        reader.onload = (e) => {
            avatarPreview.value = e.target?.result as string;
            isUploading.value = false;
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

    <Head title="Paramètres du profil" />

    <!-- Grid Layout -->
    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Left: Avatar Card -->
        <div class="lg:col-span-1">
            <div
                class="rounded-xl border border-gray-200 bg-white p-6 text-center shadow-sm dark:border-gray-800 dark:bg-gray-900/50">
                <!-- Avatar -->
                <div class="relative mb-4 inline-block">
                    <div
                        class="relative h-32 w-32 overflow-hidden rounded-xl bg-gradient-to-br from-blue-500 to-blue-600">
                        <img v-if="avatarPreview" :src="avatarPreview" class="h-full w-full object-cover" />
                        <div v-else
                            class="flex h-full w-full items-center justify-center text-4xl font-bold text-white">
                            {{ user.name.charAt(0).toUpperCase() }}
                        </div>
                        <div v-if="isUploading || form.processing"
                            class="absolute inset-0 flex items-center justify-center bg-black/50">
                            <Loader2 class="h-6 w-6 animate-spin text-white" />
                        </div>
                    </div>
                    <label
                        class="absolute -bottom-2 -right-2 flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg bg-blue-600 text-white transition-transform hover:scale-110">
                        <Camera class="h-4 w-4" />
                        <input type="file" class="hidden" @change="handleAvatarChange" accept="image/*" />
                    </label>
                </div>

                <!-- User Info -->
                <div class="mb-3">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ user.name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ user.email }}</p>
                </div>

                <!-- Badge -->
                <div
                    class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-400">
                    <ShieldCheck class="h-3 w-3" />
                    Compte vérifié
                </div>
            </div>
        </div>

        <!-- Right: Form Card -->
        <div class="lg:col-span-2">
            <form @submit.prevent="submit"
                class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900/50">
                <!-- Name Field -->
                <div class="mb-6">
                    <Label for="name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Nom
                        complet</Label>
                    <div class="relative">
                        <User class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                        <Input id="name" v-model="form.name"
                            class="h-11 w-full rounded-lg border-gray-200 bg-gray-50 pl-9 transition-all focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                            required autocomplete="name" placeholder="Votre nom complet" />
                    </div>
                    <InputError :message="form.errors.name" class="mt-1 text-sm text-red-500" />
                </div>

                <!-- Email Field -->
                <div class="mb-6">
                    <Label for="email" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Adresse
                        email</Label>
                    <div class="relative">
                        <Mail class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                        <Input id="email" type="email" v-model="form.email"
                            class="h-11 w-full rounded-lg border-gray-200 bg-gray-50 pl-9 transition-all focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                            required autocomplete="username" placeholder="votre@email.com" />
                    </div>
                    <InputError :message="form.errors.email" class="mt-1 text-sm text-red-500" />
                </div>

                <!-- Email Verification Warning -->
                <div v-if="mustVerifyEmail && !user.email_verified_at"
                    class="mb-6 flex items-start gap-3 rounded-lg border border-amber-200 bg-amber-50 p-4 dark:border-amber-800/30 dark:bg-amber-950/20">
                    <ShieldCheck class="h-5 w-5 text-amber-500" />
                    <div>
                        <p class="text-sm font-medium text-amber-700 dark:text-amber-400">
                            Votre adresse email n'est pas vérifiée.
                        </p>
                        <Link :href="send()" as="button"
                            class="text-xs font-medium text-amber-600 hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300">
                            Renvoyer le lien de vérification
                        </Link>
                    </div>
                </div>
                <div v-if="status === 'verification-link-sent'"
                    class="mb-6 rounded-lg bg-green-50 p-3 text-center text-sm text-green-700 dark:bg-green-950/20 dark:text-green-400">
                    ✓ Un nouveau lien de vérification a été envoyé.
                </div>

                <!-- Submit Button -->
                <Button :disabled="form.processing"
                    class="h-11 w-full rounded-lg bg-gradient-to-r from-blue-600 to-blue-500 font-semibold text-white shadow-lg shadow-blue-500/20 transition-all hover:shadow-xl hover:shadow-blue-500/30 hover:-translate-y-0.5 disabled:opacity-50">
                    <Loader2 v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                    Enregistrer les modifications
                </Button>
            </form>
        </div>
    </div>
</template>
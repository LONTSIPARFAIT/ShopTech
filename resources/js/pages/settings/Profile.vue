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

    <div class="settings-container">
        <!-- Header -->
        <div class="settings-header">
            <Link href="/dashboard" class="settings-back-link">
                <ArrowLeft class="h-4 w-4" />
                Retour au tableau de bord
            </Link>
            <div>
                <h1 class="settings-title">Mon profil</h1>
                <p class="settings-subtitle">Personnalisez votre présence et gérez vos informations</p>
            </div>
        </div>

        <div class="settings-grid">
            <!-- Left: Avatar -->
            <div class="settings-sidebar">
                <div class="settings-card">
                    <div class="settings-avatar-container">
                        <div class="settings-avatar-wrapper">
                            <img v-if="avatarPreview" :src="avatarPreview" class="settings-avatar" />
                            <div v-else class="settings-avatar-placeholder">
                                {{ user.name.charAt(0).toUpperCase() }}
                            </div>
                            <div v-if="isUploading || form.processing" class="settings-avatar-overlay">
                                <Loader2 class="h-6 w-6 animate-spin" />
                            </div>
                        </div>
                        <label class="settings-avatar-btn">
                            <Camera class="h-4 w-4" />
                            <input type="file" class="hidden" @change="handleAvatarChange" accept="image/*" />
                        </label>
                    </div>
                    
                    <div class="settings-user-info">
                        <h3 class="settings-user-name">{{ user.name }}</h3>
                        <p class="settings-user-email">{{ user.email }}</p>
                    </div>

                    <div class="settings-badge">
                        <ShieldCheck class="h-3 w-3" />
                        <span>Compte vérifié</span>
                    </div>
                </div>
            </div>

            <!-- Right: Form -->
            <div class="settings-main">
                <form @submit.prevent="submit" class="settings-form-card">
                    <div class="settings-form-group">
                        <Label for="name" class="settings-label">Nom complet</Label>
                        <div class="settings-input-wrapper">
                            <User class="settings-input-icon" />
                            <Input
                                id="name"
                                v-model="form.name"
                                class="settings-input"
                                required
                                autocomplete="name"
                                placeholder="Votre nom complet"
                            />
                        </div>
                        <InputError :message="form.errors.name" class="settings-error" />
                    </div>

                    <div class="settings-form-group">
                        <Label for="email" class="settings-label">Adresse email</Label>
                        <div class="settings-input-wrapper">
                            <Mail class="settings-input-icon" />
                            <Input
                                id="email"
                                type="email"
                                v-model="form.email"
                                class="settings-input"
                                required
                                autocomplete="username"
                                placeholder="votre@email.com"
                            />
                        </div>
                        <InputError :message="form.errors.email" class="settings-error" />
                    </div>

                    <div v-if="mustVerifyEmail && !user.email_verified_at" class="settings-verify-warning">
                        <ShieldCheck class="h-4 w-4 text-amber-500" />
                        <div>
                            <p class="text-sm font-medium text-amber-700 dark:text-amber-400">
                                Votre adresse email n'est pas vérifiée.
                            </p>
                            <Link
                                :href="send()"
                                as="button"
                                class="text-xs font-medium text-amber-600 hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300"
                            >
                                Renvoyer le lien de vérification
                            </Link>
                        </div>
                        <div v-if="status === 'verification-link-sent'" class="mt-2 text-xs text-green-600">
                            ✓ Un nouveau lien a été envoyé.
                        </div>
                    </div>

                    <Button 
                        :disabled="form.processing" 
                        class="settings-submit-btn"
                    >
                        <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Enregistrer les modifications
                    </Button>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>
.settings-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 2rem;
}

.settings-header {
    margin-bottom: 2rem;
}

.settings-back-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
    color: #6b7280;
    transition: color 0.2s;
}

.settings-back-link:hover {
    color: #3b82f6;
}

.settings-title {
    font-size: 2rem;
    font-weight: 700;
    letter-spacing: -0.025em;
    margin-bottom: 0.5rem;
}

@media (min-width: 768px) {
    .settings-title {
        font-size: 2.5rem;
    }
}

.settings-subtitle {
    font-size: 0.875rem;
    color: #6b7280;
}

.settings-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

@media (min-width: 1024px) {
    .settings-grid {
        grid-template-columns: 1fr 2fr;
    }
}

.settings-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.settings-card {
    background-color: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 1rem;
    padding: 1.5rem;
    text-align: center;
}

.dark .settings-card {
    background-color: #1f2937;
    border-color: #374151;
}

.settings-avatar-container {
    position: relative;
    display: inline-block;
    margin-bottom: 1rem;
}

.settings-avatar-wrapper {
    width: 8rem;
    height: 8rem;
    border-radius: 1rem;
    overflow: hidden;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    position: relative;
}

.settings-avatar {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.settings-avatar-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
}

.settings-avatar-overlay {
    position: absolute;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.settings-avatar-btn {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 2rem;
    height: 2rem;
    background-color: #3b82f6;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: transform 0.2s;
    color: white;
}

.settings-avatar-btn:hover {
    transform: scale(1.1);
}

.settings-user-info {
    margin-bottom: 1rem;
}

.settings-user-name {
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.settings-user-email {
    font-size: 0.75rem;
    color: #6b7280;
}

.dark .settings-user-email {
    color: #9ca3af;
}

.settings-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.75rem;
    background-color: #10b981;
    border-radius: 9999px;
    font-size: 0.7rem;
    font-weight: 500;
    color: white;
}

.settings-main {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.settings-form-card {
    background-color: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 1rem;
    padding: 1.5rem;
}

.dark .settings-form-card {
    background-color: #1f2937;
    border-color: #374151;
}

.settings-form-group {
    margin-bottom: 1.5rem;
}

.settings-label {
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
    display: block;
}

.settings-input-wrapper {
    position: relative;
}

.settings-input-icon {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    width: 1rem;
    height: 1rem;
    color: #9ca3af;
}

.settings-input {
    width: 100%;
    padding: 0.625rem 0.75rem 0.625rem 2rem;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
    background-color: #f9fafb;
    font-size: 0.875rem;
    transition: all 0.2s;
}

.dark .settings-input {
    background-color: #374151;
    border-color: #4b5563;
    color: #f9fafb;
}

.settings-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.settings-error {
    font-size: 0.75rem;
    color: #ef4444;
    margin-top: 0.25rem;
}

.settings-verify-warning {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background-color: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
}

.dark .settings-verify-warning {
    background-color: #422006;
    border-color: #713f12;
}

.settings-submit-btn {
    width: 100%;
    padding: 0.75rem;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    font-weight: 600;
    border-radius: 0.5rem;
    transition: all 0.2s;
}

.settings-submit-btn:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
}
</style>
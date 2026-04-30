<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import { onUnmounted, ref } from 'vue';
import SecurityController from '@/actions/App/Http/Controllers/Settings/SecurityController';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TwoFactorRecoveryCodes from '@/components/TwoFactorRecoveryCodes.vue';
import TwoFactorSetupModal from '@/components/TwoFactorSetupModal.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { useTwoFactorAuth } from '@/composables/useTwoFactorAuth';
import { enable, disable } from '@/routes/two-factor';
import { ShieldCheck, Key, Lock, ArrowLeft } from 'lucide-vue-next';

type Props = {
    canManageTwoFactor?: boolean;
    requiresConfirmation?: boolean;
    twoFactorEnabled?: boolean;
};

withDefaults(defineProps<Props>(), {
    canManageTwoFactor: false,
    requiresConfirmation: false,
    twoFactorEnabled: false,
});

const { hasSetupData, clearTwoFactorAuthData } = useTwoFactorAuth();
const showSetupModal = ref<boolean>(false);

onUnmounted(() => clearTwoFactorAuthData());
</script>

<template>

    <Head title="Sécurité" />

    <div class="space-y-6">
        <!-- Update Password Card -->
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900/50">
            <div class="mb-6 flex items-center gap-3 border-b border-gray-100 pb-4 dark:border-gray-800">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/50 dark:text-blue-400">
                    <Lock class="h-5 w-5" />
                </div>
                <div>
                    <h2 class="font-semibold text-gray-900 dark:text-white">Modifier le mot de passe</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Choisissez un mot de passe long et sécurisé</p>
                </div>
            </div>

            <Form v-bind="SecurityController.update.form()" :options="{ preserveScroll: true }" reset-on-success
                :reset-on-error="['password', 'password_confirmation', 'current_password']" class="space-y-4"
                v-slot="{ errors, processing }">
                <div class="space-y-2">
                    <Label for="current_password" class="text-sm font-medium text-gray-700 dark:text-gray-300">Mot de
                        passe actuel</Label>
                    <PasswordInput id="current_password" name="current_password"
                        class="h-11 w-full rounded-lg border-gray-200 bg-gray-50 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        autocomplete="current-password" placeholder="Votre mot de passe actuel" />
                    <InputError :message="errors.current_password" />
                </div>

                <div class="space-y-2">
                    <Label for="password" class="text-sm font-medium text-gray-700 dark:text-gray-300">Nouveau mot de
                        passe</Label>
                    <PasswordInput id="password" name="password"
                        class="h-11 w-full rounded-lg border-gray-200 bg-gray-50 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        autocomplete="new-password" placeholder="Nouveau mot de passe" />
                    <InputError :message="errors.password" />
                </div>

                <div class="space-y-2">
                    <Label for="password_confirmation"
                        class="text-sm font-medium text-gray-700 dark:text-gray-300">Confirmer le mot de passe</Label>
                    <PasswordInput id="password_confirmation" name="password_confirmation"
                        class="h-11 w-full rounded-lg border-gray-200 bg-gray-50 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        autocomplete="new-password" placeholder="Confirmez le mot de passe" />
                    <InputError :message="errors.password_confirmation" />
                </div>

                <Button :disabled="processing"
                    class="mt-4 w-full rounded-lg bg-gradient-to-r from-blue-600 to-blue-500 py-2 font-semibold text-white transition-all hover:-translate-y-0.5 hover:shadow-lg">
                    Mettre à jour le mot de passe
                </Button>
            </Form>
        </div>

        <!-- Two Factor Auth Card -->
        <div v-if="canManageTwoFactor"
            class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900/50">
            <div class="mb-6 flex items-center gap-3 border-b border-gray-100 pb-4 dark:border-gray-800">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-950/50 dark:text-purple-400">
                    <Key class="h-5 w-5" />
                </div>
                <div>
                    <h2 class="font-semibold text-gray-900 dark:text-white">Authentification à deux facteurs</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Sécurisez votre compte avec une double
                        vérification</p>
                </div>
            </div>

            <div v-if="!twoFactorEnabled" class="space-y-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Lorsque vous activez l'authentification à deux facteurs, vous serez invité
                    à saisir un code PIN sécurisé lors de la connexion.
                </p>

                <Button v-if="hasSetupData" @click="showSetupModal = true"
                    class="rounded-lg bg-gradient-to-r from-blue-600 to-blue-500 px-4 py-2 font-medium text-white transition-all hover:-translate-y-0.5 hover:shadow-lg">
                    <ShieldCheck class="mr-2 h-4 w-4" />
                    Continuer la configuration
                </Button>
                <Form v-else v-bind="enable.form()" @success="showSetupModal = true" #default="{ processing }">
                    <Button type="submit" :disabled="processing"
                        class="rounded-lg bg-gradient-to-r from-blue-600 to-blue-500 px-4 py-2 font-medium text-white transition-all hover:-translate-y-0.5 hover:shadow-lg">
                        Activer la 2FA
                    </Button>
                </Form>
            </div>

            <div v-else class="space-y-4">
                <div
                    class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-400">
                    <ShieldCheck class="h-3 w-3" />
                    Protection activée
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Votre compte est protégé par l'authentification à deux facteurs.
                </p>

                <Form v-bind="disable.form()" #default="{ processing }">
                    <Button variant="destructive" type="submit" :disabled="processing"
                        class="rounded-lg bg-red-600 px-4 py-2 font-medium text-white transition-all hover:bg-red-700">
                        Désactiver la 2FA
                    </Button>
                </Form>

                <TwoFactorRecoveryCodes />
            </div>
        </div>
    </div>

    <TwoFactorSetupModal v-model:isOpen="showSetupModal" :requiresConfirmation="requiresConfirmation"
        :twoFactorEnabled="twoFactorEnabled" />
</template>
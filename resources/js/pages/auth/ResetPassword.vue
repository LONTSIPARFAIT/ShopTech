<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { update } from '@/routes/password';
import { Lock, ShieldCheck } from 'lucide-vue-next';

defineOptions({
    layout: {
        title: 'Réinitialiser le mot de passe',
        description: 'Entrez votre nouveau mot de passe ci-dessous',
    },
});

const props = defineProps<{
    token: string;
    email: string;
}>();

const inputEmail = ref(props.email);
</script>

<template>
    <Head title="Réinitialiser le mot de passe" />

    <Form
        v-bind="update.form()"
        :transform="(data) => ({ ...data, token, email })"
        :reset-on-success="['password', 'password_confirmation']"
        v-slot="{ errors, processing }"
    >
        <div class="space-y-6">
            <!-- Email (readonly) -->
            <div class="space-y-2">
                <Label for="email" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Email</Label>
                <Input
                    id="email"
                    type="email"
                    name="email"
                    autocomplete="email"
                    v-model="inputEmail"
                    class="h-11 w-full rounded-xl border-gray-200 bg-gray-50 text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                    readonly
                />
                <InputError :message="errors.email" class="text-sm text-red-500 dark:text-red-400" />
            </div>

            <!-- New Password -->
            <div class="space-y-2">
                <Label for="password" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Nouveau mot de passe</Label>
                <div class="relative">
                    <Lock class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400 transition-colors peer-focus:text-blue-600 dark:peer-focus:text-blue-400" />
                    <PasswordInput
                        id="password"
                        name="password"
                        autocomplete="new-password"
                        class="h-11 w-full rounded-xl border-gray-200 bg-white pl-9 transition-all duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:focus:border-blue-400"
                        autofocus
                        placeholder="Nouveau mot de passe"
                    />
                </div>
                <InputError :message="errors.password" class="text-sm text-red-500 dark:text-red-400" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <Label for="password_confirmation" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Confirmer le mot de passe</Label>
                <div class="relative">
                    <Lock class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400 transition-colors peer-focus:text-blue-600 dark:peer-focus:text-blue-400" />
                    <PasswordInput
                        id="password_confirmation"
                        name="password_confirmation"
                        autocomplete="new-password"
                        class="h-11 w-full rounded-xl border-gray-200 bg-white pl-9 transition-all duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:focus:border-blue-400"
                        placeholder="Confirmez votre mot de passe"
                    />
                </div>
                <InputError :message="errors.password_confirmation" class="text-sm text-red-500 dark:text-red-400" />
            </div>

            <!-- Submit Button -->
            <Button
                type="submit"
                class="mt-4 h-11 w-full rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 font-semibold text-white shadow-lg shadow-blue-500/20 transition-all duration-300 hover:shadow-xl hover:shadow-blue-500/30 hover:-translate-y-0.5 disabled:opacity-50"
                :disabled="processing"
                data-test="reset-password-button"
            >
                <Spinner v-if="processing" class="mr-2 h-4 w-4 animate-spin" />
                <ShieldCheck v-else class="mr-2 h-4 w-4" />
                Réinitialiser le mot de passe
            </Button>
        </div>
    </Form>
</template>
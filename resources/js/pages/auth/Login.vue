<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';
import { Mail, Lock, LogIn, Sparkles } from 'lucide-vue-next';

defineOptions({
    layout: {
        title: 'Connexion à votre compte',
        description: 'Entrez votre email et mot de passe pour vous connecter',
    },
});

defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>();
</script>

<template>
    <Head title="Connexion" />

    <!-- Status Alert -->
    <div v-if="status" class="mb-6 flex items-center justify-center gap-2 rounded-xl bg-green-50 p-3 text-center text-sm font-medium text-green-700 dark:bg-green-950/20 dark:text-green-400 border border-green-200 dark:border-green-800/30">
        <Sparkles class="h-4 w-4" />
        {{ status }}
    </div>

    <Form
        v-bind="store.form()"
        :reset-on-success="['password']"
        v-slot="{ errors, processing }"
        class="flex flex-col gap-6"
    >
        <!-- Email Field -->
        <div class="space-y-2">
            <Label for="email" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Adresse email</Label>
            <div class="relative">
                <Mail class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400 transition-colors peer-focus:text-blue-600 dark:peer-focus:text-blue-400" />
                <Input
                    id="email"
                    type="email"
                    name="email"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="email"
                    placeholder="exemple@email.com"
                    class="h-11 w-full rounded-xl border-gray-200 bg-white pl-9 transition-all duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:focus:border-blue-400"
                />
            </div>
            <InputError :message="errors.email" class="text-sm text-red-500 dark:text-red-400" />
        </div>

        <!-- Password Field -->
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <Label for="password" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Mot de passe</Label>
                <TextLink
                    v-if="canResetPassword"
                    :href="request()"
                    class="text-sm font-medium text-blue-600 transition-colors hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                    :tabindex="5"
                >
                    Mot de passe oublié ?
                </TextLink>
            </div>
            <div class="relative">
                <Lock class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400 transition-colors peer-focus:text-blue-600 dark:peer-focus:text-blue-400" />
                <PasswordInput
                    id="password"
                    name="password"
                    required
                    :tabindex="2"
                    autocomplete="current-password"
                    placeholder="Votre mot de passe"
                    class="h-11 w-full rounded-xl border-gray-200 bg-white pl-9 transition-all duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:focus:border-blue-400"
                />
            </div>
            <InputError :message="errors.password" class="text-sm text-red-500 dark:text-red-400" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <Label for="remember" class="flex cursor-pointer items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <Checkbox id="remember" name="remember" :tabindex="3" class="rounded-sm border-gray-300 dark:border-gray-600 data-[state=checked]:border-blue-600" />
                <span>Se souvenir de moi</span>
            </Label>
        </div>

        <!-- Submit Button -->
        <Button
            type="submit"
            class="mt-2 h-11 w-full rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 font-semibold text-white shadow-lg shadow-blue-500/20 transition-all duration-300 hover:shadow-xl hover:shadow-blue-500/30 hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed dark:from-blue-500 dark:to-blue-600"
            :tabindex="4"
            :disabled="processing"
            data-test="login-button"
        >
            <Spinner v-if="processing" class="mr-2 h-4 w-4 animate-spin" />
            <LogIn v-else class="mr-2 h-4 w-4" />
            Se connecter
        </Button>

        <!-- Register Link -->
        <div v-if="canRegister" class="flex items-center justify-center gap-1 pt-2 text-sm text-gray-500 border-t border-gray-100 dark:border-gray-800">
            <span>Pas encore de compte ?</span>
            <TextLink :href="register()" :tabindex="5" class="inline-flex items-center gap-1 font-semibold text-blue-600 transition-all hover:gap-2 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                Créer un compte
                <Sparkles class="h-3 w-3" />
            </TextLink>
        </div>
    </Form>
</template>
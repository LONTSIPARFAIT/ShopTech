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
            <Label for="email" class="text-sm font-semibold text-foreground">Adresse email</Label>
            <div class="relative">
                <Mail class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground transition-colors peer-focus:text-primary" />
                <Input
                    id="email"
                    type="email"
                    name="email"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="email"
                    placeholder="exemple@email.com"
                    class="h-11 w-full rounded-xl bg-secondary border-border pl-9 transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20"
                />
            </div>
            <InputError :message="errors.email" />
        </div>

        <!-- Password Field -->
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <Label for="password" class="text-sm font-semibold text-foreground">Mot de passe</Label>
                <TextLink
                    v-if="canResetPassword"
                    :href="request()"
                    class="text-sm font-medium text-primary hover:text-primary-dark transition-colors"
                    :tabindex="5"
                >
                    Mot de passe oublié ?
                </TextLink>
            </div>
            <div class="relative">
                <Lock class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground transition-colors peer-focus:text-primary" />
                <PasswordInput
                    id="password"
                    name="password"
                    required
                    :tabindex="2"
                    autocomplete="current-password"
                    placeholder="Votre mot de passe"
                    class="h-11 w-full rounded-xl bg-secondary border-border pl-9 transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20"
                />
            </div>
            <InputError :message="errors.password" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <Label for="remember" class="flex cursor-pointer items-center gap-2 text-sm text-muted-foreground">
                <Checkbox id="remember" name="remember" :tabindex="3" class="rounded-sm data-[state=checked]:bg-primary data-[state=checked]:border-primary" />
                <span>Se souvenir de moi</span>
            </Label>
        </div>

        <!-- Submit Button -->
        <Button
            type="submit"
            class="mt-2 h-11 w-full rounded-xl bg-gradient-to-r from-primary to-primary-dark font-semibold text-white shadow-lg shadow-primary/20 transition-all duration-300 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-0.5 disabled:opacity-50"
            :tabindex="4"
            :disabled="processing"
        >
            <Spinner v-if="processing" class="mr-2 h-4 w-4 animate-spin" />
            <LogIn v-else class="mr-2 h-4 w-4" />
            Se connecter
        </Button>

        <!-- Register Link -->
        <div v-if="canRegister" class="flex items-center justify-center gap-1 pt-2 text-sm text-muted-foreground border-t border-border">
            <span>Pas encore de compte ?</span>
            <TextLink :href="register()" :tabindex="5" class="inline-flex items-center gap-1 font-semibold text-primary transition-all hover:gap-2">
                Créer un compte
                <Sparkles class="h-3 w-3" />
            </TextLink>
        </div>
    </Form>
</template>

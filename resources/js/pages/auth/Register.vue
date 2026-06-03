<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { store } from '@/routes/register';
import { User, Mail, Lock, UserPlus, Sparkles } from 'lucide-vue-next';

defineOptions({
    layout: {
        title: 'Créer un compte',
        description: 'Rejoignez notre communauté technologique',
    },
});
</script>

<template>
    <Head title="Inscription" />

    <Form
        v-bind="store.form()"
        :reset-on-success="['password', 'password_confirmation']"
        v-slot="{ errors, processing }"
        class="flex flex-col gap-5"
    >
        <!-- Name Field -->
        <div class="space-y-2">
            <Label for="name" class="text-sm font-semibold text-foreground">Nom complet</Label>
            <div class="relative">
                <User class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground transition-colors peer-focus:text-primary" />
                <Input
                    id="name"
                    type="text"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="name"
                    name="name"
                    placeholder="Jean Dupont"
                    class="h-11 w-full rounded-xl bg-secondary border-border pl-9 transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20"
                />
            </div>
            <InputError :message="errors.name" />
        </div>

        <!-- Email Field -->
        <div class="space-y-2">
            <Label for="email" class="text-sm font-semibold text-foreground">Adresse email</Label>
            <div class="relative">
                <Mail class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground transition-colors peer-focus:text-primary" />
                <Input
                    id="email"
                    type="email"
                    required
                    :tabindex="2"
                    autocomplete="email"
                    name="email"
                    placeholder="exemple@email.com"
                    class="h-11 w-full rounded-xl bg-secondary border-border pl-9 transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20"
                />
            </div>
            <InputError :message="errors.email" />
        </div>

        <!-- Password Field -->
        <div class="space-y-2">
            <Label for="password" class="text-sm font-semibold text-foreground">Mot de passe</Label>
            <div class="relative">
                <Lock class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground transition-colors peer-focus:text-primary" />
                <PasswordInput
                    id="password"
                    required
                    :tabindex="3"
                    autocomplete="new-password"
                    name="password"
                    placeholder="Créez un mot de passe sécurisé"
                    class="h-11 w-full rounded-xl bg-secondary border-border pl-9 transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20"
                />
            </div>
            <InputError :message="errors.password" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2">
            <Label for="password_confirmation" class="text-sm font-semibold text-foreground">Confirmer le mot de passe</Label>
            <div class="relative">
                <Lock class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground transition-colors peer-focus:text-primary" />
                <PasswordInput
                    id="password_confirmation"
                    required
                    :tabindex="4"
                    autocomplete="new-password"
                    name="password_confirmation"
                    placeholder="Confirmez votre mot de passe"
                    class="h-11 w-full rounded-xl bg-secondary border-border pl-9 transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20"
                />
            </div>
            <InputError :message="errors.password_confirmation" />
        </div>

        <!-- Password Hint -->
        <div class="flex items-center gap-2 text-xs text-muted-foreground">
            <div class="flex gap-1">
                <span class="h-1.5 w-1.5 rounded-full bg-muted-foreground"></span>
                <span class="h-1.5 w-1.5 rounded-full bg-muted-foreground"></span>
                <span class="h-1.5 w-1.5 rounded-full bg-muted-foreground"></span>
                <span class="h-1.5 w-1.5 rounded-full bg-muted-foreground"></span>
            </div>
            <p>Minimum 8 caractères avec lettres et chiffres</p>
        </div>

        <!-- Submit Button -->
        <Button
            type="submit"
            class="mt-2 h-11 w-full rounded-xl bg-gradient-to-r from-primary to-primary-dark font-semibold text-white shadow-lg shadow-primary/20 transition-all duration-300 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-0.5 disabled:opacity-50"
            tabindex="5"
            :disabled="processing"
        >
            <Spinner v-if="processing" class="mr-2 h-4 w-4 animate-spin" />
            <UserPlus v-else class="mr-2 h-4 w-4" />
            Créer mon compte
        </Button>

        <!-- Login Link -->
        <div class="flex items-center justify-center gap-1 pt-2 text-sm text-muted-foreground border-t border-border">
            <span>Déjà un compte ?</span>
            <TextLink :href="login()" class="inline-flex items-center gap-1 font-semibold text-primary transition-all hover:gap-2" :tabindex="6">
                Se connecter
                <Sparkles class="h-3 w-3" />
            </TextLink>
        </div>
    </Form>
</template>

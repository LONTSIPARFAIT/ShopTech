<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { email } from '@/routes/password';
import { Mail, KeyRound } from 'lucide-vue-next';

defineOptions({
    layout: {
        title: 'Mot de passe oublié',
        description: 'Entrez votre email pour recevoir un lien de réinitialisation',
    },
});

defineProps<{
    status?: string;
}>();
</script>

<template>
    <Head title="Mot de passe oublié" />

    <div v-if="status" class="mb-6 rounded-xl bg-green-50 p-3 text-center text-sm font-medium text-green-700 dark:bg-green-950/20 dark:text-green-400 border border-green-200 dark:border-green-800/30">
        {{ status }}
    </div>

    <Form v-bind="email.form()" v-slot="{ errors, processing }">
        <div class="space-y-6">
            <div class="space-y-2">
                <Label for="email" class="text-sm font-semibold text-foreground">Adresse email</Label>
                <div class="relative">
                    <Mail class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground transition-colors peer-focus:text-primary" />
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        autocomplete="off"
                        autofocus
                        placeholder="exemple@email.com"
                        class="h-11 w-full rounded-xl bg-secondary border-border pl-9 transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20"
                    />
                </div>
                <InputError :message="errors.email" />
            </div>

            <Button
                type="submit"
                class="h-11 w-full rounded-xl bg-gradient-to-r from-primary to-primary-dark font-semibold text-white shadow-lg shadow-primary/20 transition-all duration-300 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-0.5 disabled:opacity-50"
                :disabled="processing"
            >
                <Spinner v-if="processing" class="mr-2 h-4 w-4 animate-spin" />
                <KeyRound v-else class="mr-2 h-4 w-4" />
                Envoyer le lien de réinitialisation
            </Button>

            <div class="text-center text-sm text-muted-foreground">
                <span>Retour à </span>
                <TextLink :href="login()" class="font-medium text-primary hover:text-primary-dark transition-colors">
                    la connexion
                </TextLink>
            </div>
        </div>
    </Form>
</template>

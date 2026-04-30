<script setup lang="ts">
import { Form, Head, setLayoutProps } from '@inertiajs/vue3';
import { computed, ref, watchEffect } from 'vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import {
    InputOTP,
    InputOTPGroup,
    InputOTPSlot,
} from '@/components/ui/input-otp';
import { store } from '@/routes/two-factor/login';
import type { TwoFactorConfigContent } from '@/types';
import { ShieldCheck, Key, Fingerprint } from 'lucide-vue-next';

const authConfigContent = computed<TwoFactorConfigContent>(() => {
    if (showRecoveryInput.value) {
        return {
            title: 'Code de récupération',
            description: 'Veuillez entrer un de vos codes de récupération d\'urgence.',
            buttonText: 'utiliser un code d\'authentification',
        };
    }

    return {
        title: 'Code d\'authentification',
        description: 'Entrez le code à 6 chiffres de votre application d\'authentification.',
        buttonText: 'utiliser un code de récupération',
    };
});

watchEffect(() => {
    setLayoutProps({
        title: authConfigContent.value.title,
        description: authConfigContent.value.description,
    });
});

const showRecoveryInput = ref<boolean>(false);

const toggleRecoveryMode = (clearErrors: () => void): void => {
    showRecoveryInput.value = !showRecoveryInput.value;
    clearErrors();
    code.value = '';
};

const code = ref<string>('');
</script>

<template>
    <Head title="Authentification à deux facteurs" />

    <div class="flex flex-col items-center justify-center gap-6">
        <!-- Icon -->
        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-600 to-blue-500 shadow-lg shadow-blue-500/30">
            <Fingerprint class="h-8 w-8 text-white" />
        </div>

        <template v-if="!showRecoveryInput">
            <Form
                v-bind="store.form()"
                class="w-full space-y-6"
                reset-on-error
                @error="code = ''"
                #default="{ errors, processing, clearErrors }"
            >
                <input type="hidden" name="code" :value="code" />
                
                <div class="flex flex-col items-center gap-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Entrez le code à 6 chiffres</p>
                    <InputOTP
                        id="otp"
                        v-model="code"
                        :maxlength="6"
                        :disabled="processing"
                        autofocus
                    >
                        <InputOTPGroup>
                            <InputOTPSlot
                                v-for="index in 6"
                                :key="index"
                                :index="index - 1"
                                class="h-12 w-12 rounded-xl border-2 border-gray-200 text-lg font-semibold transition-all focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:focus:border-blue-400"
                            />
                        </InputOTPGroup>
                    </InputOTP>
                    <InputError :message="errors.code" class="text-sm text-red-500 dark:text-red-400" />
                </div>

                <Button type="submit" class="h-11 w-full rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 font-semibold text-white shadow-lg shadow-blue-500/20 transition-all duration-300 hover:shadow-xl hover:shadow-blue-500/30 hover:-translate-y-0.5" :disabled="processing">
                    <ShieldCheck class="mr-2 h-4 w-4" />
                    Vérifier
                </Button>

                <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                    <span>ou vous pouvez </span>
                    <button
                        type="button"
                        class="font-semibold text-blue-600 transition-all hover:text-blue-700 hover:underline dark:text-blue-400 dark:hover:text-blue-300"
                        @click="() => toggleRecoveryMode(clearErrors)"
                    >
                        {{ authConfigContent.buttonText }}
                    </button>
                </div>
            </Form>
        </template>

        <template v-else>
            <Form
                v-bind="store.form()"
                class="w-full space-y-6"
                reset-on-error
                #default="{ errors, processing, clearErrors }"
            >
                <div class="relative">
                    <Key class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                    <Input
                        name="recovery_code"
                        type="text"
                        placeholder="Entrez votre code de récupération"
                        :autofocus="showRecoveryInput"
                        required
                        class="h-11 w-full rounded-xl border-gray-200 bg-white pl-9 transition-all duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-900 dark:focus:border-blue-400"
                    />
                    <InputError :message="errors.recovery_code" class="mt-2 text-sm text-red-500 dark:text-red-400" />
                </div>

                <Button type="submit" class="h-11 w-full rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 font-semibold text-white shadow-lg shadow-blue-500/20 transition-all duration-300 hover:shadow-xl hover:shadow-blue-500/30 hover:-translate-y-0.5" :disabled="processing">
                    <ShieldCheck class="mr-2 h-4 w-4" />
                    Vérifier
                </Button>

                <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                    <span>ou vous pouvez </span>
                    <button
                        type="button"
                        class="font-semibold text-blue-600 transition-all hover:text-blue-700 hover:underline dark:text-blue-400 dark:hover:text-blue-300"
                        @click="() => toggleRecoveryMode(clearErrors)"
                    >
                        {{ authConfigContent.buttonText }}
                    </button>
                </div>
            </Form>
        </template>
    </div>
</template>
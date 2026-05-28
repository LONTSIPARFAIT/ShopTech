<template>
    <div class="group p-5 rounded-xl transition-all duration-300 hover:-translate-y-1 bg-slate-800/50 backdrop-blur-sm border border-slate-700 hover:border-orange-500/50">
        <!-- En-tête avec icône et titre sur la même ligne -->
        <div class="flex items-center gap-3 mb-3">
            <!-- Icône -->
            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center transition-all duration-300 group-hover:scale-110 flex-shrink-0">
                <component :is="icon" class="w-5 h-5 text-white" />
            </div>

            <!-- Titre à côté de l'icône -->
            <h3 class="text-base font-bold text-white transition-colors group-hover:text-orange-400">
                {{ title }}
            </h3>
        </div>

        <!-- Description -->
        <p class="text-sm text-slate-300 leading-relaxed pl-0">
            {{ description }}
        </p>
    </div>
</template>

<script setup lang="ts">
defineProps<{
    icon: any;
    title: string;
    description: string;
}>();
</script>

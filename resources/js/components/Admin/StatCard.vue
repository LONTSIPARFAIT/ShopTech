<script setup lang="ts">
defineProps<{
    label: string;
    value: string | number;
    unit?: string;
    trend?: string;
    icon?: any;
    color?: string;
}>();
</script>

<template>
    <div class="group relative bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm transition-all duration-500 hover:shadow-2xl hover:shadow-blue-500/10 hover:-translate-y-1 overflow-hidden">
        <!-- Decoration -->
        <div 
            class="absolute top-0 right-0 w-32 h-32 blur-[80px] rounded-full translate-x-1/2 -translate-y-1/2 opacity-20 transition-all duration-500 group-hover:scale-150"
            :class="color || 'bg-blue-500'"
        ></div>
        
        <div class="relative z-10 flex justify-between items-start">
            <div class="space-y-4">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300 transition-colors">
                    {{ label }}
                </p>
                <h3 class="text-4xl font-black tracking-tight">
                    {{ typeof value === 'number' ? value.toLocaleString() : value }}
                    <span v-if="unit" class="text-sm font-bold opacity-50">{{ unit }}</span>
                </h3>
                <div v-if="trend" class="flex items-center gap-1.5 text-xs font-bold text-green-500 bg-green-500/10 px-2.5 py-1 rounded-full w-fit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                    </svg>
                    {{ trend }}
                </div>
            </div>

            <div 
                class="w-14 h-14 rounded-2xl flex items-center justify-center transition-all duration-500 group-hover:rotate-6 shadow-lg shadow-black/5"
                :class="color ? `bg-${color.split('-')[1]}-100 text-${color.split('-')[1]}-600 dark:bg-${color.split('-')[1]}-900/30` : 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400'"
            >
                <component :is="icon" v-if="icon" class="w-7 h-7" />
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
        </div>
    </div>
</template>

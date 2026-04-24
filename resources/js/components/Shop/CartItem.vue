<script setup lang="ts">
const props = defineProps<{
    item: any;
}>();

const emit = defineEmits(['update', 'remove']);
</script>

<template>
    <div class="flex gap-6 p-6 bg-slate-50 dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm">
        <div class="w-24 h-24 sm:w-32 sm:h-32 bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shrink-0">
            <img 
                v-if="item.product.featured_image" 
                :src="item.product.featured_image.path" 
                class="w-full h-full object-cover"
            />
        </div>

        <div class="flex-1 flex flex-col justify-between">
            <div class="flex justify-between gap-4">
                <div>
                    <h3 class="font-bold text-lg">{{ item.product.name }}</h3>
                    <p v-if="item.variant" class="text-sm text-slate-500">
                        {{ item.variant.name }}: {{ item.variant.value }}
                    </p>
                </div>
                <button @click="emit('remove', item.id)" class="text-slate-400 hover:text-red-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center bg-white dark:bg-slate-800 rounded-xl p-1 border border-slate-200 dark:border-slate-700 shadow-sm">
                    <button @click="emit('update', item.id, item.quantity - 1)" class="w-8 h-8 flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg">-</button>
                    <span class="w-10 text-center text-sm font-bold">{{ item.quantity }}</span>
                    <button @click="emit('update', item.id, item.quantity + 1)" class="w-8 h-8 flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg">+</button>
                </div>
                <div class="font-black text-lg">
                    {{ (Number(item.variant?.price_override || item.product.base_price) * item.quantity).toLocaleString() }} XAF
                </div>
            </div>
        </div>
    </div>
</template>

<template>
    <div class="relative group">
        <!-- Section Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                    {{ title }}
                </h2>
                <p v-if="subtitle" class="text-gray-600 dark:text-gray-400 mt-1">
                    {{ subtitle }}
                </p>
            </div>
            <Link 
                :href="viewAllLink" 
                class="text-blue-600 hover:text-blue-700 font-semibold text-sm flex items-center gap-1"
            >
                Voir tout
                <ArrowRight class="w-4 h-4" />
            </Link>
        </div>

        <!-- Slider Container -->
        <div class="relative">
            <!-- Navigation Buttons -->
            <button
                @click="scrollLeft"
                class="absolute left-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white dark:bg-gray-800 shadow-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110 disabled:opacity-30 disabled:cursor-not-allowed"
                :disabled="scrollPosition <= 0"
            >
                <ChevronLeft class="w-5 h-5" />
            </button>

            <button
                @click="scrollRight"
                class="absolute right-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white dark:bg-gray-800 shadow-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110 disabled:opacity-30 disabled:cursor-not-allowed"
                :disabled="scrollPosition >= maxScroll"
            >
                <ChevronRight class="w-5 h-5" />
            </button>

            <!-- Slider Track -->
            <div
                ref="sliderRef"
                class="flex gap-5 overflow-x-auto scroll-smooth snap-x snap-mandatory scrollbar-hide"
                @scroll="handleScroll"
            >
                <div
                    v-for="(item, index) in items"
                    :key="item.id"
                    class="flex-shrink-0 w-[280px] snap-start"
                >
                    <slot :item="item" :index="index" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ChevronLeft, ChevronRight, ArrowRight } from 'lucide-vue-next';

const props = defineProps<{
    title: string;
    subtitle?: string;
    viewAllLink: string;
    items: any[];
}>();

const sliderRef = ref<HTMLDivElement | null>(null);
const scrollPosition = ref(0);
const maxScroll = ref(0);

const handleScroll = () => {
    if (sliderRef.value) {
        scrollPosition.value = sliderRef.value.scrollLeft;
    }
};

const scrollLeft = () => {
    if (sliderRef.value) {
        sliderRef.value.scrollBy({ left: -300, behavior: 'smooth' });
    }
};

const scrollRight = () => {
    if (sliderRef.value) {
        sliderRef.value.scrollBy({ left: 300, behavior: 'smooth' });
    }
};

const updateMaxScroll = () => {
    if (sliderRef.value) {
        maxScroll.value = sliderRef.value.scrollWidth - sliderRef.value.clientWidth;
    }
};

onMounted(() => {
    updateMaxScroll();
    window.addEventListener('resize', updateMaxScroll);
});

watch(() => props.items, () => {
    setTimeout(updateMaxScroll, 100);
});
</script>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
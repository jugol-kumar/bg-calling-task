<template xmlns="http://www.w3.org/1999/html">
    <button :disabled="isLoading" :class="isLoading ? 'animate-pulse' : ''"
            class="my-3 bg-primary-600 w-full text-white rounded-md px-3 py-2  hover:bg-secondary
            transition-all disabled:border-primary-500/50 ease-in-out duration-500">
        <span v-if="!isLoading">
            <slot></slot>
        </span>
        <span v-else class="flex justify-center gap-4 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24">
                <g stroke="currentColor">
                    <circle cx="12" cy="12" r="9.5" fill="none" stroke-linecap="round" stroke-width="3">
                        <animate attributeName="stroke-dasharray" calcMode="spline" dur="1.5s"
                                 keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1"
                                 keyTimes="0;0.475;0.95;1" repeatCount="indefinite"
                                 values="0 150;42 150;42 150;42 150"/>
                        <animate attributeName="stroke-dashoffset" calcMode="spline" dur="1.5s"
                                 keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1"
                                 keyTimes="0;0.475;0.95;1" repeatCount="indefinite" values="0;-16;-59;-59"/>
                    </circle>
                    <animateTransform attributeName="transform" dur="2s" repeatCount="indefinite"
                                      type="rotate" values="0 12 12;360 12 12"/>
                </g>
            </svg>
            <span class="text-sm font-semibold">Loading</span>
        </span>
    </button>
</template>

<script setup>
defineProps({ isLoading:false })
</script>

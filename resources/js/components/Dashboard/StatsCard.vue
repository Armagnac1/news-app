<template>
  <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
      <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-gray-100">{{ title }}</h3>
      <p class="text-3xl font-bold" :class="[textColorClass, 'dark:text-opacity-90']">{{ value }}</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    required: true
  },
  value: {
    type: [Number, String],
    required: true
  },
  textColorClass: {
    type: String,
    default: 'text-blue-600 dark:text-blue-400'
  }
});
</script>

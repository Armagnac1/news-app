<template>
  <div v-if="links.length > 3" class="flex flex-wrap -mb-1">
    <template v-for="(link, key) in links" :key="key">
      <div
        v-if="link.url === null"
        class="mr-1 mb-1 px-4 py-2 text-sm text-gray-400 border rounded"
        v-html="link.label"
      />
      <Link
        v-else
        :href="link.url"
        class="mr-1 mb-1 px-4 py-2 text-sm border rounded hover:bg-gray-100 focus:border-indigo-500 focus:text-indigo-500"
        :class="{
          'bg-blue-50 text-blue-600': link.active,
          'text-gray-700': !link.active
        }"
        v-html="link.label"
      />
    </template>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  links: {
    type: Array,
    required: true,
  },
});
</script> 
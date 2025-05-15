<template>
  <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">News Sources</h2>
        <button
          @click="updateAllSources"
          class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
          :disabled="isUpdating"
        >
          {{ isUpdating ? 'Updating...' : 'Update All Sources' }}
        </button>
      </div>
      
      <div class="space-y-4">
        <div
          v-for="source in sources"
          :key="source.id"
          class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg"
        >
          <div>
            <h3 class="font-semibold text-gray-900 dark:text-gray-100">{{ source.name }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ source.url }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-500">
              Last updated: {{ formatDate(source.last_updated_at) }}
            </p>
          </div>
          <button
            @click="updateSource(source.id)"
            class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition-colors"
            :disabled="isUpdating"
          >
            Update
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  sources: {
    type: Array,
    required: true
  }
});

const isUpdating = ref(false);

const formatDate = (date) => {
  if (!date) return 'Never';
  return new Date(date).toLocaleString();
};

const updateSource = async (sourceId) => {
  isUpdating.value = true;
  try {
    await router.post(route('admin.news.update-source', { source: sourceId }));
  } catch (error) {
    console.error('Failed to update source:', error);
  } finally {
    isUpdating.value = false;
  }
};

const updateAllSources = async () => {
  isUpdating.value = true;
  try {
    await router.post(route('admin.news.update-all-sources'));
  } catch (error) {
    console.error('Failed to update all sources:', error);
  } finally {
    isUpdating.value = false;
  }
};
</script> 
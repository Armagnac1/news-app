<template>
  <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
    <div class="p-6">
      <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Verification Codes</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Code</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created At</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Expires At</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            <tr v-for="code in codes.data" :key="code.id">
              <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">{{ code.user?.name }}</td>
              <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">{{ code.code }}</td>
              <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
                {{ new Date(code.created_at).toLocaleString() }}
              </td>
              <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
                {{ new Date(code.expires_at).toLocaleString() }}
              </td>
              <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <span
                  :class="{
                    'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200': code.used_at,
                    'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200': !code.used_at && new Date(code.expires_at) > new Date(),
                    'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200': !code.used_at && new Date(code.expires_at) <= new Date(),
                  }"
                  class="px-2 py-1 rounded-full text-sm"
                >
                  {{ code.used_at ? 'Used' : new Date(code.expires_at) > new Date() ? 'Active' : 'Expired' }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- Pagination -->
      <div class="mt-4">
        <Pagination :links="codes.links" />
      </div>
    </div>
  </div>
</template>

<script setup>
import Pagination from '@/Components/Pagination.vue';

defineProps({
  codes: {
    type: Object,
    required: true
  }
});
</script> 
<template>
  <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
    <div class="p-6">
      <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">{{ title }}</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Telegram</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ dateColumn }}</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            <tr v-for="user in users" :key="user.id">
              <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">{{ user.name }}</td>
              <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">{{ user.email }}</td>
              <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">{{ user.telegram_username }}</td>
              <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100">
                {{ new Date(user[dateField]).toLocaleString() }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    required: true
  },
  users: {
    type: Array,
    required: true
  },
  dateColumn: {
    type: String,
    required: true
  },
  dateField: {
    type: String,
    required: true
  }
});
</script> 
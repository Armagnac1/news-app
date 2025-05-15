<script setup lang="ts">
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { Input } from '@/components/ui/input';

defineProps<{
    status?: string;
    errors?: {
        code?: string;
    };
}>();

const requestForm = useForm({});
const verifyForm = useForm({
    code: '',
});

const requestCode = () => {
    requestForm.post(route('telegram-verification.resend'));
};

const verifyCode = () => {
    verifyForm.post(route('telegram-verification.verify'));
};

const openTelegram = () => {
    window.open('https://t.me/news_app_test_task_bot', '_blank');
};
</script>

<template>
    <AuthLayout title="Verify Telegram" description="Please verify your Telegram account by entering the code sent to you.">
        <Head title="Telegram verification" />

        <div v-if="status === 'verification-link-sent'" class="mb-4 text-center text-sm font-medium text-green-600">
            A new verification code has been sent to your Telegram account.
        </div>

        <!-- Form to request a new verification code -->
        <form @submit.prevent="requestCode" class="space-y-6 text-center mb-6">
            <Button :disabled="requestForm.processing" variant="secondary">
                <LoaderCircle v-if="requestForm.processing" class="h-4 w-4 animate-spin" />
                Request verification code
            </Button>
        </form>

        <!-- Form to input the verification code -->
        <form @submit.prevent="verifyCode" class="space-y-6 text-center">
            <div class="space-y-2">
                <Input
                    v-model="verifyForm.code"
                    type="text"
                    placeholder="Enter verification code"
                    class="w-full"
                    :class="{ 'border-red-500': errors?.code }"
                />
                <p v-if="errors?.code" class="text-sm text-red-500">
                    {{ errors.code }}
                </p>
            </div>

            <Button :disabled="verifyForm.processing" variant="secondary">
                <LoaderCircle v-if="verifyForm.processing" class="h-4 w-4 animate-spin" />
                Verify code
            </Button>
        </form>

        <!-- Link to open Telegram -->
        <Button @click="openTelegram" variant="link" class="mx-auto block text-sm mt-6">
            Open Telegram
        </Button>

        <TextLink :href="route('logout')" method="post" as="button" class="mx-auto block text-sm mt-6"> Log out </TextLink>
    </AuthLayout>
</template>

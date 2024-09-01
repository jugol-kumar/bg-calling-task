<script setup>

import {ref} from 'vue';
import {useAuthStore} from '@/stores/useAuthStore.js';
import {useRouter} from 'vue-router'
import LoadingButton from "@/components/LoadingButton.vue";
import Input from "@/components/Input.vue";
import {useToast} from "vue-toastification";


const authStore = useAuthStore();
const router = useRouter()
const toast = useToast();

//Login
const loginCredential = ref({
  email: 'admin@admin.com',
  password: '12345678',
});

const handleLogin = async () => {
  const loginResponse = await authStore.login(loginCredential.value);
  if (loginResponse) {
    await router.push({name: "Dashboard"});
  }
}

</script>

<template>
  <div class="w-full h-screen grid place-items-center bg-white">
    <div class="w-[30%] h-max">
      <div class="w-full shadow-md px-6 py-3 rounded-lg">
        <h3 class="text-center font-medium text-3xl uppercase mb-3">Sign in</h3>
        <div class="flex flex-col items-center gap-2">
          <Input
              class="w-full"
              label="Email"
              labelName="Email"
              :error="authStore.error?.response?.data?.errors?.email"
              v-model="loginCredential.email"
              :loading="authStore.loading"
              type="email"
              required
              placeholder="Enter your Email"
          />

          <Input
              class="w-full"
              label="Password"
              labelName="Password"
              v-model="loginCredential.password"
              :error="authStore.error?.response?.data?.errors?.password"
              :loading="authStore.loading"
              type="password"
              required
              placeholder="Enter your Password"
          />
          <div class="w-full">
            <LoadingButton @click="handleLogin" :isLoading="authStore.loading">
              Login
            </LoadingButton>
          </div>
          <p class="text-xs text-primary-600 font-semibold">Don't have an account yet? <RouterLink class="text-blue-600 underline" to="#" @click="toast.info('Please Contact With Administrator For Create Account.')">Sign Up</RouterLink></p>
        </div>
      </div>
    </div>
  </div>
</template>
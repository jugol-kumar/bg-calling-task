<template>
  <AppLayout>
    <div class="flex items-center justify-between p-5">
    </div>
    <div class="relative container mx-auto">
      <div class="grid grid-cols-3 gap-10">
        <div class="col-span-1">
          <div>
            <p class="text-lg font-bold">Personal Information</p>
            <p class="text-sm text-gray-700">Setup your personal admin profile</p>
          </div>
        </div>
        <div class="col-span-2">
          <div class="flex items-center gap-8">
            <div class="w-24 h-24 rounded-lg overflow-hidden">
              <img class="w-full h-full object-cover" :src="previewImage"
                   @error="event => event.target.src=`https://ui-avatars.com/api/?name=${authStore.user.name}`"
                   alt="">
            </div>
            <div class="flex flex-col gap-2">
              <label for="profileupdate"
                     class="font-semibold text-primary-100 rounded-lg w-max bg-primary-500 px-4 py-2">
                Change Avatar
                <input class="hidden" @change="onFileChange" type="file" id="profileupdate">
              </label>
              <span class="text-sm">JPG, PNG, SVG. 1MB max</span>
            </div>
          </div>
          <form @submit.prevent="updateProfile" class="flex flex-col gap-5 mt-16">
            <div class="w-full flex flex-col gap-4">
              <Input
                  class="w-full"
                  label="Name"
                  labelName="Name"
                  :error="error?.response?.data?.errors?.name"
                  v-model="createForm.name"
                  :loading="loadProfile"
                  type="text"
                  required
                  placeholder="Enter role name"
              />
              <Input
                  class="w-full"
                  label="Email"
                  labelName="Email"
                  :error="error?.response?.data?.errors?.email"
                  v-model="createForm.email"
                  :loading="loadProfile"
                  type="email"
                  required
                  placeholder="Enter role name"
              />

              <LoadingButton :isLoading="loadProfile">Update Profile</LoadingButton>
            </div>
          </form>
        </div>
      </div>

      <div class="grid grid-cols-3 gap-10 mt-16">
        <div class="col-span-1">
          <div>
            <p class="text-lg font-bold">Change Your Password</p>
            <p class="text-sm text-gray-700">update your new password.</p>
          </div>
        </div>
        <div class="col-span-2">
          <form @submit.prevent="handelUpdatePassword" class="flex flex-col gap-5">
            <Input
                class="w-full"
                label="Current Password"
                labelName="Current Password"
                :error="error?.response?.data?.errors?.current_password"
                v-model="updatePassword.current_password"
                :loading="loadPassword"
                type="password"
                required
                placeholder="Enter Current Password"
            />

            <Input
                class="w-full"
                label="New Password"
                labelName="New Password"
                :error="error?.response?.data?.errors?.new_password"
                v-model="updatePassword.new_password"
                :loading="loadPassword"
                type="password"
                required
                placeholder="Enter New Password"
            />
            <Input
                class="w-full"
                label="Confirm Password"
                labelName="Confirm Password"
                :error="error?.response?.data?.errors?.confirm_password"
                v-model="updatePassword.confirm_password"
                :loading="loadPassword"
                type="password"
                required
                placeholder="Enter Confirm Password"
            />
            <LoadingButton :isLoading="loadPassword">Update Password</LoadingButton>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@/components/Layouts/AppLayout.vue";
import useAxios from "@/composables/useAxios.js";
import {ref} from "vue";
import {useToast} from "vue-toastification";
import LoadingButton from "@/components/LoadingButton.vue";
import {useAuthStore} from "@/stores/useAuthStore.js";
import Input from "../../components/Input.vue";

const toast = useToast();
const {sendRequest, loading, error} = useAxios();
const authStore = useAuthStore()


const createForm = ref({
  name: authStore.user.name,
  email: authStore.user.email,
  image: {}
})

const loadProfile = ref(false)
const updateProfile = async () => {
  const response = await sendRequest({
    url: '/v1/profile-update',
    method: 'POST',
    params: {
      _method: 'PUT'
    },
    data: createForm.value
  }, loadProfile)
  toast.success(response?.data?.message)
  await authStore.logout();
}
const updatePassword = ref({
  current_password: null,
  new_password: null,
  confirm_password: null,
})

const loadPassword = ref(false)

const handelUpdatePassword = async () => {
  const response = await sendRequest({
    url: '/v1/password-update',
    method: 'POST',
    data: updatePassword.value
  }, loadPassword)
  toast.success(response?.data?.message)
  await authStore.logout();
}


const profileImage = ref({})
const previewImage = ref(authStore.user?.image)
const onFileChange = (event) => {
  const image = event.target.files[0]
  createForm.value.image = image
  previewImage.value = URL.createObjectURL(image)
}


</script>

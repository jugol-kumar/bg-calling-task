<script setup>
import AppLayout from "@/components/Layouts/AppLayout.vue";
import LoadingButton from "@/components/LoadingButton.vue";
import Breadcrumbs from "@/components/Breadcrumbs.vue";
import Input from "../../components/Input.vue";
import {useToast} from "vue-toastification";
import {onMounted, ref} from "vue";
import useAxios from "../../composables/useAxios.js";

const {sendRequest, loading, error} = useAxios();
const toast = useToast();
const user = ref({
  name: null,
  email: null,
  phone: null,
  password: null,
  role: null,
  image: null,
})
const roles = ref([
  {
    id: 1, name: 'Gulshan 1, Dhaka'
  },

  {
    id: 2, name: 'Gulshan 2, Dhaka'
  },
  {
    id: 3, name: 'Savar, Dhaka'
  },

  {
    id: 4, name: 'Badda, Dhaka'
  }
])
const previewImage = ref(null)
const coverImage = (image) => {
  const file = image.target.files[0];
  user.value.image = file;
  previewImage.value = URL.createObjectURL(file);
}

const saveUser = async () => {
  const res = await sendRequest({
    url: '/v1/user',
    method: 'POST',
    data: user.value
  })
  user.value = {}
  previewImage.value = null;
  toast.success(res.data)
}

const getAllRoles = async () => {
  const res = await sendRequest({
    url: '/v1/get-all-roles',
    method: 'GET'
  })
  roles.value = res.data
}
onMounted(() => getAllRoles())


</script>


<template>
  <AppLayout>

    <Breadcrumbs
        :item="{name:'Users', path:'/users', icon:'solar:users-group-rounded-bold-duotone'}"
        :links="[{name:'Index', path:'/users'}, {name:'Add User', path:'/add-user'}]"
    />

    <div class="bg-white min-h-screen shadow-lg rounded-lg mt-4 p-4">
      <div class="flex items-center justify-between">
        <p class="font-bold">Roles</p>
        <RouterLink to="/users"
                    class="px-2 py-1 rounded-md bg-primary-700 text-white flex items-center gap-2 hover:shadow-lg transition-all ease-in-out duration-300">
          <Icon name="solar:arrow-left-line-duotone"/>
          <span class="text-xs font-semibold">Back</span>
        </RouterLink>
      </div>
      <TransitionGroup name="fade" appear>
        <form @submit.prevent="saveUser" class="max-w-md mx-auto mb-20 mt-12 flex flex-col gap-5">
          <Input
              class="w-full"
              label="Name"
              labelName="Name"
              v-model="user.name"
              :error="error?.response?.data?.errors?.name"
              :loading="loading"
              type="text"
              required
              placeholder="e.g  john doh"
          />
          <div class="flex items-center gap-4">
            <Input
                class="w-full"
                label="Email"
                labelName="Email"
                v-model="user.email"
                :error="error?.response?.data?.errors?.email"
                :loading="loading"
                type="email"
                required
                placeholder="e.g  example@test.com"
            />

            <Input
                class="w-full"
                label="Password"
                labelName="Password"
                v-model="user.password"
                :error="error?.response?.data?.errors?.password"
                :loading="loading"
                type="password"
                required
                placeholder="Enter your Password"
            />
          </div>


          <div class="flex flex-col items-start justify-center w-full">
            <div class="flex items-center justify-center w-full">
              <label for="dropzone-file"
                     class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                <span v-if="previewImage" class="p-2 w-full h-full rounded-lg">
                  <img class="w-full h-full object-cover rounded-lg" :src="previewImage"/>
                </span>
                <span v-else class="flex flex-col items-center justify-center pt-5 pb-6">
                <Icon name="solar:cloud-upload-line-duotone" class="w-12 h-12"/>
                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                    class="font-semibold">Click to upload </span></p>
                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 1024kb)</p>
              </span>
                <input id="dropzone-file" @input="coverImage" type="file" class="hidden" label-name="file"/>
              </label>

            </div>
            <small class="text-red-500 text-left" v-if="error?.response?.data?.errors?.image">
              {{ error?.response?.data?.errors?.image[0] }}
            </small>
          </div>
          <div>
            <label class="text-sm block mb-2">Role <span class="text-red-500 ms-2">*</span></label>
            <Select
                class="disabled:bg-gray-200"
                :disabled="loading"
                label="name"
                :options="roles"
                :reduce="item => item.id"
                v-model="user.role"
                placeholder="Select this user role"
            >
            </Select>
            <small class="text-red-500" v-if="error?.response?.data?.errors?.role">
              {{ error?.response?.data?.errors?.role[0] }}
            </small>
          </div>
          <LoadingButton :isLoading="loading">Save User</LoadingButton>
        </form>
      </TransitionGroup>

    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@/components/Layouts/AppLayout.vue";
import Breadcrumbs from "@/components/Breadcrumbs.vue";
import {onMounted, ref} from "vue";
import DeleteButton from "../../components/DeleteButton.vue";
import useAxios from "../../composables/useAxios.js";

const {sendRequest, error, loading} = useAxios()


const items = ref([])

const getAllRoles = async () => {
  const res = await sendRequest({
    url: '/v1/role',
    method: 'GET'
  })
  items.value = res.data
}


onMounted(() => {
  getAllRoles();
})

</script>
<template>
  <AppLayout>

    <Breadcrumbs
        :item="{name:'Roles', path:'/roles', icon:'solar:shield-user-bold-duotone'}"
        :links="[{name:'Index', path:'/roles'}]"
    />

    <div class="bg-white h-screen shadow-lg rounded-lg mt-4 p-4">
      <div class="flex items-center justify-between">
        <p class="font-bold">Roles</p>
        <RouterLink to="/add-role"
                    class="px-2 py-1 rounded-md bg-primary-700 text-white flex items-center gap-2 hover:shadow-lg transition-all ease-in-out duration-300">
          <Icon name="solar:bolt-bold-duotone"/>
          <span class="text-xs font-semibold">Add</span>
        </RouterLink>
      </div>

      <div class="relative overflow-x-auto mt-5">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">
              Role Name
            </th>
            <th scope="col" class="px-6 py-3">
              Include Permissions
            </th>
            <th scope="col" class="px-6 py-3">
              Active Users
            </th>
            <th scope="col" class="px-6 py-3">
              Action
            </th>
          </tr>
          </thead>
          <transition-group name="fade" appear mode="out-in" tag="tbody">
            <template v-if="loading" v-for="n in 8" :key="n">
                <tr class="animate-pulse">
                  <td colspan="4" class="px-6 py-1">
                    <div class="h-12 bg-gray-200 rounded"></div>
                  </td>
                </tr>
            </template>
            <tr v-if="!loading && items.data.length" class="bg-white border-b" v-for="(item, index) in items?.data" :key="item.id"
                :style="{ transitionDelay: index * 0.1 + 's' }">
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ item?.name }}
              </th>
              <td class="px-6 py-4">
                {{ item?.permissions_count }}
              </td>
              <td class="px-6 py-4">
                <div class="flex -space-x-1">
                  <span class="uppercase border font-semibold text-xs bg-primary-400 p-1 rounded-full text-white w-7 h-7 flex items-center justify-center" v-for="user in item.users">{{ user.name?.substr(0, 2) }}</span>
                </div>
              </td>
              <td class="px-6 py-4">
                <div class="flex gap-3">
                  <RouterLink :to="`/edit-role/${item.id}`" class="p-1 rounded-md flex items-center justify-center bg-primary-100 text-primary-800 hover:bg-primary-300 transition-all ease-in-out">
                    <Icon name="solar:pen-line-duotone"/>
                  </RouterLink>
                  <DeleteButton v-if="item.is_delete" :path="`/v1/role/${item.id}`" @deleted="getAllRoles()"/>
                </div>
              </td>
            </tr>
          </transition-group>
        </table>
      </div>

    </div>


  </AppLayout>
</template>
<style>

</style>
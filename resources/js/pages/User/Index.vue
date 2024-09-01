<script setup>
import AppLayout from "@/components/Layouts/AppLayout.vue";
import Breadcrumbs from "@/components/Breadcrumbs.vue";
import {onMounted, ref} from "vue";
import DeleteButton from "../../components/DeleteButton.vue";
import useAxios from "../../composables/useAxios.js";

const {sendRequest, error, loading} = useAxios()


const items = ref([])

const getALlUsers = async () => {
  const res = await sendRequest({
    url: '/v1/user',
    method: 'GET'
  })
  items.value = res.data
}
const errorImage = (event) =>{
  console.log(event.target)
}


onMounted(() => getALlUsers())

</script>
<template>
  <AppLayout>

    <Breadcrumbs
        :item="{name:'Users', path:'/users', icon:'solar:users-group-rounded-bold-duotone'}"
        :links="[{name:'Index', path:'/users'}]"
    />

    <div class="bg-white h-screen shadow-lg rounded-lg mt-4 p-4">
      <div class="flex items-center justify-between">
        <p class="font-bold">Users</p>
        <RouterLink to="/add-user"
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
              User Information
            </th>
            <th scope="col" class="px-6 py-3">
              Role
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
                <div class="flex gap-4">
                  <img class="w-12 h-12 rounded-full object-contain" :src="item.avatar" @error="event => event.target.src=`https://ui-avatars.com/api/?name=${item.name}`" alt="">
                  <div>
                    <p class="text-sm font-bold text-primary-800">{{ item?.name }}</p>
                    <p class="text-xs font-semibold text-primary-400">{{ item?.email }}</p>
                  </div>
                </div>
              </th>
              <td class="px-6 py-4">
                 {{ item.roles[0]?.name }}
              </td>

              <td class="px-6 py-4">
                <div class="flex gap-2">
                  <DeleteButton  :path="`/v1/user/${item.id}`" @deleted="getALlUsers()"/>
                  <button  class="p-1 rounded-md flex items-center justify-center bg-primary-100 text-primary-900 hover:bg-primary-300 transition-all ease-in-out">
                    <Icon name="solar:pen-new-square-bold-duotone"/>
                  </button>
                  <button  class="p-1 rounded-md flex items-center justify-center bg-primary-100 text-primary-900 hover:bg-primary-300 transition-all ease-in-out">
                    <Icon name="solar:alt-arrow-right-broken"/>
                  </button>
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
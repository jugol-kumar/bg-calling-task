<script setup>
import {ref} from 'vue';
import {useAuthStore} from "../../stores/useAuthStore.js";

const activeLink = ref(null);
const setItem = (item) => activeLink.value = item
const {user} = useAuthStore();
const supperAdmin = ref(import.meta.env.VITE_APP_SUPPERADMIN)
const menus = ref([
  {
    name:'Dashboard',
    path:'/dashboard',
    icon:'solar:home-smile-angle-bold-duotone',
    can: ['dashboard.show']
  },
  {
    name:'ACL Management',
    icon:'solar:shield-user-bold-duotone',
    can: ['authorization.index', 'authorization.create'],
    submenu:[
      {
        name:'Roles',
        path:'/roles',
        can: ['authorization.index'],
      },
      {
        name:'Create Role',
        path:'/add-role',
        can: ['authorization.create'],
      }
    ]
  },
  {
    name:'Users',
    icon:'solar:users-group-rounded-bold-duotone',
    can: ['user.index', 'user.create'],
    submenu:[
      {
        name:'Users',
        path:'/users',
        can: ['user.index'],
      },
      {
        name:'Create User',
        path:'/add-user',
        can: ['user.create'],
      },
    ]
  },
  {
    name:'Settings',
    path:'/settings',
    icon:'solar:settings-bold-duotone',
    can: ['settings.show']
  },
])
</script>

<template>
  <div class="relative">
    <div class="bg-primary-800 py-5 mb-10">
      <p class="text-white text-center uppercase tracking-widest font-bold">BD Calling</p>
    </div>
    <ul class="flex flex-col">
      <template v-for="item in menus">
        <li class="sidebar-item" v-if="item?.submenu?.length && (user.roles[0]?.name === supperAdmin || item.can?.some(permission => user.can?.includes(permission)))">
          <div class="group flex items-center gap-3 rounded-lg transition-all ease-in-out duration-300 cursor-pointer relative"
               @click="setItem(activeLink === item.name ? null : item.name)">
            <Icon :name="item.icon" size="3" class="text-white" />
            <span class="text-white text-xs font-normal transition-all ease-in-out duration-300">{{ item.name }}</span>
            <div class="absolute top-1/2 -translate-y-1/2 right-2 transition-all  ease-in-out duration-300"
                 :class="{'rotate-90 ' : activeLink === item.name}">
              <Icon name="solar:double-alt-arrow-right-line-duotone" size="20"
                    class="text-white transition-all ease-in-out duration-300"/>
            </div>
          </div>
          <div class="overflow-hidden">
            <ul class="shop-links flex flex-col gap-4 pl-4 py-4" :class="{'shop-links--active' : activeLink === item.name}">
              <template v-for="menu in item?.submenu" >
                <li v-if="user.roles[0]?.name === supperAdmin || menu.can?.some(subPer => user.can?.includes(subPer))">
                  <RouterLink :to="menu.path" class="flex items-center gap-3 ">
                    <Icon name="solar:check-read-line-duotone" class="text-white"/>
                    <span class="text-sm text-white">{{ menu?.name }}</span>
                  </RouterLink>
                </li>
              </template>
            </ul>
          </div>
        </li>
        <li class="sidebar-item" v-else v-if="!item?.submenu?.length && (user.roles[0]?.name === supperAdmin || item.can?.some(permission => user.can?.includes(permission)))">
          <RouterLink :to="item.path" class="flex items-center gap-2">
            <Icon :name="item.icon" size="3" class="text-white" />
            <p class="text-white text-xs">{{ item?.name }}</p>
          </RouterLink>
        </li>
      </template>
    </ul>
  </div>
</template>

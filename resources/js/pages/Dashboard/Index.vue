<script setup>
    import AppLayout from "@/components/Layouts/AppLayout.vue";
    import {useAuthStore} from "@/stores/useAuthStore.js";
    import Chart from "@/components/Chart.vue"
    const {user} = useAuthStore()

</script>
<template>
    <AppLayout>
      <div class="py-4 px-6 flex flex-col gap-2 bg-primary-300 text-primary-500 mb-4">
        <h1 class="font-bold text-lg">Hello {{ user?.name }}</h1>
        <h1 class="font-semibold text-xs">WELCOME TO DASHBOARD</h1>
      </div>
      <div class="grid grid-cols-3 gap-4">
        <div class="col-span-1 relative px-6 py-4 bg-primary-300 overflow-hidden">
          <Icon name="solar:shield-user-bold-duotone" class="w-40 h-40 -top-10 -left-10 absolute text-primary-500 z-10"/>
          <div class="z-50 flex justify-between items-end ">
            <div class="z-10">
              <Icon name="solar:shield-user-bold-duotone" class="w-20 h-20 drop-shadow-2xl"/>
            </div>
            <div>
              <p class="text-2xl font-bold text-primary-800">8</p>
              <p class="text-2xl font-bold text-primary-800">Total Roles</p>
            </div>
          </div>
        </div>
        <div class="col-span-1 relative px-6 py-4 bg-primary-300 overflow-hidden">
          <Icon name="solar:users-group-rounded-bold-duotone" class="w-40 h-40 -top-10 -left-10 absolute text-primary-500 z-10"/>
          <div class="z-50 flex justify-between items-end ">
            <div class="z-10">
              <Icon name="solar:users-group-rounded-bold-duotone" class="w-20 h-20 drop-shadow-2xl"/>
            </div>
            <div>
              <p class="text-2xl font-bold text-primary-800">8</p>
              <p class="text-2xl font-bold text-primary-800">Total Users</p>
            </div>
          </div>
        </div>
        <div class="col-span-1 relative px-6 py-4 bg-primary-300 overflow-hidden">
          <Icon name="solar:check-read-bold-duotone" class="w-40 h-40 -top-10 -left-10 absolute text-primary-500 z-10"/>
          <div class="z-50 flex justify-between items-end ">
            <div class="z-10">
              <Icon name="solar:check-read-bold-duotone" class="w-20 h-20 drop-shadow-2xl"/>
            </div>
            <div>
              <p class="text-2xl font-bold text-primary-800">8</p>
              <p class="text-2xl font-bold text-primary-800">Total Permissions</p>
            </div>
          </div>
        </div>
      </div>
      <div class="h-screen mt-4 bg-primary-300">
        <Chart class="p-8 h-full"/>
      </div>
    </AppLayout>
</template>

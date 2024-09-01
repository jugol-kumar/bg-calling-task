<script setup>

import {onMounted, ref} from "vue";
import AppLayout from "@/components/Layouts/AppLayout.vue";
import useAxios from "@/composables/useAxios.js";
import LoadingButton from "@/components/LoadingButton.vue";
import Breadcrumbs from "@/components/Breadcrumbs.vue";
import Input from "../../components/Input.vue";
import {useToast} from "vue-toastification";
import { useRouter} from "vue-router";
const toast = useToast();
const {sendRequest, loading, error} = useAxios();
const router = useRouter()

let createRole = ref({
  roleName: "",
  selectedPermissions: [],
});
let updateRole = ref({
  roleName: "",
  selectedPermissions: [],
});

const errors = ref({})
const all_permissions = ref([])
const permissions = ref([])
let checkAllPermission = (e) => {
  createRole.value.selectedPermissions = [];
  if (e.target.checked) {
    for (let item in all_permissions.value) {
      createRole.value.selectedPermissions.push(all_permissions.value[item].name);
    }
    Object.entries(permissions.value).map((item, index) => document.getElementById(`checkgroup-${item[0]}`).checked = true);
  } else {
    Object.entries(permissions.value).map((item, index) => document.getElementById(`checkgroup-${item[0]}`).checked = false);
  }
}

let selectGroup = (groupName, event) => {
  if (event.target.checked) {
    for (let item in permissions.value[groupName]) {
      createRole.value.selectedPermissions.push(permissions.value[groupName][item].name);
    }
  } else {
    for (let item in permissions.value[groupName]) {
      createRole.value.selectedPermissions = createRole.value.selectedPermissions.filter(a => a !== permissions.value[groupName][item].name);
    }
  }

  if (all_permissions.value.length === createRole.value.selectedPermissions.length) {
    document.getElementById("checkAll").checked = true;
  } else {
    document.getElementById("checkAll").checked = false;
  }
}

let lastItemCheck = (event) => {
  if (all_permissions.value.length === createRole.value.selectedPermissions.length) {
    document.getElementById("checkAll").checked = true;
    let availableGroupVlaue = createRole.value.selectedPermissions.filter(a => a === event.target.value);
  } else {
    document.getElementById("checkAll").checked = false;
  }
}

const editRoleRef = ref(false);

const addNewRoleModal = () => {
  createRole.value = {}
  editRoleRef.value = null;
}
const loadGetAllPermissions = ref(false)
const getAllPermission = async () => {
  const res = await sendRequest({
    url: '/v1/permissions-for-create-roles',
    method: 'GET'
  }, loadGetAllPermissions)

  all_permissions.value = res?.data?.allPermissions
  permissions.value = res?.data?.groupPermissions
}


onMounted(() => {
  getAllPermission()
})

const loadCreateRole = ref(false)
const saveNewRole = async () => {
  const res = await sendRequest({
    url:'/v1/create-role',
    method:'POST',
    data:createRole.value
  }, loadCreateRole)

  createRole.value = {
    roleName: "",
    selectedPermissions: [],
  }
  toast.success(res?.data)

  await router.push('/roles')

}

</script>


<template>
  <AppLayout>

    <Breadcrumbs
        :item="{name:'Roles', path:'/roles', icon:'solar:shield-user-bold-duotone'}"
        :links="[{name:'Index', path:'/roles'}, {name:'Add Role', path:'/add-role'}]"
    />

    <div class="bg-white min-h-screen shadow-lg rounded-lg mt-4 p-4">
      <div class="flex items-center justify-between">
        <p class="font-bold">Create Role</p>
        <RouterLink to="/roles"
                    class="px-2 py-1 rounded-md bg-primary-700 text-white flex items-center gap-2 hover:shadow-lg transition-all ease-in-out duration-300">
          <Icon name="solar:arrow-left-line-duotone"/>
          <span class="text-xs font-semibold">Back</span>
        </RouterLink>
      </div>
      <TransitionGroup name="fade" appear mode="out-in">
        <div v-if="loadGetAllPermissions" id="addRoleForm" class="grid grid-cols-1 gap-4 mt-10">
          <div class="col-span-1">
            <div class="animate-pulse">
              <div class="h-6 bg-gray-300 rounded w-24 mb-2"></div>
              <div class="h-10 bg-gray-200 rounded"></div>
            </div>
          </div>
          <div class="col-span-1">
            <h4 class="mt-4 pt-2 text-lg font-semibold animate-pulse">
              <div class="h-6 bg-gray-300 rounded w-36 mb-2"></div>
            </h4>
            <div class="flex items-center animate-pulse">
              <div class="h-4 w-4 bg-gray-300 rounded"></div>
              <div class="ml-2 h-4 bg-gray-200 rounded w-20"></div>
            </div>
            <div class="overflow-x-auto mt-4">
              <table class="w-full text-left text-sm text-gray-500">
                <tbody>
                <tr class="border-b" v-for="index in 8" :key="index">
                  <td class="text-nowrap font-semibold w-1/2 text-gray-900 py-5 animate-pulse">
                    <div class="h-5 bg-gray-200 rounded w-16"></div>
                  </td>
                  <td class="py-5 w-1/5 animate-pulse">
                    <div class="flex items-center">
                      <div class="h-4 w-4 bg-gray-300 rounded"></div>
                    </div>
                  </td>
                  <td class="py-5 flex flex-col animate-pulse gap-3">
                    <div class="h-5 w-5 bg-gray-200 rounded" v-for="i in 4"></div>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-span-1 text-center mt-4">
            <div class="inline-flex justify-center py-2 px-4 bg-gray-300 rounded-md w-24 animate-pulse"></div>
            <div class="inline-flex justify-center py-2 px-4 bg-gray-200 rounded-md w-24 ml-2 animate-pulse"></div>
          </div>
        </div>
        <form v-else @submit.prevent="saveNewRole" class="grid grid-cols-1 gap-4 mt-10">
          <div class="col-span-1">
            <div class="w-full flex justify-between items-end gap-4">
              <Input
                  class="w-full"
                  label="Role Name"
                  labelName="Role Name"
                  :error="error?.response?.data?.errors?.roleName"
                  v-model="createRole.roleName"
                  :loading="loadCreateRole"
                  type="text"
                  required
                  placeholder="Enter role name"
              />

              <div class="w-max">
                <LoadingButton :isLoading="loadCreateRole" class="w-max text-sm my-0">
                  <div class="flex items-center gap-1">
                    <Icon name="solar:check-read-line-duotone"/>
                    <span>Save Role</span>
                  </div>
                </LoadingButton>
              </div>
            </div>
          </div>
          <div class="col-span-1">
            <h4 class="mt-4 pt-2 text-sm font-semibold">Role Permissions</h4>
            <div class="flex items-center">
              <input
                  class="form-check-input disabled:bg-primary-300 h-4 w-4 border-gray-300 rounded focus:outline-none focus:border-none focus:shadow-none focus:ring-0"
                  type="checkbox"
                  id="checkAll"
                  :disabled="loadCreateRole"
                  @change="checkAllPermission($event)"
                  label-name="permission"/>
              <label class="form-check-label ml-2 block text-sm text-gray-900" for="checkAll">Check All</label>
            </div>
            <span v-if="error?.response?.data?.errors?.selectedPermissions" class="text-xs text-red-500">{{error?.response?.data?.errors?.selectedPermissions[0]}}</span>

            <!-- Permission table -->
            <div class="overflow-x-auto mt-4">
              <table class="w-full text-left text-sm text-gray-500">
                <tbody>
                <tr class="border-b last:border-b-0" v-for="(module, index, i) in permissions" :key="module.id">
                  <td class="text-nowrap font-semibold text-gray-900 py-5">
                    {{ index }}
                  </td>
                  <td class="py-5">
                    <div class="flex items-center">
                      <input
                          class="form-check-input h-4 w-4 border-gray-300 disabled:bg-primary-300 rounded focus:outline-none focus:border-none focus:shadow-none focus:ring-0"
                          type="checkbox"
                          :disabled="loadCreateRole"
                          :id="`checkgroup-${index}`"
                          @change="selectGroup(index, $event)"
                          label-name="permission"
                      />
                      <label class="form-check-label ml-2 block text-sm text-gray-900"
                             :for="`checkgroup-${index}`"></label>
                    </div>
                  </td>
                  <td class="py-5">
                    <div :class="`manage-permission-${i}`">
                      <div class="flex items-center mb-2" v-for="(permission, index, j) in module" :key="permission.name">
                        <input
                            class="form-check-input h-4 w-4 border-gray-300 disabled:bg-primary-300 rounded focus:outline-none focus:border-none focus:shadow-none focus:ring-0"
                            type="checkbox"
                            :disabled="loadCreateRole"
                            :id="`userRole${i}_${index}`"
                            v-model="createRole.selectedPermissions"
                            :value="permission.name"
                            @change="lastItemCheck($event)"
                            label-name="permission"
                        />
                        <label class="form-check-label ml-2 block text-sm text-gray-900"
                               :for="`userRole${i}_${index}`">{{ permission.show_name }}</label>
                      </div>
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </form>
      </TransitionGroup>

    </div>
  </AppLayout>
</template>

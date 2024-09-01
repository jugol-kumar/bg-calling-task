<template>
  <nav class="flex">
    <ol class="inline-flex items-center">
      <li class="inline-flex items-center text-xs font-medium text-gray-700">
        <Icon :name="props?.item?.icon"/>

        <RouterLink v-if="props?.item?.path" :to="props?.item?.path" class="text-xs font-medium text-gray-700">
          {{ props?.item?.name }}
        </RouterLink>
        <span v-else class="ms-1">{{ props?.item?.name }}</span>
      </li>
      <li v-if="props.links?.length" v-for="link in props?.links">
        <div class="flex items-center">
          <Icon name="solar:alt-arrow-right-broken"/>
          <RouterLink v-if="link?.path" :to="link.path" class="text-xs font-medium text-gray-700">
            {{ link.name }}
          </RouterLink>
          <span v-else class="ms-1 text-xs">{{ link?.name }}</span>
        </div>
      </li>
    </ol>
  </nav>
</template>

<script setup>
const props = defineProps({
  links:Array,
  item:Object,
})
</script>
<script setup>
  const emit = defineEmits(['handleLogout'])
</script>

<template>
  <nav class="font-sans flex flex-col text-center sm:flex-row sm:text-left sm:justify-between py-4 px-20 bg-white shadow sm:items-baseline w-full">
    <div class="mb-2 sm:mb-0">
      <a href="#" class="text-2xl font-medium no-underline text-grey-darkest hover:text-brand">Logo</a>
    </div>
    <div>
      <a @click="$emit('handleLogout')" href="#" class="text-lg no-underline text-grey-darkest hover:text-brand ml-2">Sair</a>
    </div>
  </nav>
</template>
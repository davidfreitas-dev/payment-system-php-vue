<script setup>
  const emit = defineEmits(['handleLogout'])
</script>

<template>
  <nav class="flex flex-row justify-between items-center font-sans text-center py-4 px-5 sm:px-10 md:px-20 bg-white shadow sm:items-baseline w-full">
    <div>
      <RouterLink to="/" class="text-2xl font-medium no-underline text-grey-darkest hover:text-brand">Início</RouterLink>
    </div>
    <div>
      <a @click="$emit('handleLogout')" href="#" class="text-lg no-underline text-grey-darkest hover:text-brand ml-2">Sair</a>
    </div>
  </nav>
</template>
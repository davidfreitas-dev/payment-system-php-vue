<script setup>
  const emit = defineEmits(['handleLogout'])
</script>

<template>
  <header class="font-sans text-center bg-white shadow sm:items-baseline w-full">
    <nav class="flex flex-row justify-between items-center w-[95%] md:w-[80%] mx-auto h-14">
      <div>
        <RouterLink to="/" class="text-2xl font-medium no-underline text-grey-darkest hover:text-brand">Início</RouterLink>
      </div>
      <div>
        <a @click="$emit('handleLogout')" href="#" class="text-lg no-underline text-grey-darkest hover:text-brand ml-2">Sair</a>
      </div>
    </nav>
  </header>
</template>
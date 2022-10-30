<script setup>
  import { ref, onMounted, inject } from 'vue'
  
  const axios = inject('axios')

  const data = ref([])

  const getPayments = () => {
    axios
      .get('/payments')
      .then((response) => {
        data.value = response.data.data
        console.log(data.value)
      })
      .catch((err) => {
        console.log(err)
      })
  }

  onMounted(() => {
    getPayments()
  })
</script>

<template>
  <h1>Pagamentos</h1>
</template>
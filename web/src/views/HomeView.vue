<script setup>
  import { ref, inject, onMounted } from 'vue'
  import { useRouter } from 'vue-router'
  import { useSessionStore } from '@/stores/session'

  const axios = inject('axios')
  const router = useRouter()
  const storeSession = useSessionStore()

  const products = ref([])

  const getProducts = () => {    
    axios
      .get(`/products`)
      .then((response) => {
        if (response.data.status === 'success') {
          products.value = response.data.data
          console.log(products.value)
        }
      })
      .catch((err) => {
        console.log(err)
      })
  }

  const verifySession = () => {
    if (!storeSession.session.hasOwnProperty('token')) {
      return router.push('/login')
    }
    
    getProducts()
  }

  onMounted(() => {
    verifySession()
  })
</script>

<template>
    
</template>

<style scoped>

</style>
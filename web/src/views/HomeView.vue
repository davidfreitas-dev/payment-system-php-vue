<script setup>
  import { ref, inject, onMounted } from 'vue'
  import { useRouter } from 'vue-router'
  import { useSessionStore } from '@/stores/session'

  import ProductCard from '@/components/ProductCard.vue';

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
    <div class="container">
      <div v-for="product in products" class="p-3 w-[25%]">
        <ProductCard :product="product" />
      </div>
    </div>
</template>

<style scoped>
.container {
  @apply flex items-start flex-wrap mx-auto py-5
}
</style>
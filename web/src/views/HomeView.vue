<script setup>
  import { ref, inject, onMounted } from 'vue'
  import { useRouter } from 'vue-router'
  import { useSessionStore } from '@/stores/session'

  import ProductCard from '@/components/product/ProductCard.vue';

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
        }
      })
      .catch((err) => {
        console.log(err)
      })
  }

  const getAddresses = async () => {  
    const user = storeSession.session

    const results = await axios
      .get(`/addresses/${user.idperson}`)
      .then((response) => {
        return response.data.data
      })
      .catch((err) => {
        console.log(err)
      })

    return results
  }
  
  const setAddressToSession = (address) => {
    const json = sessionStorage.getItem('session')
    const obj = JSON.parse(json) || {}    
    let session = typeof obj === 'object' ? obj : {}
    
    session.address = address
    storeSession.setSession(session)
  }

  const verifyAddresses = async () => {
    const addresses = await getAddresses()

    if (Array.isArray(addresses) && addresses.length) {
      setAddressToSession(addresses[0])

      getProducts()
    } else {
      router.push('/address')
    }
  }

  const verifySession = () => {
    if (!storeSession.session.hasOwnProperty('token')) {
      return router.push('/login')
    } 

    verifyAddresses()
  }

  onMounted(() => {
    verifySession()
  })
</script>

<template>
    <h1 class="title">
      Nossos Produtos
    </h1>

    <div class="container">
      <div v-for="product in products" class="p-1.5 sm:p-2 w-[50%] sm:w-[33%] lg:w-[25%]">
        <ProductCard :product="product" />
      </div>
    </div>
</template>

<style scoped>
.title {
  @apply text-center text-2xl sm:text-3xl md:text-4xl font-bold pt-5 sm:pt-8
}
.container {
  @apply flex items-start flex-wrap mx-auto py-5 mb-10 w-[95%] lg:w-4/5
}
</style>
<script setup>
  import { ref, inject, onMounted } from 'vue'
  import { useRoute } from 'vue-router'
  import { useRouter } from 'vue-router'
  import { useSessionStore } from '@/stores/session'

  const route = useRoute()
  const router = useRouter()
  const storeSession = useSessionStore()
  const axios = inject('axios')

  const paymentDetails = ref({})

  const getPaymentDetails = () => {
    const id = route.params.id
    
    axios
      .get(`/payments/${id}`)
      .then((response) => {
        if (response.data.status === 'success') {
          paymentDetails.value = response.data.data
          console.log(paymentDetails.value)
        }
      })
      .catch((err) => {
        console.log(err)
      })
  }

  const verifySession = () => {
    if (storeSession.session.hasOwnProperty('token')) {
      return getPaymentDetails()
    }

    router.push('/login')
  }

  onMounted(() => {
    verifySession()
  })
</script>

<template>
  <h1>Detalhes do Pagamento: </h1>
</template>
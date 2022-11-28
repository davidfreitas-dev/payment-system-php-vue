<script setup>
  import { ref, inject, onMounted } from 'vue'
  import { useSessionStore } from '@/stores/session'
  import { usePaymentStore } from '@/stores/payment'
  import SpinnerLoader from '@/components/template/SpinnerLoader.vue';

  const axios = inject('axios')
  const storeSession = useSessionStore()
  const storePayment = usePaymentStore()

  const isLoading = ref(false)

  const transactionData = ref({})

  const handlePay = (paymentData) => {
    isLoading.value = true

    axios
      .post('/payment/pix', paymentData)
      .then((response) => {
        transactionData.value = response.data.data.transaction_data
      })
      .catch((err) => {
        console.log(err)
      })
      .finally(() => {
        isLoading.value = false
      });
  }

  const verifySession = () => {
    if (!storeSession.session.hasOwnProperty('token')) {
      return router.push('/login')
    }    

    handlePay(storePayment.data)
  }

  onMounted(() => {
    verifySession()
  })
</script>

<template>
  <h1>Status do Pagamento</h1>

  <SpinnerLoader v-if="isLoading" />
</template>
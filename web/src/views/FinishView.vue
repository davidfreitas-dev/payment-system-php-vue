<script setup>
  import { ref, inject, onMounted } from 'vue'
  import { useToast } from '@/use/useToast'
  import { useSessionStore } from '@/stores/session'
  import { usePaymentStore } from '@/stores/payment'
  import SpinnerLoader from '@/components/template/SpinnerLoader.vue';
  import ToastMessage from '@/components/template/ToastMessage.vue'

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

  const onClipboard = () => {
    handleToast('success', 'Copiado com sucesso!')
  }

  const { toast, toastData, handleToast } = useToast()
</script>

<template>
  <div class="pix flex flex-col items-center">
    <img
      v-if="transactionData.hasOwnProperty('qr_code_base64')"
      :src="`data:image/jpeg;base64,${transactionData.qr_code_base64}`"
      alt="QR Code de pagamento PIX"
      class="w-[70%] sm:w-[40%] lg:w-[25%] mt-10"
    >

    <input type="hidden" v-model="transactionData.qr_code" />

    <button
      v-if="transactionData.hasOwnProperty('qr_code')"
      @click="onClipboard"
      v-clipboard:copy="transactionData.qr_code"
      class="w-32 h-10 rounded-md text-white bg-brand"
    >
      Copiar Código
    </button>
  </div>

  <ToastMessage ref="toast" :toastData="toastData"/>

  <SpinnerLoader v-if="isLoading" />
</template>
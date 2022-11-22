<script setup>
    import { ref, inject, onMounted } from 'vue'
    import { useRouter } from 'vue-router'
    import { useSessionStore } from '@/stores/session'
    import { useCartStore } from '@/stores/cart'

    import CartList from '@/components/CartList.vue'
    import PaymentForm from '@/components/PaymentForm.vue'

    const router = useRouter()
    const axios = inject('axios')
    const storeSession = useSessionStore()
    const storeCart = useCartStore()

    const isLoading = ref(false)

    const verifySession = () => {
        if (!storeSession.session.hasOwnProperty('token')) {
            return router.push('/login')
        }        
    }

    const data = ref({})

    const handlePayment = (paymentMethod, creditCardData) => {
      const paymentData = {
        description: '',
        paymentMethod: paymentMethod,
        creditCardData: creditCardData,
        price: storeCart.total
      }

      handlePay(paymentData)
    }

    const handlePay = (paymentData) => {
        isLoading.value = true

        axios
            .post('/payment/pix', paymentData)
            .then((response) => {
                data.value = response.data.data.transaction_data
            })
            .catch((err) => {
              console.log(err)
            })
            .finally(() => {
              isLoading.value = false
            });
    }

    onMounted(() => {
        verifySession()
    })
</script>

<template>
    <main>
        <div class="flex flex-row w-5/6 mx-auto py-7">
          <CartList />
            
          <PaymentForm @onPay="handlePayment"/>
        </div>
    </main>
</template>
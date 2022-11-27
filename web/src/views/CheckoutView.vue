<script setup>
    import { onMounted } from 'vue'
    import { useRouter } from 'vue-router'
    import { useSessionStore } from '@/stores/session'
    import { usePaymentStore } from '@/stores/payment'
    import { useCartStore } from '@/stores/cart'

    import CartList from '@/components/checkout/CartList.vue'
    import PaymentForm from '@/components/checkout/PaymentForm.vue'

    const router = useRouter()
    const storeSession = useSessionStore()
    const storePayment = usePaymentStore()
    const storeCart = useCartStore()

    const verifySession = () => {
      if (!storeSession.session.hasOwnProperty('token')) {
        return router.push('/login')
      }        
    }

    const handlePayment = (paymentMethod, creditCardData) => {
      const paymentDescription = storeCart.items.length === 1 
        ? storeCart.items[0].desproduct
        : 'Produtos Variados'

      const paymentData = {
        description: paymentDescription,
        paymentMethod: paymentMethod,
        creditCardData: creditCardData,
        price: storeCart.total
      }

      storePayment.setData(paymentData)
      router.push('/finish')
    }

    onMounted(() => {
        verifySession()
    })
</script>

<template>
  <main>
    <div class="flex flex-col lg:flex-row w-full md:w-5/6 mx-auto py-7">
      <CartList />
        
      <PaymentForm @onPay="handlePayment"/>
    </div>
  </main>
</template>
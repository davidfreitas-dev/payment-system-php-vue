<script setup>
  import { ref, onMounted, inject } from 'vue'
  import { useRouter } from 'vue-router'
  import { useSessionStore } from '@/stores/session'
  
  const router = useRouter()
  const storeSession = useSessionStore()
  const axios = inject('axios')

  const verifySession = () => {
    if (storeSession.session.hasOwnProperty('token')) {
      return getPayments()
    }

    router.push('/login')
  }

  const payments = ref([])

  const getPayments = () => {
    axios
      .get('/payments')
      .then((response) => {
        if (response.data.status === 'success') {
          payments.value = response.data.data
        }
      })
      .catch((err) => {
        console.log(err)
      })
  }

  onMounted(() => {
    verifySession()
  })
</script>

<template>
  <div class="container w-4/5 mx-auto">    
    <div v-if="payments.length" class="overflow-x-auto relative shadow-md sm:rounded-md mt-7">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-white text-base uppercase bg-brand">
                <tr>
                    <th scope="col" class="py-3 px-6">
                        ID Pedido
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Data
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Valor
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Status
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Ações
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(payment, i) in payments" :key="i" class="bg-white border-b">
                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                        {{ payment.id }}
                    </th>
                    <td class="py-4 px-6">
                        <!-- {{ $filters.formatDate(payment.date_created) }} -->
                        {{ payment.date_created }}
                    </td>
                    <td class="py-4 px-6">
                        {{ payment.transaction_amount }}
                    </td>
                    <td class="py-4 px-6">
                        {{ payment.status }}
                    </td>
                    <td class="py-4 px-6">
                        <router-link :to="`/payments/${payment.id}`" class="font-medium text-brand hover:underline">Edit</router-link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div v-else class="text-center text-2xl font-medium mt-7">
      <span>Nenhum pedido encontrado</span>
    </div>
  </div>
</template>
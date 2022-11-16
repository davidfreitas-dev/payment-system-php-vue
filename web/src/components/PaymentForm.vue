<script setup>
  import { ref, reactive, onMounted } from 'vue'

  const paymentMethod = ref('')

  const creditCardData = reactive({
    name: '',
    number: '',
    expMonth: '',
    expYear: '',
    cvv: ''
  })

  const expirationMonths = ref([])

  const getExpMonths = () => {
    let count = 0

    while (count < 12) {
      count++
      expirationMonths.value.push(count < 10 ? '0' + count : count.toString())
    }
  }

  const expirationYears = ref([])

  const getExpYears = () => {
    let date = new Date();
    let count = (date.getFullYear() - 1).toString()

    while (count < 2030) {
      count++
      expirationYears.value.push(count.toString())
    }
  }

  onMounted(() => {
    getExpMonths()
    getExpYears()
  })

  const handlePay = () => {
    console.log('Método de pagamento: ', paymentMethod.value, 'Dados do Cartão: ', creditCardData)
  }
</script>

<template>
  <div class="flex flex-col justify-between gap-6 w-1/3 rounded-lg px-7 py-5 bg-light">
    <h1 class="text-2xl font-bold">Pagamento</h1>

    <div class="flex flex-col">
      <label class="text-dark-gray mb-2">Método de Pagamento:</label>

      <div class="flex items-center mb-2">
        <input
          v-model="paymentMethod"
          class="w-5 h-5 text-brand bg-gray-100 border-gray-300 focus:ring-brand"
          name="default-radio"
          type="radio"
          value="pix"
        >
        <label class="ml-2 text-sm font-medium text-dark">Pix</label>
      </div>
      
      <div class="flex items-center">
        <input
          v-model="paymentMethod"
          class="w-5 h-5 text-brand bg-gray-100 border-gray-300 focus:ring-brand"
          name="default-radio"
          type="radio"
          value="credit-card"
        >
        <label class="ml-2 text-sm font-medium text-dark">Cartão de Crédito</label>
      </div>
    </div>

    <div class="flex flex-col">
      <label class="text-dark-gray mb-2">Nome no Cartão:</label>
      <input
        v-model="creditCardData.name"
        class="block w-full rounded-md border border-solid focus:border-brand focus:outline-none transition ease-in-out py-2 px-3 mb-3"
        placeholder="Fulano de Tal"
        type="text"
      >

      <label class="text-dark-gray mb-2">Número do Cartão:</label>
      <input
        v-model="creditCardData.number"
        class="block w-full rounded-md border border-solid focus:border-brand focus:outline-none transition ease-in-out py-2 px-3"
        placeholder="**** **** **** ****"
        type="text"
      >
    </div>

    <div class="flex flex-row">
      <div class="flex flex-col w-2/3">
        <label class="text-dark-gray mb-2">Validade:</label>

        <div class="flex flex-row">
          <select
            v-model="creditCardData.expMonth"
            class="text-gray-900 text-sm rounded-lg block w-5/12 border border-solid focus:border-brand focus:outline-none transition ease-in-out p-2.5 mr-3"
          >
            <option v-for="expMonth in expirationMonths" :value="expMonth">{{ expMonth }}</option>
          </select>

          <select
            v-model="creditCardData.expYear"
            class="text-gray-900 text-sm rounded-lg block w-7/12 border border-solid focus:border-brand focus:outline-none transition ease-in-out p-2.5 mr-3"
          >
            <option v-for="expYears in expirationYears" :value="expYears">{{ expYears }}</option>
          </select>
        </div>
      </div>

      <div class="flex flex-col w-1/3">
        <label class="text-dark-gray mb-2">CVV:</label>
        <input v-model="creditCardData.cvv" type="text" placeholder="000" class="w-20 rounded-lg border border-solid focus:border-brand focus:outline-none transition ease-in-out py-2 px-3">
      </div>
    </div>

    <button
      @click="handlePay"
      class="flex flex-row justify-center items-center py-3 mb-2 w-full rounded font-medium text-lg text-light bg-brand hover:bg-success hover:shadow-lg transition-all ease-linear duration-100"
    >
      Pagar
    </button>
  </div>
</template>
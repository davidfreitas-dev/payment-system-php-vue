<script setup>
    import { ref, reactive, inject, onMounted } from 'vue'
    import { useRouter } from 'vue-router'
    import { useSessionStore } from '@/stores/session'
    import InputForm from '@/components/form/InputForm.vue'
    import ButtonForm from '../components/form/ButtonForm.vue'
    import DotsLoader from '@/components/DotsLoader.vue'

    const router = useRouter()
    const axios = inject('axios')
    const storeSession = useSessionStore()

    const isLoading = ref(false)

    const product = reactive({
        description: '',
        price: null
    })

    const verifySession = () => {
        if (!storeSession.session.hasOwnProperty('token')) {
            return router.push('/login')
        }        
    }

    const data = ref({})

    const handlePay = () => {
        isLoading.value = true

        product.price = parseFloat(product.price)

        axios
            .post('/payment/pix', product)
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
        <div class="header bg-brand text-white text-xl font-medium rounded-t-md py-3 px-5 mt-7 mx-auto w-4/5">
          Pagamento com PIX
        </div>

        <div class="container mx-auto border-x-2 border-b-2 rounded-b-md py-5 px-3 w-4/5">
          <div class="content flex flex-row justify-between content-center">
            <div class="form px-5 mt-3 w-1/3">
              <InputForm 
                v-model="product.description" 
                :type="'text'" 
                :label="'Nome do Produto'"
                :placeholder="'Ex.: TV Samsung 4K'"
              />

              <InputForm 
                v-model="product.price" 
                :type="'number'" 
                :label="'Valor do Produto'"
                :placeholder="'100,00'"
              />

              <ButtonForm 
                :text="'Pagar'"
                @onClickButton="handlePay" 
              />
            </div>

            <div class="image flex flex-col justify-center w-1/3">
              <img
                class="mx-auto w-2/4"
                alt="Logo PIX"
                src="../assets/img/pix-logo.png"
              />

              <span class="mx-auto text-5xl">+</span>

              <img
                class="mx-auto w-2/5"
                alt="Logo Mercado Pago"
                src="../assets/img/mercado-pago-logo.png"
              />
            </div>

            <div class="checkout flex flex-col justify-center w-1/3">
              <img 
                v-if="data.hasOwnProperty('qr_code_base64') && !isLoading"
                :src="`data:image/jpeg;base64,${data.qr_code_base64}`"
                alt="QR Code de pagamento PIX"
                class="w-2/3 m-auto"
              >

              <DotsLoader
                v-if="isLoading"
                :size="'20'"
                class="m-auto"
              />
            </div>
          </div>
        </div>
    </main>
</template>

<style scoped>

</style>
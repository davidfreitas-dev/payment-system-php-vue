<script setup>
  import { ref, reactive, inject, watch } from 'vue'
  import { useToast } from '@/use/useToast'
  import { useRouter } from 'vue-router'
  import { useSessionStore } from '@/stores/session'
  import HeadingForm from '@/components/login/HeadingForm.vue';
  import InputForm from '@/components/login/InputForm.vue';
  import ButtonForm from '@/components/login/ButtonForm.vue';
  import ToastMessage from '@/components/template/ToastMessage.vue';

  const router = useRouter()
  const axios = inject('axios')
  const storeSession = useSessionStore()

  const address = reactive({
    addressId: '',
    personId: '',
    addressName: '',
    addressNumber: '',
    aliasAddress: '',
    complement: '',
    district: '',
    city: '',
    state: '',
    zipcode: ''
  })

  const blockFields = ref(true)

  watch(
    () => address.zipcode,
    (zipcode) => {
      if (zipcode.length > 7) {
        getAddress()

        blockFields.value = false
      } else {
        blockFields.value = true
      }
    }
  )

  const handleFill = (data) => {
    address.addressName = data.logradouro
    address.district = data.bairro
    address.city = data.localidade
    address.state = data.uf
    address.zipcode = data.cep
  }

  const isLoading = ref(false)

  const getAddress = () => {
    isLoading.value = true

    axios
      .post('/getbycep', { cep: address.zipcode })
      .then((response) => {
        if (response.data.status === 'success') {
          handleFill(response.data.data)
        } else {
          handleToast(response.data.status, response.data.data)                   
        }                
      })
      .finally(() => {
        isLoading.value = false
      });
  }

  const saveAddress = (address) => {
    isLoading.value = true

    axios
      .post('/address/add', address)
      .then((response) => {
        if (response.data.status === 'success') {
          handleToast(response.data.status, response.data.data)

          setTimeout(() => {
            router.push('/')
          }, 1000);
        } else {
          handleToast(response.data.status, response.data.data)                   
        }                
      })
      .finally(() => {
        isLoading.value = false
      });
  }

  const validateAddress = () => {
    if (!address.zipcode 
        || !address.addressName 
        || !address.addressNumber 
        || !address.district 
        || !address.city 
        || !address.state
    ) return handleToast("error", "Preencha todos os capos marcados com asterisco(*) e tente novamente.") 
    
    const user = storeSession.session

    address.personId = user.idperson
    address.addressId = 0
    address.zipcode = address.zipcode.replace('-', '')

    saveAddress(address)
  }

  const { toast, toastData, handleToast } = useToast()
</script>

<template>
  <div class="container">            
      <div class="form">
          <HeadingForm :text="'Endereço'" />

          <div>
              <InputForm 
                  v-model="address.zipcode" 
                  :type="'text'" 
                  :label="'CEP*'"
                  :placeholder="'00000-000'"
              />
          </div>

          <div>
              <InputForm 
                  v-model="address.addressName" 
                  :type="'text'" 
                  :label="'Endereço*'"
                  :placeholder="'Seu melhor endereço'"
                  :disabled="blockFields"
              />
          </div>

          <div>
              <InputForm 
                  v-model="address.addressNumber" 
                  :type="'text'" 
                  :label="'Número*'"
                  :placeholder="'Número'"
                  :disabled="blockFields"
              />
          </div>

          <div>
              <InputForm 
                  v-model="address.complement" 
                  :type="'text'" 
                  :label="'Complemento'"
                  :placeholder="'Complemento'"
                  :disabled="blockFields"
              />
          </div>

          <div>
              <InputForm 
                  v-model="address.district" 
                  :type="'text'" 
                  :label="'Bairro*'"
                  :placeholder="'Bairro'"
                  :disabled="blockFields"
              />
          </div>

          <div>
              <InputForm 
                  v-model="address.city" 
                  :type="'text'" 
                  :label="'Cidade*'"
                  :placeholder="'Cidade'"
                  :disabled="blockFields"
              />
          </div>

          <div>
              <InputForm 
                  v-model="address.state" 
                  :type="'text'" 
                  :label="'Estado*'"
                  :placeholder="'Estado'"
                  :disabled="blockFields"
              />
          </div>

          <ButtonForm 
              :text="'Salvar'" 
              :is-loading="isLoading" 
              @onClickButton="validateAddress" 
          />
      </div>
  </div>

  <ToastMessage ref="toast" :toastData="toastData"/>
</template>

<style scoped>
.container {
  @apply w-full sm:w-[70%] mx-auto mb-10
}
.form {
    @apply px-7 mt-12 md:px-10
}
.form div {
    @apply my-5
}
</style>
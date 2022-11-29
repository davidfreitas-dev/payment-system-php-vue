<script setup>
  import { ref, reactive, inject, onMounted } from 'vue'
  import { useToast } from '@/use/useToast'
  import { useSessionStore } from '@/stores/session'
  import ToastMessage from '../components/template/ToastMessage.vue';

  const axios = inject('axios')
  const storeSession = useSessionStore()

  const isLoading = ref(false)

  const address = reactive({
    addressName: '',
    addressNumber: '',
    aliasAddress: '',
    complement: '',
    district: '',
    city: '',
    state: '',
    zipcode: ''
  })

  const handleFill = (data) => {
    address.addressName = data.logradouro
    address.district = data.bairro
    address.city = data.localidade
    address.state = data.uf
    address.zipcode = data.cep
  }

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

  onMounted(() => {
    getAddress()
  })

  const { toast, toastData, handleToast } = useToast()
</script>

<template>
  <ToastMessage ref="toast" :toastData="toastData"/>
</template>
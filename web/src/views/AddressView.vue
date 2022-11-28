<script setup>
  import { ref, reactive, inject, onMounted } from 'vue'
  import { useToast } from '@/use/useToast'
  import { useSessionStore } from '@/stores/session'

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
    zipcode: '02169000'
  })

  const getAddress = () => {
    isLoading.value = true

    axios
      .post('/getbycep', { cep: address.zipcode })
      .then((response) => {
        if (response.data.status === 'success') {
          console.log(response.data.data)
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

<template></template>
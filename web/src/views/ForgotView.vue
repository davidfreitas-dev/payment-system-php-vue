<script setup>
    import { ref, inject } from 'vue'
    import { useToast } from '@/use/useToast'
    import { useRouter } from 'vue-router'
    
    import ImageForm from '../components/login/ImageForm.vue'
    import HeadingForm from '../components/login/HeadingForm.vue'
    import InputForm from '../components/login/InputForm.vue'
    import ButtonForm from '../components/login/ButtonForm.vue'
    import ToastMessage from '@/components/template/ToastMessage.vue'

    const router = useRouter()
    const axios = inject('axios')

    const isLoading = ref(false)

    const formData = ref({
        desemail: ''
    })

    const validateEmail = (email) => {
        const re = /\S+@\S+\.\S+/;
        return re.test(email);
    }

    const handleRecovery = () => {
        isLoading.value = true

        axios
            .post('/forgot', formData.value)
            .then((response) => {
                if (response.data.status === 'success') {
                    handleToast('success', response.data.data)
                } else {
                    handleToast('error', response.data.data)                  
                }
            })
            .finally(() => {
                isLoading.value = false
            });
    }

    const handleValidate = () => {
        if (!formData.value.desemail) {
            return handleToast('error', 'Informe seu email')
        }

        if (!validateEmail(formData.value.desemail)) {
            return handleToast('error', 'Formato de e-mail inválido')
        }

        handleRecovery()
    }

    const { toast, toastData, handleToast } = useToast()
</script>

<template>
    <section>
        <ImageForm />

        <div class="container">            
            <div class="form">
                <HeadingForm :text="'Recuperação de Conta'" />

                <div>
                    <InputForm 
                        v-model="formData.desemail" 
                        :type="'email'" 
                        :label="'Seu e-mail'"
                        :placeholder="'johndoe@example.com'"
                        @onKeyupEnter="handleValidate"
                    />
                </div>

                <ButtonForm 
                    :text="'Enviar'" 
                    :is-loading="isLoading" 
                    @onClickButton="handleValidate" 
                />
            </div>

            <div class="footer">
                Já possui uma conta?
                <router-link
                    class="text-brand ml-1"
                    to="/login"
                >
                    Entrar
                </router-link>
            </div>  
        </div>
    </section>

    <ToastMessage ref="toast" :toastData="toastData"/>
</template>

<style scoped>
section {
    @apply flex flex-row
}
.container {
    @apply flex flex-col h-screen max-w-none w-full md:w-2/5 lg:p-10 
}
.form {
    @apply px-7 mt-12 md:px-10
}
.form div {
    @apply my-5
}
.footer {
    @apply flex flex-row justify-center mb-7 mt-auto lg:mb-0 text-dark-gray
}
</style>
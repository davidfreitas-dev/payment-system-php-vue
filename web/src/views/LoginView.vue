<script setup>
    import { ref, inject } from 'vue'
    import { useToast } from '@/use/useToast'
    import { useRouter } from 'vue-router'
    import { useSessionStore } from '@/stores/session'
    
    import ImageForm from '../components/login/ImageForm.vue'
    import HeadingForm from '../components/login/HeadingForm.vue'
    import InputForm from '../components/login/InputForm.vue'
    import ButtonForm from '../components/login/ButtonForm.vue'
    import ToastMessage from '../components/template/ToastMessage.vue'

    const router = useRouter()
    const axios = inject('axios')
    const storeSession = useSessionStore()

    const isLoading = ref(false)

    const formData = ref({
        deslogin: '',
        despassword: ''
    })

    const handleLogin = () => {
        isLoading.value = true

        axios
            .post('/login', formData.value)
            .then((response) => {
                if (response.data.status === 'success') {
                    storeSession.setSession(response.data.data)
                    router.push('/')
                } else {
                    handleToast(response.data.status, response.data.data)
                }                
            })
            .finally(() => {
                isLoading.value = false
            });
    }

    const handleValidate = () => {
        if (!formData.value.deslogin) {
            return handleToast('error', 'Informe seu login')
        }

        if (!formData.value.despassword) {
            return handleToast('error', 'Informe sua senha')
        }

        handleLogin()
    }

    const { toast, toastData, handleToast } = useToast()
</script>

<template>
    <section>
        <ImageForm />

        <div class="container">
            <div class="form">
                <HeadingForm :text="'Bem-vindo de volta!'" />

                <div>
                    <InputForm 
                        v-model="formData.deslogin" 
                        :type="'text'" 
                        :label="'Nome de usuário ou E-mail'"
                        :placeholder="'johndoe@email.com'"
                    />
                </div>

                <div>
                    <InputForm 
                        v-model="formData.despassword" 
                        :type="'password'" 
                        :label="'Sua senha'"
                        :placeholder="'**********'"
                        @onKeyupEnter="handleValidate"
                    />
                </div>

                <ButtonForm 
                    :text="'Entrar'" 
                    :is-loading="isLoading" 
                    @onClickButton="handleValidate" 
                />                
            </div>

            <router-link
              class="text-dark-gray hover:text-brand pt-5 mx-auto"
              to="/forgot"
            >
                Esqueci minha senha
            </router-link>

            <div class="footer">
                Ainda não possui uma conta?
                <router-link
                  class="text-brand ml-1"
                  to="/register"
                >
                    Cadastre-se
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
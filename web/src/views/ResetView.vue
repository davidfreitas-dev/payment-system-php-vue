<script setup>
    import { ref, inject, onMounted } from 'vue'
    import { useToast } from '@/use/useToast'
    import { useRoute, useRouter } from 'vue-router' 
    
    import ImageForm from '../components/login/ImageForm.vue'
    import HeadingForm from '../components/login/HeadingForm.vue'
    import InputForm from '../components/login/InputForm.vue'
    import ButtonForm from '../components/login/ButtonForm.vue'
    import ToastMessage from '../components/template/ToastMessage.vue'

    const router = useRouter()
    const route = useRoute()    
    const code = ref('')

    code.value = route.query.code;

    const isValid = ref(false)
    const isLoading = ref(false)

    const axios = inject('axios')

    const validForgotDecrypt = () => {
        isLoading.value = true

        axios
            .post('/forgot/token', { code: code.value })
            .then((response) => {
                if (response.data.hasOwnProperty('status') && response.data.status === 'error') {
                    isValid.value = false
                } else { 
                    isValid.value = true                   
                }                
            })
            .finally(() => {
                isLoading.value = false
            });
    }

    onMounted(() => {
        validForgotDecrypt()
    })

    const formData = ref({
        code: code.value,
        despassword: ''
    })

    const setNewPassword = () => {
        axios
            .post('/forgot/reset', formData.value)
            .then((response) => {
                if (response.data.status === 'success') {
                    handleToast(response.data.status, response.data.data)

                    setTimeout(() => {
                        router.push('/login')
                    }, 2000);
                } else {
                    handleToast(response.data.status, response.data.data)    
                }                
            });
    }

    const handleValidate = () => {
        const numbers = /([0-9])/;
        const letters = /([a-zA-Z])/;
        const specialChar = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;

        if (!formData.value.despassword) {
            return handleToast('error', 'Informe sua senha')
        }

        if (formData.value.despassword.length < 8) {
            return handleToast('error', 'Sua senha deve ter no mínimo 8 caracteres')
        }

        if (!formData.value.despassword.match(numbers) || !formData.value.despassword.match(letters) || !formData.value.despassword.match(specialChar)) {
            return handleToast('error', 'Sua senha deve conter um mínimo de uma letra, um número e um caractere especial')
        }

        setNewPassword()
    }

    const { toast, toastData, handleToast } = useToast()
</script>

<template>
    <section>
        <ImageForm />

        <div class="container">            
            <div v-if="isValid" class="form">
                <HeadingForm :text="'Recuperação de Conta'" />

                <div>
                    <InputForm 
                        v-model="formData.despassword" 
                        :type="'password'" 
                        :label="'Sua nova senha'"
                        :placeholder="'**********'"
                        @onKeyupEnter="handleValidate"
                    />
                </div>

                <ButtonForm 
                    :text="'Salvar'"
                    :is-loading="isLoading" 
                    @onClickButton="handleValidate" 
                />
            </div>

            <span v-else class="msg">
                <h1>Invalid Token :(</h1>
            </span>
            
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
.msg {
    @apply my-auto font-bold text-center text-4xl text-dark
}
</style>
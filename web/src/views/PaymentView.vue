<script setup>
    import { ref, inject, onMounted } from 'vue'
    import { useRouter } from 'vue-router'
    import { useSessionStore } from '@/stores/session'
    import SpinnerLoader from '@/components/SpinnerLoader.vue'

    const router = useRouter()
    const axios = inject('axios')
    const storeSession = useSessionStore()

    const verifySession = () => {
        if (storeSession.session.hasOwnProperty('token')) {
            return handlePay()
        }

        router.push('/login')
    }

    const data = ref({})

    const handlePay = () => {
        axios
            .post('/payment/pix')
            .then((response) => {
                data.value = response.data.transaction_data
                console.log(data.value);
            });
    }

    onMounted(() => {
        verifySession()
    })
</script>

<template>
    <main>
        <div class="welcome">
            <h1>Pagamento via Pix</h1>

            <img 
                v-if="data.hasOwnProperty('qr_code_base64')"
                :src="`data:image/jpeg;base64,${data.qr_code_base64}`"
                alt="QR Code de pagamento PIX"
                class="h-3/6"
            >

            <SpinnerLoader v-else :size="'20'" class="py-10" />

            <div class="actions flex flex-col gap-2">
                <button>Copiar código</button>
                <button @click="$router.go(-1)">
                    Voltar
                </button>
            </div>
        </div>
    </main>
</template>

<style scoped>
.welcome {
    @apply w-full h-screen flex flex-col justify-center items-center
}
.welcome h1 {
    @apply text-3xl font-semibold
}
.actions button:first-child {
    @apply py-3 p-10 rounded font-medium text-white bg-brand hover:bg-success hover:shadow-lg transition-all ease-linear duration-100
}
.actions button:last-child {
    @apply py-3 p-10 rounded font-medium hover:bg-dark-gray hover:text-white hover:shadow-lg transition-all ease-linear duration-100
}
</style>
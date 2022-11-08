<script setup>
    import { onMounted } from 'vue'
    import { useRouter } from 'vue-router'
    import { useSessionStore } from '@/stores/session'

    const router = useRouter()
    const storeSession = useSessionStore()

    const verifySession = () => {
        if (!storeSession.session.hasOwnProperty('token')) {
            router.push('/login')
        }        
    }

    onMounted(() => {
        verifySession()
    })
</script>

<template>
    
</template>

<style scoped>

</style>
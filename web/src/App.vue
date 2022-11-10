<script setup>
  import { ref, computed, onMounted } from 'vue';
  import { RouterView } from 'vue-router' 
  import { useRouter } from 'vue-router'
  import { useSessionStore } from '@/stores/session'
  import NavBar from '@/components/NavBar.vue';
  import LogoutModal from '@/components/LogoutModal.vue';

  const session = ref({})

  const getSession = () => {
    const json = sessionStorage.getItem('session')
    const obj = JSON.parse(json) || {}
    session.value = typeof obj === 'object' ? obj : {}
  }

  const storeSession = useSessionStore()

  const router = useRouter()

  const verifySession = () => {
    if (!storeSession.session.hasOwnProperty('token')) {
      router.push('/login')
    }        
  }

  onMounted(() => {
    getSession()
    storeSession.setSession(session.value)
  })

  const isView = computed(() => {
    return storeSession.session.hasOwnProperty('token')
  })

  const modal = ref(null)
    
  const toggleModal = () => {
    modal.value?.toggleModal()
  } 

  const logout = (response) => {
    toggleModal()

    if (response) {
      storeSession.destroySession()
      verifySession()
    }
  }
</script>

<template>
  <NavBar v-if="isView" @handleLogout="toggleModal" />
  <RouterView />
  <LogoutModal ref="modal" @onModal="logout" />
</template>

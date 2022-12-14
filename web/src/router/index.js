import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'
import ForgotView from '../views/ForgotView.vue'
import ResetView from '../views/ResetView.vue'
import AddressView from '../views/AddressView.vue'
import CheckoutView from '../views/CheckoutView.vue'
import PaymentsView from '../views/PaymentsView.vue'
import FinishView from '../views/FinishView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView
    },
    {
      path: '/forgot',
      name: 'forgot',
      component: ForgotView
    },
    {
      path: '/forgot/reset',
      name: 'reset',
      component: ResetView
    },
    {
      path: '/address',
      name: 'address',
      component: AddressView
    },
    {
      path: '/checkout',
      name: 'checkout',
      component: CheckoutView
    },
    {
      path: '/payments',
      name: 'payments',
      component: PaymentsView
    },
    {
      path: '/finish',
      name: 'finish',
      component: FinishView
    }
  ]
})

export default router

<script setup>
  import { useRouter } from 'vue-router'
  import { useCartStore } from '@/stores/cart'

  const router = useRouter()
  const storeCart = useCartStore()

  const props = defineProps(['product'])

  const addItem = () => {
    storeCart.addItem(props.product)
    router.push('/checkout')
  }
</script>

<template>
    <div class="bg-white border-gray-200 rounded-lg border shadow-md">
        <a href="#">
            <img
              class="rounded-t-lg"
              alt=""
              :src="`src/assets/img/products/${product.idproduct}.png`"
            >
        </a>
        <div class="p-5">
            <a href="#">
                <h5 class="text-2xl font-bold tracking-tight text-gray-900">
                  {{ $filters.currencyBRL(product.vlprice) }}
                </h5>
            </a>
            <p class="mb-3 font-medium text-gray-700 line-clamp-2">
              {{ product.desproduct }}
            </p>
            <a @click="addItem" class="inline-flex items-center py-2 px-3 text-sm font-medium cursor-pointer text-center text-white bg-brand rounded-lg hover:bg-brand focus:ring-4 focus:outline-none focus:ring-blue-300">
                Comprar
                <svg
                  class="ml-2 -mr-1 w-4 h-4"
                  aria-hidden="true"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    clip-rule="evenodd"
                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                    fill-rule="evenodd"
                  ></path>
                </svg>
            </a>
        </div>
    </div>
</template>
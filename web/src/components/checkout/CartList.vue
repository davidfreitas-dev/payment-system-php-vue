<script setup>
  import { useRouter } from 'vue-router'
  import { useCartStore } from '@/stores/cart'
    
  const router = useRouter()
  const storeCart = useCartStore()

  const getTotalItem = (item) => {
    return item.qty * item.vlprice
  }

  const removeItem = (item) => {
    storeCart.removeItem(item)
  }
</script>

<template>
  <div class="w-full lg:w-2/3">
    <div class="w-full bg-white px-4 pb-7 lg:p-10">
      <div class="flex justify-between border-b pb-5"> <!-- header -->
        <h1 class="font-semibold text-xl sm:text-2xl">Carrinho</h1>
        <h2 class="font-semibold text-xl sm:text-2xl">{{ storeCart.items.length }} Itens</h2>
      </div>

      <div class="hidden sm:flex mt-10 mb-5"> <!-- table header -->
        <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">Produto</h3>
        <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5">Quantidade</h3>
        <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5">Preço</h3>
        <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5">Total</h3>
      </div>

      <div v-for="item in storeCart.items" class="flex items-center hover:bg-gray-100 -mx-3 px-3 py-5"> <!-- table content -->
        <div class="flex w-full sm:w-2/5"> <!-- product -->
          <div class="w-56"> <!-- image -->
            <img class="h-24 rounded-md" :src="`src/assets/img/products/${item.idproduct}.png`" alt="Imagem do Produto">
          </div>
          
          <div class="flex flex-col justify-between w-full -ml-7 sm:-ml-5"> <!-- deails -->
            <span class="font-bold text-sm line-clamp-3">{{ item.desproduct }}</span>
            <span class="sm:hidden font-bold text-sm text-brand">{{ $filters.currencyBRL(item.vlprice) }}</span> <!-- price -->
            <span class="flex flex-row justify-between">
              <a
                @click="removeItem(item)"
                class="font-semibold text-danger text-xs cursor-pointer"
              >
                Remove
              </a>

              <div class="flex justify-center sm:hidden"> <!-- control quantity -->
                <svg
                  class="fill-current text-gray-600 cursor-pointer w-3"
                  viewBox="0 0 448 512"
                >
                  <path d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"/>
                </svg>

                <input class="mx-2 text-center w-8 bg-transparent" type="text" value="1">

                <svg
                  class="fill-current text-gray-600 cursor-pointer w-3"
                  viewBox="0 0 448 512"
                >
                  <path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"/>
                </svg>
              </div>
            </span>
          </div>
        </div>
        
        <div class="hidden sm:flex justify-center w-1/5"> <!-- control quantity -->
          <svg
            class="fill-current text-gray-600 cursor-pointer w-3"
            viewBox="0 0 448 512"
          >
            <path d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"/>
          </svg>

          <input class="mx-2 text-center w-8 bg-transparent" type="text" value="1">

          <svg
            class="fill-current text-gray-600 cursor-pointer w-3"
            viewBox="0 0 448 512"
          >
            <path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"/>
          </svg>
        </div>

        <span class="hidden sm:block text-center w-1/5 font-semibold text-sm">{{ $filters.currencyBRL(item.vlprice) }}</span> <!-- price -->

        <span class="hidden sm:block text-center w-1/5 font-semibold text-sm">{{ $filters.currencyBRL(getTotalItem(item)) }}</span> <!-- total -->
      </div>

      <div class="flex flex-row justify-between items-center mt-10"> <!-- table footer -->
        <a @click="router.go(-1)" class="flex font-semibold text-brand text-sm cursor-pointer">    
          <svg
            class="fill-current mr-2 text-brand w-4"
            viewBox="0 0 448 512"
          >
            <path d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"/>
          </svg>
          Continuar Comprando
        </a>

        <span class="text-xl font-semibold">Total: {{ $filters.currencyBRL(storeCart.total) }}</span>
      </div>
    </div>
  </div>
</template>
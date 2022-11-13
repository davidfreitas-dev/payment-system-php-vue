<script setup>
  const props = defineProps(['product'])

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
        <div class="p-3 md:p-5">
            <a href="#">
                <h5 class="mb-2 text-sm md:text-lg font-bold tracking-tight text-gray-900 line-clamp-2">
                  {{ product.desproduct }}
                </h5>
            </a>
            <p class="mb-3 font-normal text-gray-700">
              <!-- Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order. -->
            </p>
            <a href="#" class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-brand rounded-lg hover:bg-brand focus:ring-4 focus:outline-none focus:ring-blue-300">
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
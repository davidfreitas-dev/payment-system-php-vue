import { defineStore } from 'pinia'

export const useCartStore = defineStore('cart', {
  state: () => {
    return { 
      cart: { 
        items: [], 
        total: 0.00 
      } 
    }
  },
  actions: {
    addItem(item) {
      this.cart.items.push(item)
    },
    removeItem(item) {
      console.log(item)
    },
  },
})
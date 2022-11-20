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
  getters: {
    cartTotal(state) {
      const cartTotal = state.cart.items
        .map(item => item.qty * parseFloat(item.vlprice))
        .reduce((total, current) => total + current, 0)

      return cartTotal
    },
  },
  actions: {
    addItem(item) {
      item.qty = 1
      this.cart.items.push(item)
    },
    removeItem(item) {
      const index = this.cart.items.indexOf(item)
      this.cart.items.splice(index, 1)
    },
  },
})
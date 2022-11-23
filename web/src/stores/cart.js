import { defineStore } from 'pinia'

export const useCartStore = defineStore('cart', {
  state: () => {
    return { 
      items: []
    }
  },
  getters: {
    total(state) {
      const total = state.items
        .map(item => item.qty * parseFloat(item.vlprice))
        .reduce((total, current) => total + current, 0)

      return total
    },
  },
  actions: {
    addItem(item) {
      item.qty = 1
      this.items.push(item)
    },
    removeItem(item) {
      const index = this.items.indexOf(item)
      this.items.splice(index, 1)
    },
  },
})
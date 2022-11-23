import { defineStore } from 'pinia'

export const usePaymentStore = defineStore('payment', {
  state: () => {
    return { 
      data: {}
    }
  },
  actions: {
    setData(data) {
      this.data = data
    }
  },
})
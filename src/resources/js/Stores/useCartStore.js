import { defineStore } from 'pinia';

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: [],
    delivery: 0,

  }),
  persist: true,
  getters: {
    totalItems() {
      return this.items.length;
    },
    totalPrice() {
      return this.items.reduce((total, item) => total + item.price_public, 0);
    },
    totalPricewDel() {
      return this.items.reduce((total, item) => total + item.price_public, 0) + parseFloat(this.delivery);
    },
  },
  actions: {
    addToCart(item) {
      //add aleatory and unique uid to item
      item._id = this._generateUUID();
      
      this.items.push(item);
    },
    removeItem(_id) {

      const index = this.items.findIndex((i) => i._id === _id);
      if (index !== -1) {
        this.items.splice(index, 1);
      }
      
      // const index = this.items.findIndex((i) => i.id === item.id);
      // if (index !== -1) {
      //   this.items.splice(index, 1);
      // }
    },
    clearCart() {
      this.items = [];
      this.delivery = 0;
    },
    _generateUUID() {
      return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
      });
    },
    setDelivery(amount) {
      this.delivery = parseFloat(amount);
    },
    
  },
});

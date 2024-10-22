import { defineStore } from 'pinia';

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: [],
    delivery: 0,
    cart_id: null,

  }),
  persist: true,
  getters: {
    totalItems() {
      return this.items.length;
    },
    totalPrice() {
      return this.items.reduce((total, item) => total + item.sale_price, 0);
    },
    totalPricewDel() {
      return this.items.reduce((total, item) => total + item.sale_price, 0) + parseFloat(this.delivery);
    },
  },
  actions: {
    addToCart(item) {
      //add aleatory and unique uid to item
      item._id = this._generateUUID();
      
      this.items.push(item);
      
      // Generate cart_id if it is null and this is the first item
      if (this.cart_id === null && this.items.length === 1) {
        this.cart_id = this._generateUUID();
      }
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
      // Clear cart_id when the cart is cleared
      this.cart_id = null;      
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

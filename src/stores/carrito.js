import { defineStore } from 'pinia';

function obtenerCarrito() {
  const carritoLocalStorage = localStorage.getItem('carritoLS');
  return carritoLocalStorage ? JSON.parse(carritoLocalStorage) : [];
}

export const useCarritoStore = defineStore('carrito', {
  state: () => ({
    carritoLS: obtenerCarrito(),
  }),
  actions: {
    // Función para agregar un elemento al carrito
    agregarAlCarrito(item) {
      this.carritoLS.push(item);
      this.guardarCarritoEnLocalStorage();
    },
    // Otras acciones relacionadas con el carrito si las tienes
    // ...
    guardarCarritoEnLocalStorage() {
      localStorage.setItem('carritoLS', JSON.stringify(this.carritoLS));
    },
  },
});
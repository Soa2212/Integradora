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
        const index = this.carritoLS.findIndex((producto) => producto.Articulo === item.Articulo);
  
        if (index !== -1) {
          // Si el producto ya existe, actualizamos la cantidad del producto
          this.carritoLS[index].cantidad = item.cantidad;
        } else {
          // Si el producto no existe, lo agregamos al carrito
          this.carritoLS.push(item);
        }
  
        this.guardarCarritoEnLocalStorage();
      },
    // Otras acciones relacionadas con el carrito si las tienes
    // ...
    guardarCarritoEnLocalStorage() {
      localStorage.setItem('carritoLS', JSON.stringify(this.carritoLS));
    },
  },
});
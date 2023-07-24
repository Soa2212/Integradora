import { defineStore } from "pinia";

function obtenerCarrito() {
  const carritoLocalStorage = localStorage.getItem("carritoLS");
  return carritoLocalStorage ? JSON.parse(carritoLocalStorage) : [];
}

export const useCarritoStore = defineStore("carrito", {
  state: () => ({
    carritoLS: obtenerCarrito(),
  }),
  actions: {
    // Función para agregar un elemento al carrito
    agregarAlCarrito1(item) {
      const index = this.carritoLS.findIndex(
        (producto) => producto.Articulo === item.Articulo
      );

      if (index !== -1) {
        // Si el producto ya existe, actualizamos la cantidad del producto
        this.carritoLS[index].cantidad = item.cantidad;
      } else {
        // Si el producto no existe, lo agregamos al carrito
        this.carritoLS.push(item);
      }

      this.guardarCarritoEnLocalStorage();
    },
    agregarAlCarrito(item) {
      const index = this.carritoLS.findIndex(
        (producto) => producto.Articulo === item.Articulo
      );

      if (index !== -1) {
        // Si el producto ya existe, actualizamos la cantidad del producto
        const cantidadTotal = this.carritoLS[index].cantidad + item.cantidad;
        if (cantidadTotal <= this.carritoLS[index].stock) {
          this.carritoLS[index].cantidad = cantidadTotal;
        } else {
          // Si la cantidad a agregar supera el stock, establecemos la cantidad igual al stock
          this.carritoLS[index].cantidad = this.carritoLS[index].stock;
        }
      } else {
        // Si el producto no existe, lo agregamos al carrito
        this.carritoLS.push(item);
      }

      this.guardarCarritoEnLocalStorage();
    },
    // Otras acciones relacionadas con el carrito si las tienes
    // ...
    guardarCarritoEnLocalStorage() {
      localStorage.setItem("carritoLS", JSON.stringify(this.carritoLS));
    },
    // Función para eliminar un artículo del carrito por su ID
    eliminarDelCarrito(id) {
      const index = this.carritoLS.findIndex(
        (producto) => producto.Articulo === id
      );

      if (index !== -1) {
        // Si encontramos el artículo con la ID, lo eliminamos del carrito
        this.carritoLS.splice(index, 1);
        this.guardarCarritoEnLocalStorage(); // Guardamos los cambios en el LocalStorage
      }
    },
    eliminarTodoDelLocalStorage() {
      //Variable para eliminar todo el carrito
      localStorage.removeItem("carritoLS");
    },
  },
});

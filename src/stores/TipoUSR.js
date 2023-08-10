import { defineStore } from "pinia";

function obtenerTipo() {
  const TipoLocalStorage = localStorage.getItem("TipoLS");
  return TipoLocalStorage ? JSON.parse(TipoLocalStorage) : "";
}

export const useTipoStore = defineStore("Tipo", {
  state: () => ({
    TipoLS: obtenerTipo(),
  }),
  actions: {
    guardarTipoEnLocalStorage(nuevoTipo) {
      this.TipoLS = nuevoTipo;
      localStorage.setItem("TipoLS", JSON.stringify(this.TipoLS));
    },
    eliminarTipoDelLocalStorage() {
      this.TipoLS = "";
      localStorage.removeItem("TipoLS");
    },
  },
  getters: {
    tieneTipo() {
      // Cambia la condición para comprobar si Tipo es diferente de "normal"
      return this.TipoLS == "admin" || "dueño";
    },
  },
});

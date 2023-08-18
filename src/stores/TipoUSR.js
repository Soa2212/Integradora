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
      return this.TipoLS === "admin" || this.TipoLS === "dueño";
    },
    tieneTipoU() {
      return this.TipoLS === "normal";
    },
    getTipoLS() {
      return this.TipoLS;
    }
  },
});

import { defineStore } from "pinia";

function obtenerOrdIDLS() {
  const IdLocalStorage = localStorage.getItem("OrdIDLS");
  return IdLocalStorage ? JSON.parse(IdLocalStorage) : "";
}

export const useOrdIDStore = defineStore("OrdID", {
  state: () => ({
    OrdIDLS: obtenerOrdIDLS(),
  }),
  actions: {
    guardarOrdIDLSEnLocalStorage(nuevoId) {
      this.OrdIDLS = nuevoId;
      localStorage.setItem("OrdIDLS", JSON.stringify(this.OrdIDLS));
    },
    eliminarOrdIDLSDelLocalStorage() {
      this.OrdIDLS = "";
      localStorage.removeItem("OrdIDLS");
    },
  },
  getters: {
    getOrdIDLS() {
      return this.OrdIDLS;
    },
  },
});

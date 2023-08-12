import { defineStore } from "pinia";

function obtenerId() {
  const IdLocalStorage = localStorage.getItem("IdLS");
  return IdLocalStorage ? JSON.parse(IdLocalStorage) : "";
}

export const useIdStore = defineStore("Id", {
  state: () => ({
    IdLS: obtenerId(),
  }),
  actions: {
    guardarIdEnLocalStorage(nuevoId) {
      this.IdLS = nuevoId;
      localStorage.setItem("IdLS", JSON.stringify(this.IdLS));
    },
    eliminarIdDelLocalStorage() {
      this.IdLS = "";
      localStorage.removeItem("IdLS");
    },
  },
  getters: {
    getIdLS() {
      return this.IdLS;
    },
  },
});

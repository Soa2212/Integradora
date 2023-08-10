import { defineStore } from "pinia";

function obtenerEmail() {
  const EmailLocalStorage = localStorage.getItem("EmailLS");
  return EmailLocalStorage ? JSON.parse(EmailLocalStorage) : "";
}

export const useEmailStore = defineStore("Email", {
  state: () => ({
    EmailLS: obtenerEmail(),
  }),
  actions: {
    guardarEmailEnLocalStorage(nuevoEmail) {
      this.EmailLS = nuevoEmail;
      localStorage.setItem("EmailLS", JSON.stringify(this.EmailLS));
    },
    eliminarEmailDelLocalStorage() {
      this.EmailLS = "";
      localStorage.removeItem("EmailLS");
    },
  },
  getters: {
    getEmailLS() {
      return this.EmailLS;
    },
  },
});

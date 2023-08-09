import { defineStore } from "pinia";

function obtenerToken() {
  const TokenLocalStorage = localStorage.getItem("TokenLS");
  return TokenLocalStorage ? JSON.parse(TokenLocalStorage) : "";
}

export const useTokenStore = defineStore("Token", {
  state: () => ({
    TokenLS: obtenerToken(),
  }),
  actions: {
    guardarTokenEnLocalStorage(nuevoToken) {
      this.TokenLS = nuevoToken;
      localStorage.setItem("TokenLS", JSON.stringify(this.TokenLS));
    },
    eliminarTokenDelLocalStorage() {
      this.TokenLS = "";
      localStorage.removeItem("TokenLS");
    },
  },
  getters: {
    tieneToken() {
      return this.TokenLS.length > 0;
    },
  },
});

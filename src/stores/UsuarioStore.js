import { defineStore } from "pinia";
import { ref } from 'vue';

export const useUsuarioStore = defineStore('UsuarioStore', () => {
    const usuario = ref({correo: null, _token: null});

    // Cargar datos del usuario del almacenamiento local al crear el store
    const savedUser = JSON.parse(localStorage.getItem('user'));
    if (savedUser) {
        usuario.value = savedUser;
    }

    function closeSession() {
        localStorage.removeItem('user');
        usuario.value = {correo: null, _token: null};
    }

    function setUser(user) {
        const updatedUser = {...usuario.value, ...user};
        localStorage.setItem('user', JSON.stringify(updatedUser));
        usuario.value = updatedUser;
    }

    return { usuario, closeSession, setUser };
}, { persist: true });

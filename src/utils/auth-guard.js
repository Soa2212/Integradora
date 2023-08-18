import { useTipoStore } from "@/stores/TipoUSR";
import { useTokenStore } from "@/stores/TokenUser"; // Importa tu tienda de tokens

export function isAdmin(to, from, next) {
  const TipoUSR = useTipoStore();
  const Token = useTokenStore();
  const Admin = computed(() => TipoUSR.tieneTipo);
  
  const currentUser = Token.tieneToken(); // Usa la función tieneToken() de tu tienda de tokens
  const tieneTipoAdmin = TipoUSR.tieneTipo(); // Utiliza la función tieneTipo() para verificar si el usuario es admin o dueño

  if (currentUser && tieneTipoAdmin) {
    next();
  } else {
    next("/HomeView");
  }
}

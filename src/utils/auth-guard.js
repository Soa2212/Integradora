import { useTipoStore } from "@/stores/TipoUSR";
import { useTokenStore } from "@/stores/TokenUser";

export function isAdmin(to, from, next) {
  const TipoUSR = useTipoStore();

  const tokenStore = useTokenStore();
  const tieneToken = tokenStore.tieneToken;
  const tieneTipoAdmin = TipoUSR.tieneTipo;

  if (tieneToken && tieneTipoAdmin) {
    next();
  } else {
    next("/HomeView");
  }
}


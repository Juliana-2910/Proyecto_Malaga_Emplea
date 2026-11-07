{{-- AVISOS PAGINAS --}}
    {{-- AVISO VERDE: MENSAJE EXITO --}}
        @if (session('success'))
            <div role="alert"
                style="display:flex;align-items:center;justify-content:space-between;gap:16px;padding:12px 16px;border-radius:12px;border:1px solid #BBF7D0;background:#F0FDF4;color:#15803D;font-size:14px;box-shadow:0 1px 2px rgba(0,0,0,0.05)">
                <div style="display:flex;align-items:center;gap:12px">
                    <span style="width:32px;height:32px;border-radius:999px;background:#DCFCE7;display:flex;align-items:center;justify-content:center;flex:0 0 auto">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="size-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12.75l6 6 9-13.5" /></svg>
                    </span>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" aria-label="Cerrar aviso" onclick="this.closest('[role=alert]').remove()"
                        style="border:none;background:transparent;color:#16A34A;cursor:pointer;display:flex;padding:4px">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <script>
                document.querySelectorAll('[role="alert"]').forEach((aviso) => {
                    setTimeout(() => {
                        aviso.remove();
                    }, 3000);
                });
            </script>
            @endif

    {{-- AVISO AMARILLO: MENSAJES ADVERTENCIA O ERRORES --}}
        @if (session('error'))
            <div role="alert"
                style="display:flex;align-items:center;justify-content:space-between;gap:16px;padding:12px 16px;border-radius:12px;border:1px solid #FEF08A;background:#FEFCE8;color:#A16207;font-size:14px;box-shadow:0 1px 2px rgba(0,0,0,0.05)">
                <div style="display:flex;align-items:center;gap:12px">
                    <span style="width:32px;height:32px;border-radius:999px;background:#FEF9C3;display:flex;align-items:center;justify-content:center;flex:0 0 auto">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="size-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                    </span>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" aria-label="Cerrar aviso" onclick="this.closest('[role=alert]').remove()"
                        style="border:none;background:transparent;color:#CA8A04;cursor:pointer;display:flex;padding:4px">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <script>
                document.querySelectorAll('[role="alert"]').forEach((aviso) => {
                    setTimeout(() => {
                        aviso.remove();
                    }, 3000);
                });
            </script>
        @endif

    {{-- AVISO ROJO: MENSAJE DE ELIMINACIÓN --}}
        @if (session('eliminar'))
            <div role="alert"
                style="display:flex;align-items:center;justify-content:space-between;gap:16px;padding:12px 16px;border-radius:12px;border:1px solid #FECACA;background:#FEF2F2;color:#B42318;font-size:14px;box-shadow:0 1px 2px rgba(0,0,0,0.05)">
                <div style="display:flex;align-items:center;gap:12px">
                    <span style="width:32px;height:32px;border-radius:999px;background:#FEE2E2;display:flex;align-items:center;justify-content:center;flex:0 0 auto">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9.5 4h5a1 1 0 011 1v2h-7V5a1 1 0 011-1z" /></svg>
                    </span>
                    <span>{{ session('eliminar') }}</span>
                </div>
                <button type="button" aria-label="Cerrar aviso" onclick="this.closest('[role=alert]').remove()"
                        style="border:none;background:transparent;color:#B42318;cursor:pointer;display:flex;padding:4px">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <script>
                document.querySelectorAll('[role="alert"]').forEach((aviso) => {
                    setTimeout(() => {
                        aviso.remove();
                    }, 3000);
                });
            </script>
        @endif

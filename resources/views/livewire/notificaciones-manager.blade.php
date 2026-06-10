<div>
    <h2 class="titulo">Gesti&oacute;n de Notificaciones</h2>

    @if($mensaje)
        <div style="background-color: {{ $tipoMensaje === 'error' ? '#f8d7da' : '#d4edda' }}; color: {{ $tipoMensaje === 'error' ? '#721c24' : '#155724' }}; border: 1px solid {{ $tipoMensaje === 'error' ? '#f5c6cb' : '#c3e6cb' }}; padding: 10px; margin-bottom: 15px; border-radius: 4px; display: flex; justify-content: space-between; align-items: center;">
            <span>{{ $mensaje }}</span>
            <a href="#" wire:click.prevent="limpiarMensaje" style="font-size:16px; font-weight:bold; text-decoration:none; color:inherit;">&times;</a>
        </div>
    @endif

    @if($editId !== null)
        <fieldset style="border:2px solid #8b0000;border-radius:6px;padding:10px;margin-bottom:15px;">
            <legend style="color:#000;font-weight:bold;font-style:italic;padding:0 5px;">{{ $editId ? 'Editar' : 'Nueva' }} Notificaci&oacute;n</legend>

            <table width="100%" cellpadding="5" cellspacing="0" style="font-size:13px;">
                <tr>
                    <td width="120" style="font-weight:bold;">T&iacute;tulo:</td>
                    <td><input type="text" wire:model="titulo" style="width:80%;padding:4px;" placeholder="T&iacute;tulo de la notificaci&oacute;n"></td>
                </tr>
                <tr>
                    <td style="font-weight:bold;vertical-align:top;">Mensaje:</td>
                    <td><textarea wire:model="mensajeTexto" rows="3" style="width:80%;padding:4px;" placeholder="Mensaje opcional..."></textarea></td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Tipo:</td>
                    <td>
                        <select wire:model="tipo" style="width:auto;">
                            <option value="info">Informaci&oacute;n (azul)</option>
                            <option value="warning">Advertencia (amarillo)</option>
                            <option value="success">&Eacute;xito (verde)</option>
                            <option value="danger">Urgente (rojo)</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Destinatario:</td>
                    <td>
                        <select wire:model="destinatario" style="width:auto;">
                            <option value="estudiante">Estudiantes</option>
                            <option value="todos">Todos los usuarios</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">URL de acci&oacute;n:</td>
                    <td>
                        <input type="text" wire:model="accion_url" style="width:80%;padding:4px;" placeholder="Ej: /proyectos/gestion">
                        <div style="font-size:10px;color:#888;margin-top:2px;">Ruta a la que ir&aacute; el usuario al hacer clic (opcional)</div>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Texto del bot&oacute;n:</td>
                    <td>
                        <input type="text" wire:model="accion_texto" style="width:80%;padding:4px;" placeholder="Ej: Subir mi proyecto">
                        <div style="font-size:10px;color:#888;margin-top:2px;">Texto del bot&oacute;n de acci&oacute;n (opcional)</div>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">Activo:</td>
                    <td><input type="checkbox" wire:model="activo" style="width:auto;height:auto;"></td>
                </tr>
            </table>

            <div style="margin-top:10px;text-align:right;">
                <button type="button" wire:click="cancel" class="cm-btn cm-btn-secondary cm-btn-sm">Cancelar</button>
                <button type="button" wire:click="save" class="cm-btn cm-btn-success cm-btn-sm" style="margin-left:8px;">Guardar</button>
            </div>
        </fieldset>
    @else
        <div style="margin-bottom:10px;">
            <button type="button" wire:click="create" class="cm-btn cm-btn-primary cm-btn-sm">+ Nueva Notificaci&oacute;n</button>
        </div>
    @endif

    <table width="100%" border="1" cellpadding="5" cellspacing="0"
        style="border-collapse:collapse;border-color:#bbb;font-size:11px;">
        <thead>
            <tr style="background-color:#8bb2b7;color:#000;font-weight:bold;">
                <th width="5%">N&deg;</th>
                <th width="25%">T&iacute;tulo</th>
                <th width="15%">Tipo</th>
                <th width="10%">Destinatario</th>
                <th width="8%">Activo</th>
                <th width="27%">Acci&oacute;n</th>
                <th width="10%">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($notificaciones as $noti)
                <tr style="background-color:{{ $loop->iteration % 2 == 0 ? '#E0E0E0' : '#FFF' }};" valign="top">
                    <td align="center">{{ $loop->iteration }}</td>
                    <td style="font-weight:bold;">{{ $noti->titulo }}</td>
                    <td align="center">
                        <span style="display:inline-block;padding:2px 8px;border-radius:4px;font-size:10px;font-weight:600;
                            {{ $noti->tipo === 'danger' ? 'background:#f8d7da;color:#721c24;' : '' }}
                            {{ $noti->tipo === 'warning' ? 'background:#fff3cd;color:#856404;' : '' }}
                            {{ $noti->tipo === 'success' ? 'background:#d4edda;color:#155724;' : '' }}
                            {{ $noti->tipo === 'info' ? 'background:#d1ecf1;color:#0c5460;' : '' }}">
                            {{ ucfirst($noti->tipo) }}
                        </span>
                    </td>
                    <td align="center">{{ ucfirst($noti->destinatario) }}</td>
                    <td align="center">
                        <input type="checkbox" wire:click="toggleActivo({{ $noti->id }})" {{ $noti->activo ? 'checked' : '' }}>
                    </td>
                    <td>
                        @if($noti->accion_url)
                            <div style="font-size:10px;">
                                <b>URL:</b> {{ $noti->accion_url }}
                                @if($noti->accion_texto)
                                    <br><b>Texto:</b> {{ $noti->accion_texto }}
                                @endif
                            </div>
                        @else
                            <span style="color:#999;">Sin acci&oacute;n</span>
                        @endif
                    </td>
                    <td align="center">
                        <button type="button" wire:click="edit({{ $noti->id }})" class="cm-btn cm-btn-secondary cm-btn-sm" style="font-size:10px;">Editar</button>
                        <button type="button" wire:click="delete({{ $noti->id }})" class="cm-btn cm-btn-danger cm-btn-sm" style="font-size:10px;" onclick="return confirm('Eliminar?')">Eliminar</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" align="center" style="padding:15px;color:#888;font-style:italic;">No hay notificaciones.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:10px;">
        {{ $notificaciones->links() }}
    </div>

    <style>
        .cm-btn { display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; padding: 0.55rem 0.95rem; font-size: 0.92rem; font-weight: 600; border: 1px solid transparent; cursor: pointer; transition: background-color 0.2s ease, transform 0.2s ease; text-decoration: none; }
        .cm-btn:hover { transform: translateY(-1px); }
        .cm-btn-primary { background: #19692e; border-color: #154f26; color: #fff; }
        .cm-btn-secondary { background: #f4f4f4; border: 1px solid #c2c2c2; color: #222; }
        .cm-btn-success { background: #198754; border-color: #166f43; color: #fff; }
        .cm-btn-danger { background: #c82333; border-color: #a71d2a; color: #fff; }
        .cm-btn-sm { padding: 0.35rem 0.75rem; font-size: 0.85rem; }
    </style>
</div>

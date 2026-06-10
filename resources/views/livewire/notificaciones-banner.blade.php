<div>
    @foreach($notificaciones as $noti)
        @php
            $bg = match($noti->tipo) {
                'danger' => '#f8d7da',
                'warning' => '#fff3cd',
                'success' => '#d4edda',
                default => '#d1ecf1',
            };
            $border = match($noti->tipo) {
                'danger' => '#f5c6cb',
                'warning' => '#ffc107',
                'success' => '#c3e6cb',
                default => '#bee5eb',
            };
            $textColor = match($noti->tipo) {
                'danger' => '#721c24',
                'warning' => '#856404',
                'success' => '#155724',
                default => '#0c5460',
            };
        @endphp
        <div style="background:{{ $bg }};border:1px solid {{ $border }};border-radius:6px;padding:10px 14px;margin-bottom:10px;display:flex;align-items:flex-start;gap:10px;">
            <div style="flex:1;">
                <div style="font-weight:bold;font-size:13px;color:{{ $textColor }};">{{ $noti->titulo }}</div>
                @if($noti->mensaje)
                    <div style="font-size:12px;color:{{ $textColor }};margin-top:3px;">{{ $noti->mensaje }}</div>
                @endif
                @if($noti->accion_url)
                    <div style="margin-top:6px;">
                        <a href="{{ $noti->accion_url }}"
                           style="display:inline-block;padding:5px 12px;border-radius:4px;font-size:12px;font-weight:600;text-decoration:none;
                                  {{ $noti->tipo === 'danger' ? 'background:#721c24;color:#fff;' : '' }}
                                  {{ $noti->tipo === 'warning' ? 'background:#856404;color:#fff;' : '' }}
                                  {{ $noti->tipo === 'success' ? 'background:#155724;color:#fff;' : '' }}
                                  {{ $noti->tipo === 'info' ? 'background:#0c5460;color:#fff;' : '' }}">
                            {{ $noti->accion_texto ?? 'Ir ahora' }}
                        </a>
                    </div>
                @endif
            </div>
            <button type="button" wire:click="cerrar({{ $noti->id }})"
                    style="background:none;border:none;font-size:18px;cursor:pointer;color:{{ $textColor }};padding:0;line-height:1;">&times;</button>
        </div>
    @endforeach
</div>

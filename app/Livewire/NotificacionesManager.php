<?php

namespace App\Livewire;

use App\Models\Notificacion;
use Livewire\Component;

class NotificacionesManager extends Component
{
    public string $mensaje = '';
    public string $tipoMensaje = 'success';

    public $editId = null;
    public string $titulo = '';
    public string $mensajeTexto = '';
    public string $tipo = 'info';
    public string $accion_url = '';
    public string $accion_texto = '';
    public string $destinatario = 'estudiante';
    public bool $activo = true;

    public function limpiarMensaje(): void
    {
        $this->mensaje = '';
    }

    public function resetForm(): void
    {
        $this->editId = null;
        $this->titulo = '';
        $this->mensajeTexto = '';
        $this->tipo = 'info';
        $this->accion_url = '';
        $this->accion_texto = '';
        $this->destinatario = 'estudiante';
        $this->activo = true;
    }

    public function create(): void
    {
        $this->resetForm();
    }

    public function edit($id): void
    {
        $noti = Notificacion::findOrFail($id);
        $this->editId = $noti->id;
        $this->titulo = $noti->titulo;
        $this->mensajeTexto = $noti->mensaje ?? '';
        $this->tipo = $noti->tipo;
        $this->accion_url = $noti->accion_url ?? '';
        $this->accion_texto = $noti->accion_texto ?? '';
        $this->destinatario = $noti->destinatario;
        $this->activo = $noti->activo;
    }

    public function cancel(): void
    {
        $this->editId = null;
    }

    public function save(): void
    {
        $this->validate([
            'titulo' => 'required|string|max:255',
            'mensajeTexto' => 'nullable|string|max:2000',
            'tipo' => 'required|in:info,warning,success,danger',
            'accion_url' => 'nullable|string|max:500',
            'accion_texto' => 'nullable|string|max:100',
            'destinatario' => 'required|in:estudiante,todos',
            'activo' => 'boolean',
        ]);

        $data = [
            'titulo' => trim($this->titulo),
            'mensaje' => trim($this->mensajeTexto) ?: null,
            'tipo' => $this->tipo,
            'accion_url' => trim($this->accion_url) ?: null,
            'accion_texto' => trim($this->accion_texto) ?: null,
            'destinatario' => $this->destinatario,
            'activo' => $this->activo,
        ];

        if ($this->editId) {
            Notificacion::findOrFail($this->editId)->update($data);
            $this->tipoMensaje = 'success';
            $this->mensaje = 'Notificación actualizada.';
        } else {
            Notificacion::create($data);
            $this->tipoMensaje = 'success';
            $this->mensaje = 'Notificación creada.';
        }

        $this->editId = null;
    }

    public function toggleActivo($id): void
    {
        $noti = Notificacion::findOrFail($id);
        $noti->update(['activo' => !$noti->activo]);
    }

    public function delete($id): void
    {
        Notificacion::findOrFail($id)->delete();
        $this->tipoMensaje = 'success';
        $this->mensaje = 'Notificación eliminada.';
    }

    public function render()
    {
        $notificaciones = Notificacion::orderByDesc('id')->paginate(20);

        return view('livewire.notificaciones-manager', [
            'notificaciones' => $notificaciones,
        ]);
    }
}

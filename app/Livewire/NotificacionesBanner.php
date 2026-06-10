<?php

namespace App\Livewire;

use App\Models\Notificacion;
use Livewire\Component;

class NotificacionesBanner extends Component
{
    public array $dismissedIds = [];

    public function cerrar($id): void
    {
        $this->dismissedIds[] = (int) $id;
    }

    public function render()
    {
        $user = auth()->user();
        if (!$user) {
            return view('livewire.notificaciones-banner', ['notificaciones' => collect()]);
        }

        $isStudent = $user->hasRole('estudiante');

        $query = Notificacion::where('activo', true)->orderByDesc('id');

        if ($isStudent) {
            $query->where(function ($q) {
                $q->where('destinatario', 'estudiante')
                    ->orWhere('destinatario', 'todos');
            });
        } else {
            $query->where('destinatario', 'todos');
        }

        $notificaciones = $query->get();

        if (!empty($this->dismissedIds)) {
            $notificaciones = $notificaciones->reject(fn ($n) => in_array($n->id, $this->dismissedIds));
        }

        return view('livewire.notificaciones-banner', [
            'notificaciones' => $notificaciones,
        ]);
    }
}

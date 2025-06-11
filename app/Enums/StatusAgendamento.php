<?php

namespace App\Enums;

enum StatusAgendamento: string
{
    case Confirmado = 'confirmado';
    case Cancelado = 'cancelado';
    case Atendido = 'atendido';

    public function label(): string
    {
        return match ($this) {
            self::Cancelado => 'Cancelado',
            self::Confirmado => 'Confirmado',
            self::Atendido => 'Atendido',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Confirmado => 'bg-blue-600',
            self::Cancelado => 'bg-yellow-500',
            self::Atendido => 'bg-green-600',
        };
    }

    public static function orderedCases(): array
    {
        $order = ['cancelado', 'confirmado', 'atendido'];

        return collect(self::cases())
            ->sortBy(fn($case) => array_search($case->value, $order))
            ->values()
            ->all();
    }
}

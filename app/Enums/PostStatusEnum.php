<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PostStatusEnum: string implements HasLabel, HasColor
{
    case Draft      = 'draft';
    case Reviewing  = 'reviewing';
    case Published  = 'published';
    case Rejected   = 'rejected';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft         => 'Draft',
            self::Reviewing     => 'Reviewing',
            self::Published     => 'Published',
            self::Rejected      => 'Rejected',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Draft         => 'gray',
            self::Reviewing     => 'info',
            self::Published     => 'success',
            self::Rejected      => 'danger',
        };
    }
}

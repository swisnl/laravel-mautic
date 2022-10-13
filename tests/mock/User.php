<?php

namespace Swis\Laravel\Mautic\Tests\mock;

use Illuminate\Database\Eloquent\Model;
use Swis\Laravel\Mautic\SynchronizesWithMautic;
use Swis\Laravel\Mautic\SynchronizesWithMauticTrait;

class User extends Model implements SynchronizesWithMautic
{
    use SynchronizesWithMauticTrait;

    protected $fillable = [
        'email',
        'name',
        'mautic_id',
    ];

    public function toMauticArray(): array
    {
        return [
            'email' => $this->email,
            'name' => $this->name,
        ];
    }

    public function getMauticType(): string
    {
        return 'contacts';
    }
}

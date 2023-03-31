<?php

declare(strict_types=1);

namespace Training\Infrastructure\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameModel extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $primaryKey = 'uuid';

    protected $table = 'games';

    protected $fillable = [
        'uuid',
        'name',
        'description',
    ];
}

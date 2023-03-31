<?php

declare(strict_types=1);

namespace Training\Infrastructure\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Shared\Infrastructure\Models\User;

class TrainingModel extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $primaryKey = 'uuid';

    protected $table = 'trainings';

    protected $fillable = [
        'uuid',
        'game_id',
        'user_id',
        'name',
        'description',
        'training_type',
    ];

    /**
     * @return HasMany<MetricRecordModel>
     */
    public function metricRecords(): HasMany
    {
        return $this->hasMany(
            related: MetricRecordModel::class,
            foreignKey: 'training_id',
            localKey: 'uuid',
        );
    }

    /**
     * @return BelongsTo<GameModel>
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(
            related: GameModel::class,
            foreignKey: 'game_id',
            ownerKey: 'uuid',
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id',
            ownerKey: 'uuid',
        );
    }
}

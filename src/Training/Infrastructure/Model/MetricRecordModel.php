<?php

namespace Training\Infrastructure\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MetricRecordModel extends Model
{
    use HasUuids;
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'uuid';

    protected $table = 'metric_records';

    protected $fillable = [
        'uuid',
        'training_id',
        'date',
    ];

    /**
     * @return HasMany<MetricRecordValueModel>
     */
    public function values(): HasMany
    {
        return $this->hasMany(
            MetricRecordValueModel::class,
            'metric_record_id',
            'uuid',
        );
    }
}

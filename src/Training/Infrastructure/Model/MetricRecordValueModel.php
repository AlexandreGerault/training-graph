<?php

namespace Training\Infrastructure\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetricRecordValueModel extends Model
{
    use HasUuids;
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'uuid';

    protected $table = 'metric_record_values';

    protected $fillable = [
        'metric_record_id',
        'key',
        'value',
    ];
}

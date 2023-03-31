<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Training\Infrastructure\Model\MetricRecordModel;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('metric_record_values', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignIdFor(MetricRecordModel::class, 'metric_record_id');
            $table->string('key');
            $table->integer('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_infrastructure_model_metric_records');
    }
};

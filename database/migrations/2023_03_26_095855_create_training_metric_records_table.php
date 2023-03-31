<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Training\Infrastructure\Model\TrainingModel;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('metric_records', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignIdFor(TrainingModel::class, 'training_id');
            $table->date('date');
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

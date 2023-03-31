<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement($this->dropView());

        DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement($this->dropView());
    }

    public function createView(): string
    {
        return <<<'SQL'
            CREATE VIEW cs_go_aim_reflex_training_view AS
            SELECT
                mr.uuid as metric_record_uuid,
                DATE(mr.date) as date,
                (
                        SELECT (SUM(CASE WHEN mrv.`key` = 'hitCount' THEN mrv.value ELSE 0 END) /
                                SUM(CASE WHEN mrv.`key` = 'targetCount' THEN mrv.value ELSE 0 END))
                        FROM metric_records inner_mr
                            INNER JOIN metric_record_values mrv ON inner_mr.uuid = mrv.metric_record_id
                        WHERE mr.uuid = inner_mr.uuid
                        GROUP BY DATE(mrv.created_at)
                ) as hit_ratio,
                (
                    SELECT ((SUM(CASE WHEN mrv.`key` = 'hitCount' THEN mrv.value ELSE 0 END) /
                             (SUM(CASE WHEN mrv.`key` = 'hitCount' THEN mrv.value ELSE 0 END) + SUM(CASE WHEN mrv.`key` = 'missCount' THEN mrv.value ELSE 0 END))))
                    FROM metric_records inner_mr
                        INNER JOIN metric_record_values mrv ON inner_mr.uuid = mrv.metric_record_id
                    WHERE mr.uuid = inner_mr.uuid
                    GROUP BY DATE(mrv.created_at)
                ) as precision_ratio
            FROM metric_records mr;
        SQL;
    }

    public function dropView(): string
    {
        return <<<'SQL'
            DROP VIEW IF EXISTS cs_go_aim_reflex_training_view;
        SQL;
    }
};

<?php

namespace Syedmahroof\AiAnalyzer;

use Syedmahroof\AiAnalyzer\Support\AnalyzerConfig;
use Illuminate\Support\Facades\Schema;

class AiAnalyzer
{
    /** @var array<int, array{type: string, message: string}>|null */
    private static ?array $healthCache = null;

    /**
     * Get the configured dashboard URI path.
     */
    public function path(): string
    {
        return AnalyzerConfig::path();
    }

    /**
     * Check the environment for common setup issues.
     *
     * @return array<int, array{type: string, message: string}>
     */
    public static function healthCheck(): array
    {
        if (self::$healthCache !== null) {
            return self::$healthCache;
        }

        $issues = [];

        $requiredTables = [
            'agent_conversations' => 'agent_conversations',
            'agent_conversation_messages' => 'agent_conversation_messages',
        ];

        foreach ($requiredTables as $table) {
            if (! Schema::hasTable($table)) {
                $issues[] = [
                    'type' => 'missing_table',
                    'message' => "Database table [{$table}] not found. Run [php artisan migrate] to create the Laravel AI SDK tables.",
                ];
            }
        }

        return self::$healthCache = $issues;
    }
}

<?php

namespace Database\Seeders;

use App\Models\WeddingMessageTemplate;
use Illuminate\Database\Seeder;

class WeddingMessageSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $rows = [];
        foreach (config('wedding_message_library', []) as $category => $phrases) {
            $opens = $phrases['opens'] ?? [];
            $ends = $phrases['ends'] ?? [];

            if (count($opens) !== 10 || count($ends) !== 5) {
                throw new \LogicException("The {$category} message category must contain 10 openings and 5 endings.");
            }

            foreach ($opens as $open) {
                foreach ($ends as $end) {
                    $content = trim($open) . ' ' . trim($end);
                    $rows[] = [
                        'category' => $category,
                        'content' => $content,
                        'content_hash' => hash('sha256', $content),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }

        // Idempotent bulk inserts keep migrations, seeds, and test suites fast.
        // Chunks also respect SQLite's lower parameter limits.
        foreach (array_chunk($rows, 100) as $batch) {
            WeddingMessageTemplate::query()->insertOrIgnore($batch);
        }
    }
}

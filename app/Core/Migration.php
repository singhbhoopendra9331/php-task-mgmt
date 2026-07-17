<?php

namespace App\Core;

class Migration
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Run the database migrations.
     *
     * @return void
     */
    public function migrate(): void
    {
        $files = glob(ABS_PATH . '/database/migrations/*.php');

        if (!$files) {
            echo "No migration files found." . PHP_EOL;
            return;
        }

        sort($files);

        $batch = $this->nextBatch();

        foreach ($files as $file) {

            $migrationName = basename($file);

            if ($this->hasRun($migrationName)) {
                continue;
            }

            $migration = require $file;

            foreach ($migration['up'] as $sql) {
                if (
                    !is_array($migration) ||
                    !isset($migration['up']) ||
                    !is_array($migration['up'])
                ) {
                    echo "Skipping invalid migration: {$name}" . PHP_EOL;
                    continue;
                }

                $this->db->query($sql);
            }

            $this->db->query(
                "INSERT INTO migrations (migration, batch) VALUES (?, ?)",
                [$migrationName, $batch]
            );

            echo "✓ {$migrationName}" . PHP_EOL;
        }

        echo PHP_EOL . "Migration completed." . PHP_EOL;
    }

    public function rollback()
    {
        // Roll back the last batch
    }

    public function status()
    {
        // Display applied and pending migrations
    }

    /**
     * Get the next batch number for migrations.
     *
     * @return int
     */

    private function nextBatch(): int
    {
        $result = $this->db
            ->query("SELECT MAX(batch) AS batch FROM migrations")
            ->fetch();

        return ((int) ($result['batch'] ?? 0)) + 1;
    }

    /**
     * 
     * @param string $migration
     * @return bool
     */
    private function hasRun(string $migration): bool
    {
        $result = $this->db
            ->query(
                "SELECT COUNT(*) AS total FROM migrations WHERE migration = ?",
                [$migration]
            )
            ->fetch();

        return (int) $result['total'] > 0;
    }
}
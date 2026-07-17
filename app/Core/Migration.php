<?php

namespace App\Core;

use Throwable;

class Migration
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Run all pending migrations.
     */
    public function migrate(): void
    {
        $this->ensureMigrationsTable();

        $files = glob(ABS_PATH . '/database/migrations/*.php');

        if (empty($files)) {
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

            if (
                !is_array($migration) ||
                !isset($migration['up']) ||
                !is_array($migration['up'])
            ) {
                echo "Skipping invalid migration: {$migrationName}" . PHP_EOL;
                continue;
            }

            try {

                $this->db->beginTransaction();

                foreach ($migration['up'] as $sql) {
                    $this->db->query($sql);
                }

                $this->db->query(
                    "INSERT INTO migrations (migration, batch) VALUES (?, ?)",
                    [$migrationName, $batch]
                );

                $this->db->commit();

                echo "✓ {$migrationName}" . PHP_EOL;

            } catch (Throwable $e) {

                $this->db->rollBack();

                echo PHP_EOL;
                echo "✗ Migration failed: {$migrationName}" . PHP_EOL;
                echo $e->getMessage() . PHP_EOL;

                exit(1);
            }
        }

        echo PHP_EOL . "Migration completed successfully." . PHP_EOL;
    }

    /**
     * Roll back the last batch.
     */
    public function rollback(): void
    {
        // TODO
    }

    /**
     * Show migration status.
     */
    public function status(): void
    {
        // TODO
    }

    /**
     * Drop all database tables.
     */
    public function clean(): void
    {
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");

        $tables = $this->db->query("SHOW TABLES")->fetchAll();

        foreach ($tables as $table) {

            $tableName = array_values($table)[0];

            echo "Dropping table: {$tableName}" . PHP_EOL;

            $this->db->query("DROP TABLE IF EXISTS `{$tableName}`");
        }

        $this->db->query("SET FOREIGN_KEY_CHECKS = 1");

        echo PHP_EOL . "Database cleaned successfully." . PHP_EOL;
    }

    /**
     * Get next migration batch.
     */
    private function nextBatch(): int
    {
        $result = $this->db
            ->query("SELECT MAX(batch) AS batch FROM migrations")
            ->fetch();

        return ((int)($result['batch'] ?? 0)) + 1;
    }

    /**
     * Determine whether a migration has already run.
     */
    private function hasRun(string $migration): bool
    {
        $result = $this->db
            ->query(
                "SELECT COUNT(*) AS total FROM migrations WHERE migration = ?",
                [$migration]
            )
            ->fetch();

        return (int)$result['total'] > 0;
    }

    /**
     * Ensure the migrations table exists.
     */
    private function ensureMigrationsTable(): void
    {
        $result = $this->db->query("SHOW TABLES LIKE 'migrations'");

        if ($result->rowCount() === 0) {
            $this->createMigrationsTable();
        }
    }

    /**
     * Create the migrations table.
     */
    private function createMigrationsTable(): void
    {
        $this->db->query("
            CREATE TABLE migrations (

                id INT AUTO_INCREMENT PRIMARY KEY,

                migration VARCHAR(255) NOT NULL,

                batch INT NOT NULL,

                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

            )
        ");

        echo "✓ Created migrations table." . PHP_EOL;
    }
}
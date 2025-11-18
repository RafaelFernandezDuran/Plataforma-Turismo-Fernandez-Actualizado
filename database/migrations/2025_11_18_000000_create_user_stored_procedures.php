<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    public function up(): void
    {
        $proceduresPath = database_path('procedures/users.sql');

        if (! File::exists($proceduresPath)) {
            throw new \RuntimeException("No se encontró el archivo de procedimientos en {$proceduresPath}.");
        }

        DB::unprepared(File::get($proceduresPath));
    }

    public function down(): void
    {
        DB::unprepared(<<<'SQL'
            DROP PROCEDURE IF EXISTS sp_create_user;
            DROP PROCEDURE IF EXISTS sp_get_user;
            DROP PROCEDURE IF EXISTS sp_update_user;
            DROP PROCEDURE IF EXISTS sp_delete_user;
        SQL);
    }
};

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\PermissionRegistrar;

class CreatePermissionTables extends Migration
{
    public function up(): void
    {
        $tableNames  = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $teams       = config('permission.teams');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded.');
        }
        if ($teams && empty($columnNames['team_foreign_key'] ?? null)) {
            throw new \Exception('Error: team_foreign_key not set.');
        }

        // 1) Borramos cualquier tabla residual de permisos
        Schema::dropIfExists($tableNames['role_has_permissions']);
        Schema::dropIfExists($tableNames['model_has_roles']);
        Schema::dropIfExists($tableNames['model_has_permissions']);
        Schema::dropIfExists($tableNames['roles']);
        Schema::dropIfExists($tableNames['permissions']);

        // 2) Tabla permissions
        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 125);
            $table->string('guard_name', 125);
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        // 3) Tabla roles
        Schema::create($tableNames['roles'], function (Blueprint $table) use ($teams, $columnNames) {
            $table->bigIncrements('id');
            if ($teams || config('permission.testing')) {
                $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
                $table->index($columnNames['team_foreign_key'], 'roles_team_foreign_key_index');
            }
            $table->string('name', 125);
            $table->string('guard_name', 125);
            $table->timestamps();
            if ($teams || config('permission.testing')) {
                $table->unique([$columnNames['team_foreign_key'], 'name', 'guard_name'], 'roles_team_name_guard_unique');
            } else {
                $table->unique(['name', 'guard_name'], 'roles_name_guard_unique');
            }
        });

        // 4) Pivot model_has_permissions
        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->unsignedBigInteger(PermissionRegistrar::$pivotPermission);
            $table->string('model_type', 255);
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'mhp_model_type_index');

            $table->foreign(PermissionRegistrar::$pivotPermission)
                  ->references('id')->on($tableNames['permissions'])
                  ->onDelete('cascade');

            // Uso UNIQUE en vez de PRIMARY
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'mhp_team_index');
                $table->unique([
                    $columnNames['team_foreign_key'],
                    PermissionRegistrar::$pivotPermission,
                    $columnNames['model_morph_key'],
                    'model_type'
                ], 'mhp_team_perm_model_unique');
            } else {
                $table->unique([
                    PermissionRegistrar::$pivotPermission,
                    $columnNames['model_morph_key'],
                    'model_type'
                ], 'mhp_perm_model_unique');
            }
        });

        // 5) Pivot model_has_roles
        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->unsignedBigInteger(PermissionRegistrar::$pivotRole);
            $table->string('model_type', 255);
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'mhr_model_type_index');

            $table->foreign(PermissionRegistrar::$pivotRole)
                  ->references('id')->on($tableNames['roles'])
                  ->onDelete('cascade');

            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'mhr_team_index');
                $table->unique([
                    $columnNames['team_foreign_key'],
                    PermissionRegistrar::$pivotRole,
                    $columnNames['model_morph_key'],
                    'model_type'
                ], 'mhr_team_role_model_unique');
            } else {
                $table->unique([
                    PermissionRegistrar::$pivotRole,
                    $columnNames['model_morph_key'],
                    'model_type'
                ], 'mhr_role_model_unique');
            }
        });

        // 6) Pivot role_has_permissions
        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger(PermissionRegistrar::$pivotPermission);
            $table->unsignedBigInteger(PermissionRegistrar::$pivotRole);

            $table->foreign(PermissionRegistrar::$pivotPermission)
                  ->references('id')->on($tableNames['permissions'])
                  ->onDelete('cascade');

            $table->foreign(PermissionRegistrar::$pivotRole)
                  ->references('id')->on($tableNames['roles'])
                  ->onDelete('cascade');

            $table->unique([
                PermissionRegistrar::$pivotPermission,
                PermissionRegistrar::$pivotRole
            ], 'rhp_perm_role_unique');
        });

        // 7) Limpiar cache de permisos
        app('cache')
            ->store(config('permission.cache.store') !== 'default'
                ? config('permission.cache.store')
                : null)
            ->forget(config('permission.cache.key'));
    }

    public function down(): void
    {
        $tableNames = config('permission.table_names');
        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found.');
        }

        Schema::dropIfExists($tableNames['role_has_permissions']);
        Schema::dropIfExists($tableNames['model_has_roles']);
        Schema::dropIfExists($tableNames['model_has_permissions']);
        Schema::dropIfExists($tableNames['roles']);
        Schema::dropIfExists($tableNames['permissions']);
    }
}

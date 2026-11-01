<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    public function up(): void
    {
        $old = DB::table('roles')->where('name', 'superadmin')->where('guard_name', 'web')->first();
        $new = DB::table('roles')->where('name', 'superAdmin')->where('guard_name', 'web')->first();

        if ($old && ! $new) {
            DB::table('roles')->where('id', $old->id)->update(['name' => 'superAdmin']);
        } elseif ($old && $new) {
            foreach (DB::table('model_has_roles')->where('role_id', $old->id)->get() as $assignment) {
                DB::table('model_has_roles')->updateOrInsert([
                    'role_id' => $new->id,
                    'model_type' => $assignment->model_type,
                    'model_id' => $assignment->model_id,
                ], []);
            }

            foreach (DB::table('role_has_permissions')->where('role_id', $old->id)->get() as $assignment) {
                DB::table('role_has_permissions')->updateOrInsert([
                    'role_id' => $new->id,
                    'permission_id' => $assignment->permission_id,
                ], []);
            }

            DB::table('roles')->where('id', $old->id)->delete();
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        DB::table('roles')->where('name', 'superAdmin')->where('guard_name', 'web')->update(['name' => 'superadmin']);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
};

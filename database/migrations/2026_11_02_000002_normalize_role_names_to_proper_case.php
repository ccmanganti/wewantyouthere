<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    public function up(): void
    {
        foreach ([
            'Superadmin' => ['superadmin', 'superAdmin'],
            'User' => ['user'],
            'Affiliate' => ['affiliate'],
            'Associate' => ['associate'],
        ] as $target => $aliases) {
            $roles = DB::table('roles')
                ->where('guard_name', 'web')
                ->whereIn('name', array_merge([$target], $aliases))
                ->orderByRaw('CASE WHEN name = ? THEN 0 ELSE 1 END', [$target])
                ->get();

            if ($roles->isEmpty()) {
                continue;
            }

            $keep = $roles->first();
            foreach ($roles->skip(1) as $duplicate) {
                foreach (DB::table('model_has_roles')->where('role_id', $duplicate->id)->get() as $row) {
                    DB::table('model_has_roles')->updateOrInsert([
                        'role_id' => $keep->id,
                        'model_type' => $row->model_type,
                        'model_id' => $row->model_id,
                    ], []);
                }

                foreach (DB::table('role_has_permissions')->where('role_id', $duplicate->id)->get() as $row) {
                    DB::table('role_has_permissions')->updateOrInsert([
                        'role_id' => $keep->id,
                        'permission_id' => $row->permission_id,
                    ], []);
                }

                DB::table('roles')->where('id', $duplicate->id)->delete();
            }

            DB::table('roles')->where('id', $keep->id)->update(['name' => $target]);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        // Deliberately irreversible: preserves role assignments and canonical names.
    }
};

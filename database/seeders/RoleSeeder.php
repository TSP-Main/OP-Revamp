<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create roles
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $dispensary = Role::firstOrCreate(['name' => 'dispensary']);
        $doctor = Role::firstOrCreate(['name' => 'doctor']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // Create permissions
        $permissions = [
            // Super Admin Permissions
            'home',
            'dashboard',
            'comment_store',
            'vet_prescription',
            'sops',
            'add_sop',
            'store_sop',
            'faq_questions',
            'gp_locations',
            'categories',
            'sub_categories',
            'child_categories',
            'dell_category',
            'add_category',
            'store_query',
            'company_details',
            'dell_question',
            'add_collection',
            'consultations',
            'questions',
            'add_question',
            'dispensary_approval',
            'assign_question',
            'products',
            'add_product',
            'orders',
            'admin.unpaidOrders',
            'consultation_view',
            'orders_shipped',
            'orders_unshipped',
            'prescription_orders',
            'orders_created',
            'orders_refunded',
            'orders_audit',
            'online_clinic_orders',
            'shop_orders',
            'gpa_letters',
            'orders_received',
            'admin.allOrders',
            'doctors_approval',
            'doctors',
            'add_doctor',
            'dispensaries',
            'add_dispensary',
            'users',
            'contact',
            'setting',
            'faq',
            'featured_products',
            'question_categories',
            'add_question_category',
            'p_med_gq',
            'prescription_med_gq',
        ];

        // Create all permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign all permissions to super admin
        $superAdmin->givePermissionTo(Permission::all());

        // Assign specific permissions to other roles
        // Dispensary Permissions
        $dispensaryPermissions = [
            'dashboard',
            'gpa_letters',
            'orders_audit',
            'comment_store',
            'gp_locations',
            'orders',
            'sops',
            'admin.allOrders',
            'orders_received',
            'store_query',
            'dispensary_approval',
            'doctors_approval',
            'orders_shipped',
            'orders_unshipped',
            'consultation_view',
            'contact',
            'setting',
            'faq',
        ];
        $dispensary->givePermissionTo($dispensaryPermissions);

        // Doctor Permissions
        $doctorPermissions = [
            'dashboard',
            'comment_store',
            'orders_shipped',
            'sops',
            'store_query',
            'orders',
            'gp_locations',
            'admin.allOrders',
            'orders_received',
            'gpa_letters',
            'consultation_view',
            'doctors_approval',
            'contact',
            'setting',
            'faq',
        ];
        $doctor->givePermissionTo($doctorPermissions);

        // User Permissions
        $userPermissions = [
            'home',
            'dashboard',
            'store_query',
            'consultation_view',
            'prescription_orders',
            'online_clinic_orders',
            'shop_orders',
            'contact',
            'setting',
        ];
        $user->givePermissionTo($userPermissions);
    }
}

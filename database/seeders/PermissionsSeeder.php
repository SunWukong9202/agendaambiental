<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Enums\Permission as PermissionEnum;
use App\Enums\Role as RoleEnum;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Create Permissions using the Permission enum
        foreach (PermissionEnum::cases() as $permission) {
            Permission::updateOrCreate(['name' => $permission->value]);
        }

        // Define Roles and their associated permissions
        $roles = [
            RoleEnum::SuperAdmin->value => [],
            RoleEnum::Admin->value => [
                PermissionEnum::HasAdminPanelAccess->value,
                PermissionEnum::ViewPermissions->value,
                PermissionEnum::GrantPermission->value,
                PermissionEnum::RevokePermission->value,
                PermissionEnum::ViewUsers->value,
                PermissionEnum::AddUsers->value,
                PermissionEnum::EditUsers->value,
                PermissionEnum::DeleteUsers->value,
                PermissionEnum::GrantAdminPanelAccess->value,
                PermissionEnum::RevokeAdminPanelAccess->value,
                PermissionEnum::ViewWastes->value,
                PermissionEnum::AddWastes->value,
                PermissionEnum::EditWastes->value,
                PermissionEnum::DeleteWastes->value,
                PermissionEnum::ViewEvents->value,
                PermissionEnum::AddEvents->value,
                PermissionEnum::EditEvents->value,
                PermissionEnum::DeleteEvents->value,
                PermissionEnum::AccessActiveEvents->value,
                PermissionEnum::ExportEventDonationsFormat->value,
                PermissionEnum::ImportEventDonations->value,
                PermissionEnum::AddEventDonations->value,
                PermissionEnum::ViewItems->value,
                PermissionEnum::AddItems->value,
                PermissionEnum::EditItems->value,
                PermissionEnum::DeleteItems->value,
                PermissionEnum::AddItemDonations->value,
                PermissionEnum::AddItemPetitions->value,
                PermissionEnum::SettleItemPetitions->value,
                PermissionEnum::ViewEventInventory->value,
                PermissionEnum::AssignRepairments->value,
                PermissionEnum::UnassignRepairments->value,
                PermissionEnum::ViewRepairments->value,
                PermissionEnum::InitiateRepairments->value,
                PermissionEnum::LogRepairmentAttempts->value,
                PermissionEnum::EditRepairments->value,
                PermissionEnum::DeleteRepairments->value,
                PermissionEnum::FinalizeRepairments->value,
                PermissionEnum::ViewSuppliers->value,
                PermissionEnum::AddSuppliers->value,
                PermissionEnum::EditSuppliers->value,
                PermissionEnum::DeleteSuppliers->value,
                PermissionEnum::ViewReports->value,
                PermissionEnum::DownloadReports->value,
                PermissionEnum::GenerateReports->value,
                PermissionEnum::SendReportsToSupplier->value,
                PermissionEnum::DeleteReports->value,
                PermissionEnum::ArchiveReports->value,
                PermissionEnum::ViewDeliveries->value,
                PermissionEnum::AddDeliveries->value,
                PermissionEnum::EditDeliveries->value,
                PermissionEnum::DeleteDeliveries->value,
                PermissionEnum::ViewReagents->value,
                PermissionEnum::AddReagents->value,
                PermissionEnum::EditReagents->value,
                PermissionEnum::DeleteReagents->value,
                PermissionEnum::AddReagentDonations->value,
                PermissionEnum::AddReagentPetitions->value,
                PermissionEnum::SettleReagentPetitions->value,
                PermissionEnum::ViewReagentsInventory->value,
                PermissionEnum::ViewSettings->value,
                PermissionEnum::EditSettings->value,
            ],
            RoleEnum::Capturist->value => [
                PermissionEnum::HasAdminPanelAccess->value,
                PermissionEnum::AccessActiveEvents->value,
                PermissionEnum::ExportEventDonationsFormat->value,
                PermissionEnum::ImportEventDonations->value,
                PermissionEnum::AddEventDonations->value,
                PermissionEnum::AddWastes->value,
                PermissionEnum::AddItems->value,
                PermissionEnum::AddItemDonations->value,
                PermissionEnum::AssignRepairments->value,
                PermissionEnum::UnassignRepairments->value,
            ],
            RoleEnum::RepairTechnician->value => [
                
                // No permissions assigned, as their actions are handled by role status
            ],
        ];

        // Create Roles and Assign Permissions
        foreach ($roles as $roleName => $permissions) {
            $role = Role::updateOrCreate(['name' => $roleName]);
            $role->syncPermissions($permissions);
        }
    }
}

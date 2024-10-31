<?php

namespace App\Enums;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

enum Permission: string
{

    case ViewRoles = 'view-roles';
    case AddRoles = 'add-roles';
    case EditRoles = 'edit-roles';
    case DeleteRoles = 'delete-roles';
    //give/revoke roles
    case GrantRoles = 'grant-roles';
    case RevokeRoles = 'revoke-roles';
 
    case ViewPermissions = 'view-permissions';
    case GrantPermission = 'grant-permission';
    case RevokePermission = 'revoke-permission';

    case ViewUsers = 'view-users';
    case AddUsers = 'add-users';
    case EditUsers = 'edit-users';
    case DeleteUsers = 'delete-users';
    //give/revoke users access to the admin panel
    case GrantAdminPanelAccess = 'grant-admin-panel-access';
    case RevokeAdminPanelAccess = 'revoke-admin-panel-access';
    case HasAdminPanelAccess = 'has-admin-panel-access';
    //is main purpose is serve as register of the category of
    //the type of waste recollected like carton, plastic, glass, etc.
    case ViewWastes = 'view-wastes';
    case AddWastes = 'add-wastes';
    case EditWastes = 'edit-wastes';
    case DeleteWastes = 'delete-wastes';
    
    //are events/campaigns of waste recollection in order
    //to recycle the waste gatered or gived a better use
    case ViewEvents = 'view-events';
    case AddEvents = 'add-events';
    case EditEvents = 'edit-events';
    case DeleteEvents = 'delete-events';

    case AccessActiveEvents = 'access-active-events';
    //will allow to download a premade event donation format
    //for cases when there is no internet use excel as fallback
    case ExportEventDonationsFormat = 'export-event-donations-format';
    //will allow to enter the donations registered on the excel exported
    //or one identical
    case ImportEventDonations = 'import-event-donations';
    //in this case is only in the active events
    case AddEventDonations = 'add-event-donations';

    //these come from the donations of waste made during events. if there is
    //an item call it an electronic, gadget, etc that is in acceptable conditions
    //then it will be added here to keep track of them
    case ViewItems = 'view-items';
    case AddItems = 'add-items';
    case EditItems = 'edit-items';
    case DeleteItems = 'delete-items';
    
    //this will keep track of the captures of items found and petitions
    //made for those item by certains users
    case AddItemDonations = 'add-item-donations';
    case AddItemPetitions = 'add-item-petitions';
    case SettleItemPetitions = 'settle-item-petitions';
    //will keep track of the stock of the items registered/founded
    case ViewEventInventory = 'view-event-inventory';

    //the purpose of this is to keep record of the items reparations
    //that were in semi good/acceptable conditions of the waste gatered in the event
    case AssignRepairments = 'assign-repairments';
    case UnassignRepairments = 'unassign-repairments';

    case ViewRepairments = 'view-repairments';
    //carry ahead the repairment/do the repairment
    case InitiateRepairments = 'initiate-repairments';
    case LogRepairmentAttempts = 'log-repairment-attempts';
    case EditRepairments = 'edit-repairments';
    case DeleteRepairments = 'delete-repairments';
    case FinalizeRepairments = 'finalize-repairments';

    //Are a kinf of users who doesnt hava an account
    //pick up deliveries of the wastes gatered during an event
    case ViewSuppliers = 'view-suppliers';
    case AddSuppliers = 'add-suppliers';
    case EditSuppliers = 'edit-suppliers';
    case DeleteSuppliers = 'delete-suppliers';

    //this will allow generate a report of the deliveries given
    //to certain supplier downloading it or sending it to the email of the supplier
    // Report View Permissions
    case ViewReports = 'view-reports';               // View a list of all reports or individual report details
    case DownloadReports = 'download-reports';       // Download a report file (PDF, Excel, etc.)

    // Report Creation/Generation Permissions
    case GenerateReports = 'generate-reports';       // Create a new report (either on-demand or scheduled generation)
    case SendReportsToSupplier = 'send-reports-to-supplier';
    // Report Deletion/Archiving Permissions
    // case UpdateReports = 'update-reports';           // Modify metadata or details of existing reports, if needed
    case DeleteReports = 'delete-reports';           // Permanently remove reports
    case ArchiveReports = 'archive-reports';        //Provides an option to archive reports instead of deleting them. This could help retain data without making it active.

    //Deliveries: is a register of an
    case ViewDeliveries = 'view-deliveries';
    case AddDeliveries = 'add-deliveries';
    case EditDeliveries = 'edit-deliveries';
    case DeleteDeliveries = 'delete-deliveries';

    case ViewReagents = 'view-reagents';
    case AddReagents = 'add-reagents';
    case EditReagents = 'edit-reagents';
    case DeleteReagents = 'delete-reagents';

    case AddReagentDonations = 'add-reagent-donations';
    case AddReagentPetitions = 'add-reagent-petitions';
    case SettleReagentPetitions = 'settle-reagent-petitions';

    case ViewReagentsInventory = 'view-reagents-inventory';

    case ViewSettings = 'view-settings';
    case EditSettings = 'edit-settings';

    public function readable(): string
    {
        $clean = str_replace('-', ' ', $this->value);
        return ucfirst($clean);
    }

    public static function groupByEntity(): array
    {
        return [
            'Access Managment' => [
                Permission::GrantRoles,
                Permission::RevokeRoles,
                Permission::GrantAdminPanelAccess,
                Permission::RevokeAdminPanelAccess,
            ],
            'Roles' => [
                Permission::ViewRoles,
                Permission::AddRoles,
                Permission::EditRoles,
                Permission::DeleteRoles,
            ],
            'Permissions' => [
                Permission::ViewPermissions,
                Permission::GrantPermission,
                Permission::RevokePermission,
            ],
            'Users' => [
                Permission::ViewUsers,
                Permission::AddUsers,
                Permission::EditUsers,
                Permission::DeleteUsers,
                Permission::HasAdminPanelAccess,
            ],
            'Wastes' => [
                Permission::ViewWastes,
                Permission::AddWastes,
                Permission::EditWastes,
                Permission::DeleteWastes,
            ],
            'Events' => [
                Permission::ViewEvents,
                Permission::AddEvents,
                Permission::EditEvents,
                Permission::DeleteEvents,
            ],
            'Active events' => [
                Permission::AccessActiveEvents,
                Permission::ExportEventDonationsFormat,
                Permission::ImportEventDonations,
                Permission::AddEventDonations,
            ],
            'Items' => [
                Permission::ViewItems,
                Permission::AddItems,
                Permission::EditItems,
                Permission::DeleteItems,
            ],

            'Event Inventory' => [
                Permission::ViewEventInventory,
                Permission::AddItemDonations,
                Permission::AddItemPetitions,
                Permission::SettleItemPetitions,
            ],
    
            'Suppliers' => [
                Permission::ViewSuppliers,
                Permission::AddSuppliers,
                Permission::EditSuppliers,
                Permission::DeleteSuppliers,
            ],
    
            'Deliveries' => [
                Permission::ViewDeliveries,
                Permission::AddDeliveries,
                Permission::EditDeliveries,
                Permission::DeleteDeliveries,
            ],
            'Reagents' => [
                Permission::ViewReagents,
                Permission::AddReagents,
                Permission::EditReagents,
                Permission::DeleteReagents,
            ],
            'Reagents Inventory' => [
                Permission::ViewReagentsInventory,
                Permission::AddReagentDonations,
                Permission::AddReagentPetitions,
                Permission::SettleReagentPetitions,
            ],
            'Settings' => [
                Permission::ViewSettings,
                Permission::EditSettings,
            ],
            'Repairments' => [
                Permission::AssignRepairments,
                Permission::UnassignRepairments,
                Permission::ViewRepairments,
                Permission::InitiateRepairments,
                Permission::LogRepairmentAttempts,
                Permission::EditRepairments,
                Permission::DeleteRepairments,
                Permission::FinalizeRepairments,
            ],
            'Reports' => [
                Permission::ViewReports,
                Permission::DownloadReports,
                Permission::GenerateReports,
                Permission::SendReportsToSupplier,
                Permission::DeleteReports,
                Permission::ArchiveReports,
            ],
            
        ];        
    }
}

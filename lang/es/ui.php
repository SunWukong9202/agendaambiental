<?php 

return [
    'list' => 'list',
    'create' => 'Create',
    'edit' => 'Edit',
    'notifications' => [
        'roles' => [
            'assign' => [
                'title' => 'Role :name correctly assigned!',
                'body' => 'Role :name Assigned to the user :user',
            ],
            'unassign' => [
                'title' => 'Role :name correctly revoked!',
                'body' => 'Role :name was revoked from the user :user',
            ],
            'success' => [
                'title' => 'New role :name successfully created!',
                'body' => 'Now you can use this new role in the :modulename',
            ]
        ]
    ],
    'pages' => [
        //by default we left the pages named
        // Quick summary of recent activities, metrics, and updates on events, donations, or requests.
        'Admin Panel' => 'Admin Panel',
        'Dashboard' => 'Dashboard',

        'Users Managment' => 'Users Managment',
        'Manage Users' => 'Manage Users',
        'Manage Suppliers' => 'Manage Suppliers',
        'Roles & Permissions' => 'Roles & Permissions',

        'Event Managment' => 'Event Managment',
        //Access past events with filters (date, material type).
        'Event History' => 'Event History',
        //View and manage ongoing events.
        'Active Events' => 'Active Events',
        //: Record deliveries to providers.
        'Register Deliveries' => 'Register Deliveries',
        //Track of waste by event
        'Event Inventory' => 'Event Inventory',

        'Inventory Movements' => 'Inventory Movements',

        'Inventory Movements' => 'Inventory Movements',

        'Repairment Managment' => 'Repairment Managment',

        'Waste Managment' => 'Waste Managment',

        'Reagent Management' => 'Reagent Management',
        'Manage Reagents' => 'Manage Reagents',
        'Reagent Inventory' => 'Reagent Inventory', 
        
        'Home' => 'Inicio',
        'Donations' => 'Donaciones',
        'Petitions' => 'Peticiones',
        'users' => [
            'link' => 'Usuarios',
        ],
        'Log out' => 'Log out',
        'Return home' => 'Return home'
    ]
];
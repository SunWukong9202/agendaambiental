<?php 

return [
    'selected' => 'Selected',
    'deliveries' => 'Deliveries',
    'list' => 'list',
    'create' => 'Create',
    'edit' => 'Edit',
    'delete' => 'Delete',
    "msgs" => [
        'deliveries' => [
            "title" => "No deliveries found.",
            "icon" => "heroicon-m-archive-box",
            "description" => "Try looking for other term or adding a new delivery.",
            "search" => "Search by event names, type of waste or name of the deliver.",
        ]
    ],
    'buttons' => [
        'user'     => ':action user',
        'supplier' => ':action supplier',
        'event' => ':action event',
        'enter' => 'Entrar',
    ],
    'notifications' => [
        'p-accepted' => 'Great news, your petition for :item has been accepted!',
        'p-rejected' => 'We are sorry, but your petition for :item has been declined!',
        'actions' => [
            'delete' => 'The :actor :name has been successfully deleted!.',
            'create' => 'The :actor :name has been successfully created!.',
            'edit' => 'The :actor :name has been successfully updated!.',
        ],
        'users' => [
            'title' => 'User :action',
            'body' => 'The user :name has been :action succesfully.',
        ],
        'suppliers' => [
            'title' => 'Supplier :action',
            'body' => 'The supplier :name has been :action succesfully.',
        ],
        'events' => [
            'title' => 'Event :action',
            'body' => 'The Event :name has been :action succesfully.',
        ],
        'donations' => [
            'title' => 'Donation :action',
            'body' => ':type has been :action succesfully.',
        ],
        'deliveries' => [
            'title' => 'Delivery :action',
            // 'body' => 'The delivery has been :action for the supplier :name succesfully.',
            'body' => ':quantity :unit of :waste has been :_action correctly!'
        ],
        'items' => [
            'title' => 'Item :action',
            // 'body' => 'The delivery has been :action for the supplier :name succesfully.',
            'body' => 'The Item :name has been :action succesfully.'
        ],
        'roles' => [
            'assign' => [
                'title' => 'Role :name correctly assigned!',
                'body' => 'Role :name assigned to the user :user',
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
        
        'Home' => 'Home',
        'Donations' => 'Donaciones',
        'Item petition' => 'Item petition',
        'Reagent petition' => 'Reagent petition',
        'Reagent donation' => 'Reagent donation',
        'Petitions' => 'Peticiones',
        'My Repairs' => 'My Repairs',
        'users' => [
            'link' => 'Usuarios',
        ],
        'Log out' => 'Log out',
        'Return home' => 'Return home',
        'Settings' => 'Settings'
    ],
    'helpers' => [
        'rfc' => 'Please ENTER a format like [XXX|X] YY MM DD [ZZ|Z] by example LOPJ 90 01 15 HDF or ABT 10 03 12 XX. Just keep typing and we will enforce the format',
        'invalid_date' => 'Date format is incorrect please correct',
        'technician' => 'Please take into account that you can only edit while the technician haven\'t started the repairment.',
        'assign' => 'Here you can write anything you want to say to the technician :name about the item assigned for reparation.',
        'unassign' => 'Here you can write why did you decide to unassign the item from the technician :name.',
        'unassign_title' => 'To avoid uncontrolled un/assigments',
        'unique_unassign' => 'One you do this uassignment the techncian :name wouldn\'t be allowed to be selected again for this item.',
        'item-petition' => 'Here you can write anything you want to say. ex. I would like a blue cup.',
        'item-not-found' => 'Can\'t find it? no problem you can add with the plus button at the end of the select',
        'assign-technician-title' => 'Want to assign a technician to this item',
        'assign-technician' => 'Below you can choose it. Dont want to do it right now. No problem you can assign it later.',
        'repair-started' => 'Here you can write anything of what you want before begining with the repairment process.',
        'repair-log' => 'Here you can write any obsevations for this repairment log.',
        'repair-completed' => 'Here you can write anything you want before closing the repairment process.',
        'item-capture' => 'Here you can add any observations about the item you want to write.',
        'repair-assign' => 'Here you can write anything you want to say to the technician.',

        'named-petition-title' => 'Verify that the item does not exist!',
        'named-petition-description' => 'Before resolving this petition, please ensure the requested item does not already exist in the system. To assist with this, you can perform a quick search using the provided search tool below.',
        'named-petition-op1' => 'If the item is found: Select it to resolve the petition without duplication.',
        'named-petition-op2' => 'If the item is not found: Proceed to create it before resolving the petition.',
         
    ],
    'placeholders' => [
        'item-capture' => 'Please select the item you want to register',
        'resolve-petition-reason' => 'Here you can write the reason of your decision. Picking details of anything you want to say to the user',
        // 'item-search' => 'Please se'
    ],
    'cta' => [
        'item-p-title' => '"Join Us in Building a Sustainable Future – Submit Your Material Request Today!"',
        'item-petition' => 'Are you in need of specific resources or materials to further your environmental initiatives? Our system makes it simple to submit petitions for recycled materials and reagents essential to your projects.',
        'reagent-title' => '"Make a Lasting Impact with Your Donations!',
        'reagent-donation' => 'Your donations of unused reagents can fuel transformative environmental projects at the university and beyond. Whether you’re an internal member or an external contributor, your support is invaluable to our mission of sustainability.',
        'reagent-p-title' => '"Need Reagents? Let’s Make Science Accessible!"',
        'reagent-petition' => 'If you’re in need of reagents submit your request today. We’re here to make sure nothing stands in the way of your next breakthrough.',
        'Make petition' => 'Make petition',
        'Make donation' => 'Make donation'
    ],
    'datalists' => [
        // [
        //     'Information Technology' => 'Tecnología de la Información',
        //     'Health and Medicine' =>'Salud y Medicina',
        //     'Education' => 'Educación',
        //     'Manufacturing' => 'Manufactura',
        //     'Financial Services' => 'Servicios Financieros',
        //     'Food and Beverage' =>  'Alimentos y Bebidas',
        //     'Energy and Natural Resources' => 'Energía y Recursos Naturales',
        //     'Transportation and Logistics' =>  'Transporte y Logística',
        //     'Construction' =>  'Construcción',
        //     'Retail Trade' =>'Comercio Minorista',
        // ]
    ]
];
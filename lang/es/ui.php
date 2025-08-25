<?php 

return [
    'selected' => 'Seleccionado',
    'deliveries' => 'Entregas',
    'list' => 'Lista',
    'create' => 'Crear',
    'edit' => 'Editar',
    'delete' => 'Eliminar',
    "msgs" => [
        'deliveries' => [
            "title" => "No se encontraron entregas.",
            "icon" => "heroicon-m-archive-box",
            "description" => "Intenta buscar otro término o agregar una nueva entrega.",
            "search" => "Buscar por nombre de evento, tipo de residuo o nombre del entregador.",
        ]
    ],
    'buttons' => [
        'user'     => ':action usuario',
        'supplier' => ':action proveedor',
        'event' => ':action evento',
        'enter' => 'Entrar',
    ],
    'notifications' => [
        'p-accepted' => '¡Buenas noticias, tu solicitud para :item ha sido aceptada!',
        'p-rejected' => 'Lo sentimos, pero tu solicitud para :item ha sido rechazada!',
        'actions' => [
            'delete' => '¡El :actor :name ha sido eliminado correctamente!',
            'create' => '¡El :actor :name ha sido creado correctamente!',
            'edit' => '¡El :actor :name ha sido actualizado correctamente!',
        ],
        'users' => [
            'title' => 'Usuario :action',
            'body' => 'The user :name has been :action succesfully.',
        ],
        'suppliers' => [
            'title' => 'Proveedor :action',
            'body' => 'El proveedor :name ha sido :action correctamente.',
        ],
        'events' => [
            'title' => 'Evento :action',
            'body' => 'El evento :name ha sido :action correctamente.',
        ],
        'donations' => [
            'title' => 'Donación :action',
            'body' => ':type ha sido :action correctamente.',
        ],
        'deliveries' => [
            'title' => 'Entrega :action',
            // 'body' => 'The delivery has been :action for the supplier :name succesfully.',
            'body' => ':quantity :unit de :waste ha sido :_action correctamente!'
        ],
        'items' => [
            'title' => 'Artículo :action',
            // 'body' => 'The delivery has been :action for the supplier :name succesfully.',
            'body' => 'El Artículo :name ha sido :action correctamente.'
        ],
        'roles' => [
            'assign' => [
                'title' => '¡Rol :name asignado correctamente!',
                'body' => 'Rol :name asignado al usuario :user',
            ],
            'unassign' => [
                'title' => '¡Rol :name revocado correctamente!',
                'body' => 'Rol :name fue revocado del usuario :user',
            ],
            'success' => [
                'title' => '¡Nuevo rol :name creado correctamente!',
                'body' => 'Ahora puedes usar este nuevo rol en :modulename',
            ]
        ]
    ],
    'pages' => [
        //by default we left the pages named
        // Quick summary of recent activities, metrics, and updates on events, donations, or requests.
        'Admin Panel' => 'Panel de Administración',
        'Dashboard' => 'Tablero',

        'Users Managment' => 'Gestión de Usuarios',
        'Manage Users' => 'Gestionar Usuarios',
        'Manage Suppliers' => 'Gestionar Proveedores',
        'Roles & Permissions' => 'Roles y Permisos',

        'Event Managment' => 'Gestión de Eventos',
        //Access past events with filters (date, material type).
        'Event History' => 'Historial de Eventos',
        //View and manage ongoing events.
        'Active Events' => 'Eventos Activos',
        //: Record deliveries to providers.
        'Register Deliveries' => 'Registrar Entregas',
        //Track of waste by event
        'Event Inventory' => 'Inventario de Evento',

        'Inventory Movements' => 'Movimientos de Inventario',

        'Inventory Movements' => 'Movimientos de Inventario',

        'Repairment Managment' => 'Gestión de Reparaciones',

        'Waste Managment' => 'Gestión de Residuos',

        'Reagent Management' => 'Gestión de Reactivos',
        'Manage Reagents' => 'Gestionar Reactivos',
        'Reagent Inventory' => 'Inventario de Reactivos', 
        
        'Home' => 'Inicio',
        'Donations' => 'Donaciones',
        'Item petition' => 'Petición de Artículos',
        'Reagent petition' => 'Petición de Reactivo',
        'Reagent donation' => 'Donación de Reactivo',
        'Grant roles' =>'Roles',
        'Petitions' => 'Peticiones',
        'My Repairs' => 'Mis Reparaciones',
        'users' => [
            'link' => 'Usuarios',
        ],
        'Log out' => 'Cerrar sesión',
        'Return home' => 'Regresar al inicio',
        'Settings' => 'Configuraciones'
    ],
    'helpers' => [
        'rfc' => 'Por favor, ingresa un formato como [XXX|X] YY MM DD [ZZ|Z], por ejemplo LOPJ 90 01 15 HDF o ABT 10 03 12 XX. Continúa escribiendo y nosotros aplicaremos el formato.',
        'invalid_date' => 'El formato de la fecha es incorrecto, por favor corrígelo.',
        'technician' => 'Por favor, ten en cuenta que solo puedes editar mientras el técnico no haya comenzado la reparación.',
        'assign' => 'Aquí puedes escribir cualquier cosa que quieras decir al técnico :name sobre el ítem asignado para reparación.',
        'unassign' => 'Aquí puedes escribir por qué decidiste desasignar el ítem del técnico :name.',
        'unassign_title' => 'Para evitar desasignaciones incontroladas',
        'unique_unassign' => 'Una vez que hagas esta desasignación, el técnico :name no podrá ser seleccionado nuevamente para este ítem.',
        'item-petition' => 'Aquí puedes escribir cualquier cosa que quieras decir. Ej. Me gustaría una taza azul.',
        'item-not-found' => '¿No lo encuentras? No hay problema, puedes agregarlo con el botón de más al final de la selección.',
        'assign-technician-title' => '¿Quieres asignar un técnico a este Artículo?',
        'assign-technician' => 'A continuación, puedes elegirlo. No quieres hacerlo ahora. No hay problema, puedes asignarlo más tarde.',
        'repair-started' => 'Aquí puedes escribir cualquier cosa que quieras antes de comenzar con el proceso de reparación.',
        'repair-log' => 'Aquí puedes escribir cualquier observación para este registro de reparación.',
        'repair-completed' => 'Aquí puedes escribir cualquier cosa que quieras antes de cerrar el proceso de reparación.',
        'item-capture' => 'Aquí puedes agregar cualquier observación sobre el ítem que quieras registrar.',
        'repair-assign' => 'Aquí puedes escribir cualquier cosa que quieras decir al técnico.',

        'named-petition-title' => '¡Verifica que el Artículo no exista!',
        'named-petition-description' => 'Antes de resolver esta petición, asegúrate de que el ítem solicitado no exista ya en el sistema. Para ayudarte, puedes realizar una búsqueda rápida usando la herramienta de búsqueda proporcionada a continuación.',
        'named-petition-op1' => 'Si se encuentra el ítem: Selecciónalo para resolver la petición sin duplicados.',
        'named-petition-op2' => 'Si no se encuentra el ítem: Procede a crearlo antes de resolver la petición.',
         
    ],
    'placeholders' => [
        'item-capture' => 'Please select the item you want to register',
        'resolve-petition-reason' => 'Here you can write the reason of your decision. Picking details of anything you want to say to the user',
        // 'item-search' => 'Please se'
    ],
    'cta' => [
        'item-p-title' => '"¡Únete a nosotros para construir un futuro sostenible – Envía tu solicitud de materiales hoy!"',
        'item-petition' => '¿Necesitas recursos o materiales específicos para avanzar en tus iniciativas ambientales? Nuestro sistema facilita la presentación de peticiones para materiales reciclados y reactivos esenciales para tus proyectos.',
        'reagent-title' => '"¡Haz un impacto duradero con tus donaciones!"',
        'reagent-donation' => 'Tus donaciones de reactivos no utilizados pueden impulsar proyectos transformadores en la universidad y más allá. Ya seas un miembro interno o un contribuyente externo, tu apoyo es invaluable para nuestra misión de sostenibilidad.',
        'reagent-p-title' => '"¿Necesitas reactivos? ¡Hagamos la ciencia accesible!"',
        'reagent-petition' => 'Si necesitas reactivos, presenta tu solicitud hoy mismo. Estamos aquí para asegurarnos de que nada se interponga en tu próximo avance.',
        'Make petition' => 'Hacer solicitud',
        'Make donation' => 'Hacer donación'
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
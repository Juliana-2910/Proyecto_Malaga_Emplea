<?php

return [
    'guard' => 'web',

    'rol_admin' => 'administrador',

    'permiso_admin' => 'gestionar seguridad',

    'roles_protegidos' => ['administrador', 'empresa'],

    'roles_no_desactivables' => ['administrador'],

    'acciones' => ['ver', 'crear', 'editar', 'eliminar'],

    'metodos_a_acciones' => [
        'index' => 'ver',
        'show' => 'ver',
        'create' => 'crear',
        'store' => 'crear',
        'edit' => 'editar',
        'update' => 'editar',
        'destroy' => 'eliminar',
    ],

    'auditar_prefijos' => ['App\\'],

    'rol_empresa' => 'empresa',

    'login' => [
        'usuario' => [
            'guard' => 'web',
            'modelo' => App\Models\Usuario::class,
            'columna_email' => 'email',
            'columna_estado' => 'estado',
            'valor_activo' => 'activo',
        ],
        'empresa' => [
            'guard' => 'empresa',
            'modelo' => App\Models\Empresa::class,
            'columna_email' => 'email',
            'columna_estado' => 'estado',
            'valor_activo' => 'activo',
        ],
    ],

    'redirect_despues_login' => '/',

    'admin' => [
        'nombres' => env('SEGURIDAD_ADMIN_NAME', 'Administrador'),
        'apellidos' => env('SEGURIDAD_ADMIN_APELLIDOS', 'Sistema'),
        'email' => env('SEGURIDAD_ADMIN_EMAIL', 'admin@admin.com'),
        'password' => env('SEGURIDAD_ADMIN_PASSWORD', '12345678'),
    ],
];

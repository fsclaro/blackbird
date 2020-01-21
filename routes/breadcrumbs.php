<?php

// ================================================================================
// Dashboard
// ================================================================================
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('home'));
});

// ================================================================================
// Permissions
// ================================================================================
Breadcrumbs::for('permissions_access', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Permissões', route('admin.permissions.index'));
});

Breadcrumbs::for('permissions_create', function ($trail) {
    $trail->parent('permissions_access');
    $trail->push('Adiciona');
});

Breadcrumbs::for('permissions_show', function ($trail) {
    $trail->parent('permissions_access');
    $trail->push('Detalhes');
});

Breadcrumbs::for('permissions_edit', function ($trail) {
    $trail->parent('permissions_access');
    $trail->push('Edita');
});

// ================================================================================
// Roles
// ================================================================================
Breadcrumbs::for('roles_access', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Papéis', route('admin.roles.index'));
});

Breadcrumbs::for('roles_create', function ($trail) {
    $trail->parent('roles_access');
    $trail->push('Adiciona');
});

Breadcrumbs::for('roles_show', function ($trail) {
    $trail->parent('roles_access');
    $trail->push('Detalhes');
});

Breadcrumbs::for('roles_edit', function ($trail) {
    $trail->parent('roles_access');
    $trail->push('Edita');
});

// ================================================================================
// Users
// ================================================================================
Breadcrumbs::for('users_access', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Usuários', route('admin.users.index'));
});

Breadcrumbs::for('users_create', function ($trail) {
    $trail->parent('users_access');
    $trail->push('Adiciona');
});

Breadcrumbs::for('users_show', function ($trail) {
    $trail->parent('users_access');
    $trail->push('Detalhes');
});

Breadcrumbs::for('users_edit', function ($trail) {
    $trail->parent('users_access');
    $trail->push('Edita');
});

Breadcrumbs::for('users_profile', function ($trail) {
    $trail->parent('users_access');
    $trail->push('Edita');
});

// ================================================================================
// Settings
// ================================================================================

Breadcrumbs::for('settings_access', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Parâmetros', route('admin.settings.index'));
});

Breadcrumbs::for('settings_create', function ($trail) {
    $trail->parent('settings_access');
    $trail->push('Adiciona');
});

Breadcrumbs::for('settings_show', function ($trail) {
    $trail->parent('settings_access');
    $trail->push('Detalhes');
});

Breadcrumbs::for('settings_edit', function ($trail) {
    $trail->parent('settings_access');
    $trail->push('Edita');
});

Breadcrumbs::for('settings_content', function ($trail) {
    $trail->parent('settings_access');
    $trail->push('Valores');
});

// ================================================================================
// Logs
// ================================================================================

Breadcrumbs::for('logs_access', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Log de Atividades', route('admin.logs.index'));
});

Breadcrumbs::for('logs_show', function ($trail) {
    $trail->parent('logs_access');
    $trail->push('Detalhes');
});

// ================================================================================
// Notifications
// ================================================================================

Breadcrumbs::for('notifications_access', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Notificações', route('admin.notifications.index'));
});

Breadcrumbs::for('notifications_show', function ($trail) {
    $trail->parent('notifications_access');
    $trail->push('Detalhes');
});

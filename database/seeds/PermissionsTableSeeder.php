<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Área de administração do site
        Permission::insert(['title' => 'Acesso à Administração do Site', 'slug' => 'site_management', 'created_at' => now()]);

        // Área de gestão de acesso com: Usuários, Permissões e Papéis
        Permission::insert(['title' => 'Gestão de Acesso', 'slug' => 'access_management', 'created_at' => now()]);

        // Usuários
        Permission::insert(['title' => 'Acessar cadastro de usuários', 'slug' => 'user_access', 'created_at' => now()]);
        Permission::insert(['title' => 'Criar usuário', 'slug' => 'user_create', 'created_at' => now()]);
        Permission::insert(['title' => 'Editar usuário', 'slug' => 'user_edit', 'created_at' => now()]);
        Permission::insert(['title' => 'Exibir usuário', 'slug' => 'user_show', 'created_at' => now()]);
        Permission::insert(['title' => 'Excluir usuário', 'slug' => 'user_delete', 'created_at' => now()]);
        Permission::insert(['title' => 'Editar perfil', 'slug' => 'user_profile', 'created_at' => now()]);

        // Permissões
        Permission::insert(['title' => 'Acessar cadastro de permissões', 'slug' => 'permission_access', 'created_at' => now()]);
        Permission::insert(['title' => 'Criar permissão', 'slug' => 'permission_create', 'created_at' => now()]);
        Permission::insert(['title' => 'Editar permissão', 'slug' => 'permission_edit', 'created_at' => now()]);
        Permission::insert(['title' => 'Exibir permissão', 'slug' => 'permission_show', 'created_at' => now()]);
        Permission::insert(['title' => 'Excluir permissão', 'slug' => 'permission_delete', 'created_at' => now()]);

        // Papéis
        Permission::insert(['title' => 'Acessar cadastro de papéis', 'slug' => 'role_access', 'created_at' => now()]);
        Permission::insert(['title' => 'Criar papel', 'slug' => 'role_create', 'created_at' => now()]);
        Permission::insert(['title' => 'Editar papel', 'slug' => 'role_edit', 'created_at' => now()]);
        Permission::insert(['title' => 'Exibir papel', 'slug' => 'role_show', 'created_at' => now()]);
        Permission::insert(['title' => 'Excluir papel', 'slug' => 'role_delete', 'created_at' => now()]);
        Permission::insert(['title' => 'Clonar papel', 'slug' => 'role_clone', 'created_at' => now()]);

        // Configurações
        Permission::insert(['title' => 'Acessar cadastro de configurações', 'slug' => 'setting_access', 'created_at' => now()]);
        Permission::insert(['title' => 'Criar configuração', 'slug' => 'setting_create', 'created_at' => now()]);
        Permission::insert(['title' => 'Editar configuração', 'slug' => 'setting_edit', 'created_at' => now()]);
        Permission::insert(['title' => 'Exibir configuração', 'slug' => 'setting_show', 'created_at' => now()]);
        Permission::insert(['title' => 'Excluir configuração', 'slug' => 'setting_delete', 'created_at' => now()]);
        Permission::insert(['title' => 'Definir valores das configurações', 'slug' => 'setting_content', 'created_at' => now()]);

        // Logs
        Permission::insert(['title' => 'Acessar log de atividades', 'slug' => 'log_access', 'created_at' => now()]);
        Permission::insert(['title' => 'Acessar Log-Viewer', 'slug' => 'log_viewer_access', 'created_at' => now()]);
        Permission::insert(['title' => 'Excluir log do sistema', 'slug' => 'log_delete', 'created_at' => now()]);
        Permission::insert(['title' => 'Exibir log do sistema', 'slug' => 'log_show', 'created_at' => now()]);

        // Área de suporte
        Permission::insert(['title' => 'Acessar área de suporte', 'slug' => 'support_access', 'created_at' => now()]);
        Permission::insert(['title' => 'Acessar Route-Viewer', 'slug' => 'route_viewer_access', 'created_at' => now()]);
        Permission::insert(['title' => 'Exibir PHPInfo', 'slug' => 'phpinfo_viewer', 'created_at' => now()]);

        // Notificações
        Permission::insert(['title' => 'Acessar notificações', 'slug' => 'notification_access', 'created_at' => now()]);
        Permission::insert(['title' => 'Exibir notificação', 'slug' => 'notification_show', 'created_at' => now()]);
        Permission::insert(['title' => 'Excluir notificação', 'slug' => 'notification_delete', 'created_at' => now()]);
    }
}

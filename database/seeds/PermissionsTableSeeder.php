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
        $this->command->info('Criando as permissões do sistema...');

        // SuperAdmin
        $this->command->info('- Permissão de SuperAdmin');
        Permission::insert(['title' => 'Permissão de SuperAdmin', 'slug' => 'super_admin', 'created_at' => now()]);

        // Área de administração do site
        $this->command->info('- Permissões da área de administração do sistema.');
        Permission::insert(['title' => 'Acesso à Administração do Site', 'slug' => 'site_management', 'created_at' => now()]);

        // Área de gestão de acesso com: Usuários, Permissões e Papéis
        Permission::insert(['title' => 'Gestão de Acesso', 'slug' => 'access_management', 'created_at' => now()]);

        // Usuários
        $this->command->info('- Permissões de acesso ao cadastro de usuários.');
        Permission::insert(['title' => 'Acessar cadastro de usuários', 'slug' => 'user_access', 'created_at' => now()]);
        Permission::insert(['title' => 'Criar usuário', 'slug' => 'user_create', 'created_at' => now()]);
        Permission::insert(['title' => 'Editar usuário', 'slug' => 'user_edit', 'created_at' => now()]);
        Permission::insert(['title' => 'Exibir usuário', 'slug' => 'user_show', 'created_at' => now()]);
        Permission::insert(['title' => 'Excluir usuário', 'slug' => 'user_delete', 'created_at' => now()]);
        Permission::insert(['title' => 'Editar perfil', 'slug' => 'user_profile', 'created_at' => now()]);

        // Permissões
        $this->command->info('- Permissões de acesso ao cadastro de permissões.');
        Permission::insert(['title' => 'Acessar cadastro de permissões', 'slug' => 'permission_access', 'created_at' => now()]);
        Permission::insert(['title' => 'Criar permissão', 'slug' => 'permission_create', 'created_at' => now()]);
        Permission::insert(['title' => 'Editar permissão', 'slug' => 'permission_edit', 'created_at' => now()]);
        Permission::insert(['title' => 'Exibir permissão', 'slug' => 'permission_show', 'created_at' => now()]);
        Permission::insert(['title' => 'Excluir permissão', 'slug' => 'permission_delete', 'created_at' => now()]);

        // Papéis
        $this->command->info('- Permissões de acesso ao cadastro de papéis.');
        Permission::insert(['title' => 'Acessar cadastro de papéis', 'slug' => 'role_access', 'created_at' => now()]);
        Permission::insert(['title' => 'Criar papel', 'slug' => 'role_create', 'created_at' => now()]);
        Permission::insert(['title' => 'Editar papel', 'slug' => 'role_edit', 'created_at' => now()]);
        Permission::insert(['title' => 'Exibir papel', 'slug' => 'role_show', 'created_at' => now()]);
        Permission::insert(['title' => 'Excluir papel', 'slug' => 'role_delete', 'created_at' => now()]);
        Permission::insert(['title' => 'Clonar papel', 'slug' => 'role_clone', 'created_at' => now()]);

        // Configurações
        $this->command->info('- Permissões de acesso ao cadastro de configurações.');
        Permission::insert(['title' => 'Acessar cadastro de configurações', 'slug' => 'setting_access', 'created_at' => now()]);
        Permission::insert(['title' => 'Criar configuração', 'slug' => 'setting_create', 'created_at' => now()]);
        Permission::insert(['title' => 'Editar configuração', 'slug' => 'setting_edit', 'created_at' => now()]);
        Permission::insert(['title' => 'Exibir configuração', 'slug' => 'setting_show', 'created_at' => now()]);
        Permission::insert(['title' => 'Excluir configuração', 'slug' => 'setting_delete', 'created_at' => now()]);
        Permission::insert(['title' => 'Definir valores das configurações', 'slug' => 'setting_content', 'created_at' => now()]);

        // Logs
        $this->command->info('- Permissões de acesso ao cadastro de logs.');
        Permission::insert(['title' => 'Acessar log de atividades', 'slug' => 'log_access', 'created_at' => now()]);
        Permission::insert(['title' => 'Acessar Log-Viewer', 'slug' => 'log_viewer_access', 'created_at' => now()]);
        Permission::insert(['title' => 'Excluir log do sistema', 'slug' => 'log_delete', 'created_at' => now()]);
        Permission::insert(['title' => 'Exibir log do sistema', 'slug' => 'log_show', 'created_at' => now()]);

        // Área de suporte
        $this->command->info('- Permissões de acesso à área de suporte.');
        Permission::insert(['title' => 'Acessar área de suporte', 'slug' => 'support_access', 'created_at' => now()]);
        Permission::insert(['title' => 'Acessar Route-Viewer', 'slug' => 'route_viewer_access', 'created_at' => now()]);
        Permission::insert(['title' => 'Exibir PHPInfo', 'slug' => 'phpinfo_viewer', 'created_at' => now()]);

        // Notificações
        $this->command->info('- Permissões de acesso ao cadastro de notificações.');
        Permission::insert(['title' => 'Acessar notificações', 'slug' => 'notification_access', 'created_at' => now()]);
        Permission::insert(['title' => 'Exibir notificação', 'slug' => 'notification_show', 'created_at' => now()]);
        Permission::insert(['title' => 'Excluir notificação', 'slug' => 'notification_delete', 'created_at' => now()]);
    }
}

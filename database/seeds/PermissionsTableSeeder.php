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
        Permission::insert(['title' => 'Acesso à Administração do Site', 'slug' => 'site_management']);

        // Área de gestão de acesso com: Usuários, Permissões e Papéis
        Permission::insert(['title' => 'Gestão de Acesso', 'slug' => 'access_management']);

        // Usuários
        Permission::insert(['title' => 'Acessar cadastro de usuários', 'slug' => 'user_access']);
        Permission::insert(['title' => 'Criar usuário', 'slug' => 'user_create']);
        Permission::insert(['title' => 'Editar usuário', 'slug' => 'user_edit']);
        Permission::insert(['title' => 'Exibir usuário', 'slug' => 'user_show']);
        Permission::insert(['title' => 'Excluir usuário', 'slug' => 'user_delete']);
        Permission::insert(['title' => 'Editar perfil', 'slug' => 'user_profile']);

        // Permissões
        Permission::insert(['title' => 'Acessar cadastro de permissões', 'slug' => 'permission_access']);
        Permission::insert(['title' => 'Criar permissão', 'slug' => 'permission_create']);
        Permission::insert(['title' => 'Editar permissão', 'slug' => 'permission_edit']);
        Permission::insert(['title' => 'Exibir permissão', 'slug' => 'permission_show']);
        Permission::insert(['title' => 'Excluir permissão', 'slug' => 'permission_delete']);

        // Papéis
        Permission::insert(['title' => 'Acessar cadastro de papéis', 'slug' => 'role_access']);
        Permission::insert(['title' => 'Criar papel', 'slug' => 'role_create']);
        Permission::insert(['title' => 'Editar papel', 'slug' => 'role_edit']);
        Permission::insert(['title' => 'Exibir papel', 'slug' => 'role_show']);
        Permission::insert(['title' => 'Excluir papel', 'slug' => 'role_delete']);
        Permission::insert(['title' => 'Clonar papel', 'slug' => 'role_clone']);

        // Configurações
        Permission::insert(['title' => 'Acessar cadastro de configurações', 'slug' => 'setting_access']);
        Permission::insert(['title' => 'Criar configuração', 'slug' => 'setting_create']);
        Permission::insert(['title' => 'Editar configuração', 'slug' => 'setting_edit']);
        Permission::insert(['title' => 'Exibir configuração', 'slug' => 'setting_show']);
        Permission::insert(['title' => 'Excluir configuração', 'slug' => 'setting_delete']);
        Permission::insert(['title' => 'Definir valores das configurações', 'slug' => 'setting_content']);

        // Logs
        Permission::insert(['title' => 'Acessar log de atividades', 'slug' => 'log_access']);
        Permission::insert(['title' => 'Acessar Log-Viewer', 'slug' => 'log_viewer_access']);
        Permission::insert(['title' => 'Excluir log do sistema', 'slug' => 'log_delete']);
        Permission::insert(['title' => 'Exibir log do sistema', 'slug' => 'log_show']);

        // Área de suporte
        Permission::insert(['title' => 'Acessar área de suporte', 'slug' => 'support_access']);
        Permission::insert(['title' => 'Acessar Route-Viewer', 'slug' => 'route_viewer_access']);
        Permission::insert(['title' => 'Exibir PHPInfo', 'slug' => 'phpinfo_viewer']);

    }
}

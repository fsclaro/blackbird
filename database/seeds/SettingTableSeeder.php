<?php

use App\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Criando os settings do sistema...');

        Setting::insert([
            'description' => 'Brand do Sistema',
            'name' => 'brand_sistema',
            'content' => 'Blackbird',
            'type' => 'text',
            'dataenum' => null,
            'helper' => 'Brand que será utilizado na tela de login e acima da barra de menu.',
            'can_delete' => false,
            'created_at' => now(),
        ]);

        Setting::insert([
            'description' => 'Texto do rodapé do lado esquerdo',
            'name' => 'footer_left',
            'content' => '<span>© 2019-2020 by <a href="https://github.com/fsclaro/blackbird"><span class="text-bold">Blackbird</span></a>. Todos os direitos reservados.</span>',
            'type' => 'text',
            'dataenum' => null,
            'helper' => '',
            'can_delete' => false,
            'created_at' => now(),
        ]);

        Setting::insert([
            'description' => 'Texto do rodapé do lado direito',
            'name' => 'footer_right',
            'content' => 'Versão: <span class="text-bold text-blue">1.0.0</span>',
            'type' => 'text',
            'dataenum' => null,
            'helper' => '',
            'can_delete' => false,
            'created_at' => now(),
        ]);

        Setting::insert([
            'description' => 'Utilizar imagens do Unsplash?',
            'name' => 'use_unsplash',
            'content' => 0,
            'type' => 'select',
            'dataenum' => '0|Não,1|Sim',
            'helper' => 'Utilizar imagens do Unsplash nas telas de logins?',
            'can_delete' => false,
            'created_at' => now(),
        ]);

        Setting::insert([
            'description' => 'Obter IP Externo?',
            'name' => 'get_external_ip',
            'content' => 1,
            'type' => 'select',
            'dataenum' => '0|Não,1|Sim',
            'helper' => 'Obter o endereço do IP externo?',
            'can_delete' => false,
            'created_at' => now(),
        ]);

        Setting::insert([
            'description' => 'URL para obter o IP Externo',
            'name' => 'url_external_ip',
            'content' => 'https://api.ipify.org',
            'type' => 'text',
            'dataenum' => null,
            'helper' => 'Informe a url do servidor que fornecerá o IP externo.',
            'can_delete' => false,
            'created_at' => now(),
        ]);
    }
}

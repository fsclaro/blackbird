<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Session;
use App\Logs;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('setting_access'), 403);

        $settings = Setting::all();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(\Gate::allows('setting_create'), 403);

        return view('admin.settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSettingRequest $request)
    {
        abort_unless(\Gate::allows('setting_create'), 403);

        try {
            $setting = Setting::create($request->all());

            $details = $this->prepareDetailsNew($setting);

            Logs::registerLog('Cadastrou um novo parâmetro do sistema.', $details);

            $this->updateSession();

            alert()->success('Parâmetro criado com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Ocorreu um erro. Este registro não foi criado.')->toToast('top-end');
        }

        return redirect()->route('admin.settings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Setting  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        abort_unless(\Gate::allows('setting_show'), 403);

        Logs::registerLog('Visualizou os detalhes de um parâmetro do sistema.');

        return view('admin.settings.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        abort_unless(\Gate::allows('setting_edit'), 403);

        $this->saveSetting($setting);

        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        abort_unless(\Gate::allows('setting_edit'), 403);

        try {
            $setting->update($request->all());

            $details = $this->prepareDetailsUpdate($this->getSetting(), $setting);

            Logs::registerLog('Alterou dados de um parâmetro do sistema.', $details);

            $this->updateSession();

            alert()->success('Configuração alterado com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Ocorreu um erro. As alterações não foram salvas')->toToast('top-end');
        }

        return redirect()->route('admin.settings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(\Gate::allows('setting_delete'), 403);

        try {
            Setting::where('id', $id)->delete();

            Logs::registerLog('Excluiu um parâmetro do sistema.');
            alert()->success('Configuração excluído com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Este Parâmetro não pode ser excluído')->toToast('top-end');
        }

        return back();
    }

    public function getContent()
    {
        abort_unless(\Gate::allows('setting_content'), 403);

        $settings = Setting::all();
        $this->saveSetting($settings);

        return view('admin.settings.content', compact('settings'));
    }

    public function saveContent(Request $request)
    {
        abort_unless(\Gate::allows('setting_content'), 403);

        $values = $request->all();

        foreach ($values as $key => $value) {
            $fields[] = [
                'name'    => $key,
                'content' => $value,
            ];
        }

        $errors = 0;
        for ($i = 0; $i < count($fields); $i++) {
            if ($fields[$i]['name'] == '_token') {
                continue;
            }

            try {
                Setting::where('name', $fields[$i]['name'])
                    ->update([
                        'content' => $fields[$i]['content'],
                    ]);
            } catch (\Throwable $th) {
                $errors++;
            }
        }

        if ($errors == 0) {
            $this->updateSession();

            $details = $this->prepareDetailsUpdateContent($this->getSetting(), $fields);
            alert()->success('Parâmetros atualizados com sucesso!')->toToast('top-end');
            Logs::registerLog('Alterou os valores dos parâmetros do sistema.', $details);
        } else {
            alert()->error('Algum Parâmetro não pôde ser atualizado')->toToast('top-end');
        }

        return redirect()->route('admin.settings.index');
    }

    public function updateSession()
    {
        $settings = Setting::all();

        foreach ($settings as $setting) {
            Session::put($setting->name, $setting->content);
        }
    }

    /**
     * =================================================================
     * prepara a linha de detalhes do registro na inclusão
     * =================================================================.
     *
     * @param array $new
     * @return void
     */
    public function prepareDetailsNew($new)
    {
        $content = '';

        $fields[] = ['field' => 'ID', 'value' => $new->id];
        $fields[] = ['field' => 'Descrição do Parâmetro', 'value' => $new->description];
        $fields[] = ['field' => 'Slug', 'value' => $new->name];
        $fields[] = ['field' => 'Tipo de Parâmetro', 'value' => $new->type];
        $fields[] = ['field' => 'Radio / Seleção', 'value' => $new->dataenum];
        $fields[] = ['field' => 'Texto de Ajuda', 'value' => $new->helper];
        $fields[] = ['field' => 'Conteúdo', 'value' => $new->content];
        $fields[] = ['field' => 'Pode Excluir?', 'value' => $new->can_delete];

        $content = '
            <table class="table table-striped" width="100%">
                <thead class="thead-light">
                    <th>Campo</th>
                    <th>Valor</th>
                </thead>
                <tbody>';
        for ($i = 0; $i < count($fields); $i++) {
            $content .= '
            <tr>
                <td>'.$fields[$i]['field'].'</td>
                <td>'.$fields[$i]['value'].'</td>
            </tr>';
        }
        $content .= '
                </tbody>
            </table>
        ';

        return $content;
    }

    /**
     * =================================================================
     * prepara a linha de detalhes do registro na operação de alteração
     * =================================================================.
     *
     * @param array $old
     * @param array $new
     * @return void
     */
    public function prepareDetailsUpdate($old, $new)
    {
        $fields[] = ['field' => 'ID', 'oldvalue' => $old->id, 'newvalue' => $new->id];
        $fields[] = ['field' => 'Descrição do Parâmetro', 'oldvalue' => $old->description, 'newvalue' => $new->description];
        $fields[] = ['field' => 'Slug', 'oldvalue' => $old->name, 'newvalue' => $new->name];
        $fields[] = ['field' => 'Tipo de Parâmetro', 'oldvalue' => $old->type, 'newvalue' => $new->type];
        $fields[] = ['field' => 'Radio / Seleção', 'oldvalue' => $old->dataenum, 'newvalue' => $new->dataenum];
        $fields[] = ['field' => 'Texto de Ajuda', 'oldvalue' => $old->helder, 'newvalue' => $new->helper];
        $fields[] = ['field' => 'Conteúdo', 'oldvalue' => $old->content, 'newvalue' => $new->content];
        $fields[] = ['field' => 'Pode Excluir?', 'oldvalue' => $old->can_delete, 'newvalue' => $new->can_delete];

        $content = '
            <table class="table table-striped" width="100%">
                <thead class="thead-light">
                    <th>Campo</th>
                    <th>Valor Anterior</th>
                    <th>Valor Novo</th>
                </thead>
                <tbody>';

        for ($i = 0; $i < count($fields); $i++) {
            $content .= '
            <tr>
                <td>'.$fields[$i]['field'].'</td>
                <td>'.$fields[$i]['oldvalue'].'</td>
                <td>'.$fields[$i]['newvalue'].'</td>
            </tr>';
        }
        $content .= '
                </tbody>
            </table>
        ';

        return $content;
    }

    /**
     * =================================================================
     * prepara a linha de detalhes do registro na operação de alteração
     * =================================================================.
     *
     * @param array $old
     * @param array $new
     * @return void
     */
    public function prepareDetailsUpdateContent($old, $new)
    {
        // converte em array
        foreach ($old as $key => $value) {
            $oldFields[] = [
                'name' => $value->name,
                'value' => $value->content,
            ];
        }

        // remove o campo _token do array
        $new = array_splice($new, 1);

        for ($i = 0; $i < count($new); $i++) {
            $fields[] = [
                'field' => $oldFields[$i]['name'],
                'oldvalue' => $oldFields[$i]['value'],
                'newvalue' => $new[$i]['content'],
            ];
        }

        $content = '
            <table class="table table-striped" width="100%">
                <thead class="thead-light">
                    <th>Campo</th>
                    <th>Valor Anterior</th>
                    <th>Valor Novo</th>
                </thead>
                <tbody>';

        for ($i = 0; $i < count($fields); $i++) {
            $content .= '
            <tr>
                <td>'.$fields[$i]['field'].'</td>
                <td>'.$fields[$i]['oldvalue'].'</td>
                <td>'.$fields[$i]['newvalue'].'</td>
            </tr>';
        }
        $content .= '
                </tbody>
            </table>
        ';

        return $content;
    }

    /**
     * =================================================================
     * salva numa session os dados do registro atual
     * =================================================================.
     *
     * @param array $setting
     * @return void
     */
    private function saveSetting($setting)
    {
        Session::put('setting', $setting);
    }

    /**
     * =================================================================
     * recupera os dados salvos do registro atual
     * =================================================================.
     *
     * @return void
     */
    private function getSetting()
    {
        $r = Session::get('setting');
        Session::forget('setting');

        return $r;
    }
}

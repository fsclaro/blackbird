<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Session;
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

            alert()->success('Configuração criada com sucesso!')->toToast('top-end');
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
            $setting->save();
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
    public function destroy(Setting $setting)
    {
        abort_unless(\Gate::allows('setting_delete'), 403);

        try {
            $setting->delete();
            alert()->success('Configuração excluído com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Este Configuração não pode ser excluído')->toToast('top-end');
        }

        return back();
    }

    public function getContent()
    {
        abort_unless(\Gate::allows('setting_content'), 403);

        $settings = Setting::all();

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
            alert()->success('Configuraçãos atualizados com sucesso!')->toToast('top-end');
        } else {
            alert()->error('Algum Configuração não pôde ser atualizado')->toToast('top-end');
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
}

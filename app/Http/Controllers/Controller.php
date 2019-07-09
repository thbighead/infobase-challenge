<?php

namespace App\Http\Controllers;

use Str;
use Arr;
use Route;
use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Watson\Validating\ValidationException;
use Yajra\Datatables\Services\DataTable;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function coreIndex(DataTable $dataTable, $with = [], $data = [])
    {
        $routeName = Route::currentRouteName();
        $lcsingularmodel = explode('.', $routeName)[0];
        $model = 'App\\' . Str::studly($lcsingularmodel);
        $title = $model::$ptBrPluralName;

        if (Arr::has($data, 'title'))
            return $dataTable->with($with)->render("modelings.$routeName", $data, [
                'model' => $lcsingularmodel,
            ]);
        else
            return $dataTable->with($with)->render("modelings.$routeName", $data, [
                'title' => $title,
                'model' => $lcsingularmodel,
            ]);
    }

    protected function coreCreate($with = [])
    {
        $lcsingularmodel = explode('.', Route::currentRouteName())[0];

        if (!Arr::has($with, 'title')) {
            $model = 'App\\' . Str::studly($lcsingularmodel);
            $with['title'] = 'Cadastrar ' . $model::$ptBrPluralName;
        }

        return view("modelings.$lcsingularmodel.create")->with($with);
    }

    protected function coreStore($inputs = [], $mapping = [], $NxNRelationships = [])
    {
        $originalInputs = $inputs;
        $lcsingularmodel = explode('.', Route::currentRouteName())[0];
        $model = 'App\\' . Str::studly($lcsingularmodel);
        $object = new $model();
        $fillables = $object->getFillable();

        foreach ($mapping as $input_name => $db_meaning) {
            if (Arr::has($inputs, $input_name)) {
                $inputs = $inputs + $db_meaning;
                unset($inputs[$input_name]);
            }
        }

        $filledInputs = Arr::only($inputs, $fillables);

        $object = new $model($filledInputs);
        try {
            $success = (bool)$object->saveOrFail();
            foreach ($NxNRelationships as $relatedModel) {
                if (Arr::has($inputs, $relatedModel))
                    $object->$relatedModel()->attach($inputs[$relatedModel]);
            }

            return redirect()->back()->with('success', $success);
        } catch (ValidationException $e) {
            $errors = $e->getErrors();
            foreach ($mapping as $input_name => $db_meaning) {
                $column_name = array_keys($db_meaning)[0];
                if ($errors->has($column_name)) {
                    foreach ($errors->get($column_name) as $error) {
                        $errors->add($input_name, $error);
                    }
                }
            }
            return redirect()->back()->withErrors($errors)->withInput($originalInputs);
        }
    }

    protected function coreShow($object, $with = [])
    {
        $lcsingularmodel = explode('.', Route::currentRouteName())[0];

        if (!Arr::has($with, 'title')) {
            $model = 'App\\' . Str::studly($lcsingularmodel);
            $with['title'] = $model::$ptBrPluralName . " id {$object->id}";
        }

        return view("modelings.$lcsingularmodel.show", ['object' => $object->toArray()])->with($with);
    }

    protected function coreEdit($object, $with = [])
    {
        $lcsingularmodel = explode('.', Route::currentRouteName())[0];
        $with = array_merge($with, ['method_field' => 'PUT']);

        if (!Arr::has($with, 'title')) {
            $model = 'App\\' . Str::studly($lcsingularmodel);
            $with['title'] = 'Editar ' . $model::$ptBrPluralName;
        }

        return view("modelings.$lcsingularmodel.edit", ['object' => $object->toArray()])->with($with);
    }

    protected function coreUpdate($id, $inputs = [], $mapping = [], $NxNRelationships = [])
    {
        $originalInputs = $inputs;
        $lcsingularmodel = explode('.', Route::currentRouteName())[0];
        $model = 'App\\' . Str::studly($lcsingularmodel);
        $object = new $model();
        $fillables = $object->getFillable();

        foreach ($mapping as $input_name => $db_meaning) {
            if (Arr::has($inputs, $input_name)) {
                $inputs = $inputs + $db_meaning;
                unset($inputs[$input_name]);
            }
        }

        $filledInputs = Arr::only($inputs, $fillables);

        $object = $model::findOrFail($id);
        $object->fill($filledInputs);
        try {
            $success = (bool)$object->saveOrFail();
            foreach ($NxNRelationships as $relatedModel) {
                if (Arr::has($inputs, $relatedModel))
                    $object->$relatedModel()->sync($inputs[$relatedModel]);
            }

            return redirect()->back()->with('success', $success);
        } catch (ValidationException $e) {
            $errors = $e->getErrors();
            foreach ($mapping as $input_name => $db_meaning) {
                $column_name = array_keys($db_meaning)[0];
                if ($errors->has($column_name)) {
                    foreach ($errors->get($column_name) as $error) {
                        $errors->add($input_name, $error);
                    }
                }
            }
            return redirect()->back()->withErrors($errors)->withInput($originalInputs);
        }
    }

    protected function coreDestroy($id)
    {
        $model = 'App\\' . Str::studly(explode('.', Route::currentRouteName())[0]);

        try {
            $model::findOrFail($id)->delete();
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json(['success' => false]);
        }
    }
}

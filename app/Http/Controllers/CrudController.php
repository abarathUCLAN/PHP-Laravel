<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Invitation;
use App\Project;
use App\User;
use Input;

class CrudController extends Controller
{
    const MODEL_KEY = 'model';

    protected $modelsMapping = [
        'users' => User::class,
        'projects' => Project::class,
        'invitations' => Invitation::class
    ];

    protected function getModel()
    {
        $modelKey = Input::get(static::MODEL_KEY);
        if (array_key_exists($modelKey, $this->modelsMapping)) {
            return $this->modelsMapping[$modelKey];
        }

        throw new \InvalidArgumentException('Invalid model');
    }

    public function index()
    {
        $model = $this->getModel();
        return $model::all();
    }

    public function store()
    {
        $model = $this->getModel();
        return $model::create(array_except(Input::all(), static::MODEL_KEY));
    }

    public function show($id)
    {
        $model = $this->getModel();
        return $model::findOrFail($id);
    }

    public function update($id)
    {
        $model = $this->getModel();
        $object = $model::findOrFail($id);
        return $object->update(array_except(Input::all(), static::MODEL_KEY));
    }

    public function destroy($id)
    {
        $model = $this->getModel();
        return $model::remove($id);
    }
}

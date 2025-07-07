<?php

namespace App\Http\Controllers\Tablas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tablas\Produccion;
use App\Models\Projects\Project;
use App\Models\Clients\Client;
use Illuminate\Support\Facades\DB;

class TablasController extends Controller
{
    public function index($project_id)
    {
        $project = Project::findOrFail($project_id);
        $client = Client::where('id', $project->client_id)->first();
        $produccion = Produccion::where('cliente_id', $client->id)->where('project_id', $project->id)->latest()->first();
        $data = Produccion::where('cliente_id',$client->id)->latest()->first();

        return view('tablas.index', compact('project', 'client', 'data'));
    }
}
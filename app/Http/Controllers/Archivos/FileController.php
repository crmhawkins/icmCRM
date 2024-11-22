<?php

namespace App\Http\Controllers\Archivos;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function manager()
    {
        return view('file-manager.manager');
    }


}

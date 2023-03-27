<?php

namespace App\Http\Controllers;

use App\Exports\DataExport;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    //

    public function Export()
    {
        return Excel::download(new DataExport, 'Filiere.xlsx');
        
        
    }
}

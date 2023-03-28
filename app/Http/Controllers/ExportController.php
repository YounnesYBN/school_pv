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
        $file_name = "calcul_demande_sur_la_base_+_CARTE_FORMATION_REALISEE ".now();
        return Excel::download(new DataExport, "$file_name.xlsx");
        
        
    }
}

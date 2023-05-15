<?php

namespace App\Http\Controllers;

use App\Exports\ExportselectedData;
use App\Models\DataExport;
use App\Models\Export;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use PDOException;
use Maatwebsite\Excel\Facades\Excel;

class ExportTableController extends Controller
{
    //
    protected $exportModel = null;

    public function InsertData($data)
    {
        try {
            DB::beginTransaction();
            $newExport  = new Export();
            $newExport->export_date =  Carbon::now();
            $newExport->save();

            $x = array_map(function ($row) {
                $ExportDataOBJ = new DataExport();
                $ExportDataOBJ->code_filiere = $row[0];
                $ExportDataOBJ->filiere_nom = $row[1];
                $ExportDataOBJ->annee = $row[2];
                $ExportDataOBJ->elements_de_traitement = $row[3];
                $ExportDataOBJ->aspeets_tailer = $row[4];
                $ExportDataOBJ->donnees = $row[5];
                $ExportDataOBJ->commentaires = $row[6];
                return $ExportDataOBJ;
            }, $data);

            $newExport->data_export()->saveMany($x);

            DB::commit();
        } catch (PDOException $th) {
            DB::rollBack();
            return dd($th);
        }
    }

    public function deleteExport($id)
    {

        Export::where("id", $id)->delete();
        return redirect()->back();
    }


    public function export($id)
    {

        $export = Export::find($id);
        $data = DataExport::where("export_id", $id)->get(["code_filiere", "filiere_nom", "annee", "elements_de_traitement", "aspeets_tailer", "donnees", "commentaires"]);
        $file_name = "calcul_demande_sur_la_base_+_CARTE_FORMATION_REALISEE ".$export->export_date;
        return Excel::download((new ExportselectedData($data)),"$file_name.xlsx");
    }
}

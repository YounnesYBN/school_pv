<?php

namespace App\Exports;

use App\Models\DataExport;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class ExportselectedData implements FromCollection,WithHeadings
{
    protected $data  = [];

    public function __construct($data)
    {
        $this->data = $data ;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return new Collection($this->data);
    }

    public function headings(): array
    {
        return [
            "CODE Filiere", "FILIERE NOM", "ANNEE", "ELÉMENTS DE TRAITEMENT", "ASPEETS À TRAILER", "LES DONNÉES", "COMMENTAIRES"
        ];
    }
}

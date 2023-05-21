<?php

namespace Database\Seeders;

use App\Models\Aspeet;
use App\Models\Element;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FillDatabase extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $json = storage_path("aspeet_element.json");
        $data = json_decode(file_get_contents($json), true);
        $types = $data["types"];
        $aspeets = $data["aspeet"];



        try {
            //code...
            //throw $th;
            DB::beginTransaction();


            //save types 
            array_map(function ($typeEle) {
                $typeOBJ = new Type();
                $typeOBJ->type_name = $typeEle["name"];
                $typeOBJ->save();
            }, $types);

            //save aspeets with its elements
            array_map(function ($aspeetEle) {
                $all_element_of_aspeet = [];
                $aspeetOBJ = new Aspeet();
                $aspeetOBJ->value = $aspeetEle["name"];
                $aspeetOBJ->save();
                foreach ($aspeetEle["element"] as $element) {
                    $elementOBJ = new Element();
                    $elementOBJ->name = $element["name"];
                    $elementOBJ->type_comment = $element["type_comment"];
                    $all_element_of_aspeet[] = $elementOBJ;
                }
                $aspeetOBJ->element()->saveMany($all_element_of_aspeet);
            }, $aspeets);

            //save for each type its aspeet
            array_map(function ($typeVar) {
                $typeOBJ = Type::where("type_name", $typeVar["name"])->first();
                foreach ($typeVar["aspeet"] as $aspeetValue) {
                    $aspeetOBJ = Aspeet::where("value", $aspeetValue)->first();
                    DB::table("typs_aspeets")->insert([
                        "type_id" => $typeOBJ->id,
                        "aspeet_id" => $aspeetOBJ->id,
                    ]);
                }
            }, $types);

            DB::commit();
        } catch (\PDOException $th) {
            DB::rollback();
        }
    }
}

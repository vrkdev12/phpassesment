<?php

namespace App\Imports;

use App\Router;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToArray;
use Illuminate\Support\Facades\Validator;
use App\Rules\MacAddress;

class RouterImport implements WithHeadingRow,  ToArray, SkipsOnFailure
{
    /**
     * Using Importable trait
     */
    use Importable, SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function model(array $row)
    // {
    //     return new Router([
    //         'sap_id'     => $row['sap_id'],
    //         'host_name'    => $row['host_name'], 
    //         'loop_back'    => $row['loop_back'], 
    //         'mac_address'    => $row['mac_address']
    //     ]);
    // }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function array(array $rows)
    {
        Validator::make($rows, [
            '*.sap_id' => 'required|max:18|unique:router_details',
            '*.host_name' => 'required|max:14|unique:router_details',  
            '*.loop_back' => 'required|ipv4|unique:router_details',      
            '*.mac_address' => ['required','max:17','unique:router_details', new MacAddress],           
        ]);
  
    }

    // public function rules(): array
    // {
    //     // return [
    //     //     '*.sap_id' => 'required|max:18|unique:router_details',
    //     //     '*.host_name' => 'required|max:14|unique:router_details',  
    //     //     '*.loop_back' => 'required|ipv4|unique:router_details',      
    //     //     '*.mac_address' => ['required','max:17','unique:router_details', new MacAddress],           
    //     // ];
    //     return [
    //         '*.sap_id' => ['required'],
    //         '*.host_name' => ['required'],
    //         '*.loop_back' => ['required'],
    //         '*.mac_address' => ['required'],
    //     ];
    // }



}

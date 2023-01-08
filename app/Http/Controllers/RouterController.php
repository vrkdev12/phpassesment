<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Imports\RouterImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\MacAddress;
use App\Router;

class RouterController extends Controller
{

    /**
    * @param Router
    */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
       $routers = $this->router->orderBy('id', 'DESC')->get();
       return view('router.index', compact('routers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'router_file' => 'required|mimes:xls,xlsx'          
            ]);

            // If validation fails send error
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            // Import the Excel file and get the data into array format to display on the 
            // page without storing into the database
            $routers = (new RouterImport)->toArray($request->file('router_file'));
       
            // Validate the excel array data
            $validator = Validator::make($routers[0], [
                '*.sap_id' => 'required|distinct|size:18|unique:router_details',
                '*.host_name' => 'required|distinct|size:14|unique:router_details',  
                '*.loop_back' => 'required|distinct|ipv4|unique:router_details',      
                '*.mac_address' => ['required','distinct','size:17','unique:router_details','regex:/^((([a-f0-9]{2}:){5})|(([a-f0-9]{2}-){5}))[a-f0-9]{2}$/i'],           
            ]);
            $routers = $routers[0];
            if($validator->fails()) {
                $validator = $validator->messages()->get('*');
                return redirect()->back()->withErrors($validator)->with('routers', $routers)->with('validations', $validator);
            }
            
            return redirect()->back()->with('success', 'Routers Imported Successfully!')->with('routers', $routers);

        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', 'Something went wrong');
        }
        
    }

    /**
    * Collect the form data and store bulk into the database
    *
    * @return Response
    */
    public function storeAll(Request $request)
    {
        try {
            $all = $request->except(['_token']);
            if(empty($all)) {
                return redirect()->back();
            }
            $all_routers = [];
            foreach ($all as $key => $value) {
                $router = [];
                foreach ($value as $item => $val) {
                    $row = [
                        'sap_id' => $all['sap_id'][$item],
                        'host_name' => $all['host_name'][$item],
                        'loop_back' => $all['loop_back'][$item],
                        'mac_address' => $all['mac_address'][$item]
                    ];
                $router[] = $row;
                }
            }
            $all_routers = $router;
        
            // Validate the array of routers values
            $validator = Validator::make($all_routers, [
                '*.sap_id' => 'required|distinct|size:18|unique:router_details',
                '*.host_name' => 'required|distinct|size:14|unique:router_details',  
                '*.loop_back' => 'required|distinct|ipv4|unique:router_details',      
                '*.mac_address' => ['required','distinct','size:17','unique:router_details', 'regex:/^((([a-f0-9]{2}:){5})|(([a-f0-9]{2}-){5}))[a-f0-9]{2}$/i'],           
            ]);

    
            // If validation fails send error along with data to display
            if($validator->fails()) {
                $validator = $validator->messages()->get('*');
                return redirect()->back()->withErrors($validator)->with('routers', $all_routers)->with('validations', $validator);
            }
        
            // If success store all the imported data into database and return with success message
            $router = $this->router->insert($all_routers);
            return redirect()->back()->with('success', 'Routers Imported Successfully!')->with('routers', $all_routers);
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', 'Something went wrong');
        }
      
    }

}

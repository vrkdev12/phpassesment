<form action="{{ route('router.store.all') }}" method="POST" enctype="multipart/form-data">
<table id="example" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <td>Id</td>
            <th>SapId</th>
            <th>Hostname</th>
            <th>Loopback</th>
            <th>Mac Address</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
    
     @csrf
        @if (\Session::has('routers'))
        @php
        $routers = Session::get('routers');  
        $validations = Session::get('validations'); 
        @endphp
            @foreach ($routers as $router)
                @php
                //check the validation error and highlight the color accoridngly
                // Validate sap_id 
                $sap_id_error = false;
                if (array_key_exists($loop->index.'.sap_id', $validations)) {
                    $sap_id_error = true;
                    $erroClass_sap = 'rederrorClass';
                    if(strpos($validations[$loop->index.'.sap_id'][0], 'duplicate') || strpos($validations[$loop->index.'.sap_id'][0], 'already been taken')) {
                        $erroClass_sap = 'grayerrorClass';
                    }
                }
                // Validate host name 
                $host_name_error = false;
                if (array_key_exists($loop->index.'.host_name', $validations)) {
                    $host_name_error = true;
                    $erroClass_host = 'rederrorClass';
                    if(strpos($validations[$loop->index.'.host_name'][0], 'duplicate') || strpos($validations[$loop->index.'.host_name'][0], 'already been taken')) {
                        $erroClass_host = 'grayerrorClass';
                    }
                }
                // Validate loop back 
                $loop_back_error = false;
                if (array_key_exists($loop->index.'.loop_back', $validations)) {
                    $loop_back_error = true;
                    $erroClass_loop = 'rederrorClass';
                    if(strpos($validations[$loop->index.'.loop_back'][0], 'duplicate') || strpos($validations[$loop->index.'.loop_back'][0], 'already been taken')) {
                        $erroClass_loop = 'grayerrorClass';
                    }
                }
                // Validate mac address 
                $mac_address_error = false;
                if (array_key_exists($loop->index.'.mac_address', $validations)) {
                    $mac_address_error = true;
                    $erroClass_mac = 'rederrorClass';
                    if(strpos($validations[$loop->index.'.mac_address'][0], 'duplicate') || strpos($validations[$loop->index.'.mac_address'][0], 'already been taken')) {
                        $erroClass_mac = 'grayerrorClass';
                    }
                }
                @endphp
                <tr>
                    <td>{{  $loop->index }}</td>
                    <td><input type="text" name="sap_id[]" value="{{ $router['sap_id'] }}" class="{{ ($sap_id_error==true) ? $erroClass_sap : '' }}" ></td>
                    <td><input type="text" name="host_name[]" value="{{ $router['host_name'] }}" class="{{ ($host_name_error==true) ? $erroClass_host : '' }}" ></td>
                    <td><input type="text" name="loop_back[]" value="{{ $router['loop_back'] }}" class="{{ ($loop_back_error==true) ? $erroClass_loop : '' }}" ></td>
                    <td><input type="text" name="mac_address[]" value="{{ $router['mac_address'] }}" class="{{ ($mac_address_error==true) ? $erroClass_mac : '' }}" ></td>
                    <td><button type="button" class="btn btn-danger btn-sm delete" id="delete">Delete</button></td>
                </tr>  
           
            @endforeach
        @endif
        
       
    </tbody>

</table>

<button class="btn btn-info" type="submit" id="inputGroupFileAddon04">Update All</button>


<div class="row">
    <div class="col-md-6">
        <b><br>EXAMPLE:</b>
        <p>SAP ID : I-XX-XXXX-XXX-0005<br>
        HOST NAME : ABCDABCDXYZ001<br>
        LOOP BACK (IPV4) : 127.0.0.1<br>
        MAC ADDRESS : XX-25-X5-55-XX-88
        </p>
        
    </div>
    <div class="col-md-6">
        <input disabled type="text" value="RED : Validation Errors" style="margin-top:5px;background:#e8a1a7;"><br>
        <input disabled type="text" value="GRAY : Duplication Errors" style="margin-top:15px;background:#ada9a9;">
    </div>
</div>

</form>
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Router extends Model
{
    
  /**
  * @var string
  */
  protected $table = 'router_details';

  /**
  * @var boolean
  */
  public $timestamps = false;

  /**
  * @var array
  */
  protected $fillable = [
    'sap_id', 'host_name', 'loop_back', 'mac_address'
  ];

}

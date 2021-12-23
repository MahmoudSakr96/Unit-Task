<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class taskController extends Controller
{
    //
    public function index(){
        // redirect to login page with redirect_uri parameter with value tokenRoute in localhost 

        return redirect("http://gps.tawasolmap.com/login.html?redirect_uri=http://127.0.0.1:8000/tokenRoute");
    }
    public function token(){
        // call login API with token parameter to get Sid
        $params['svc']='token/login';
        $params['params']='{"token":"'.$_GET['access_token'].'"}';
        $m=Http::get('http://gps.tawasolmap.com/wialon/ajax.html',$params ) ;
        
       // call search_items API with Sid parameter to get items Details

        $parameters['svc']='core/search_items';
        $parameters['params']='{"spec":{"itemsType":"avl_unit","propName":"sys_name","propValueMask":"*","sortType":"sys_name"},"force":1,"flags":13644935,"from":0,"to":4294967295}';
        $parameters['sid']=$m->object()->eid;
        $dddf=Http::get('http://gps.tawasolmap.com/wialon/ajax.html',$parameters) ;
       
       
       
        $item=[];
        $sensor=[];
        $position=[];
        $positionName=[];       
        $itemsobj=$dddf->object()->items;

        // Filter Response to get needed Data  
        for($i=0;$i<count($itemsobj);$i++){
            $item[$i]=$itemsobj[$i]->nm;
            $position[$i]['y']=$itemsobj[$i]->pos->y;
            $position[$i]['x']=$itemsobj[$i]->pos->x;
            $position[$i]['s']=$itemsobj[$i]->pos->s;
            
            $x=0;
            foreach($itemsobj[$i]->sens as  $sens){
                $sensor[$i][$x]=$sens->n;
             
            }
        }
        for($y=0;$y<count($position);$y++){
            $posparams['coords']='[{"lon":'.$position[$y]['y'].',"lat":'.$position[$y]['x'].'}]';
            $posparams['flags']='13644935';
            $posparams['uid']='62289';
            $posparams['sid']=$m->object()->eid;
            $pos=Http::get('http://gps.tawasolmap.com/gis_geocode',$posparams) ;
            $positionName[$y]=((array)$pos->body())[0];

        }


        $data['item']=$item;
        $data['sensor']=$sensor;
        $data['adress']=(array)$positionName;
        

        return view('index',$data);

    }
}

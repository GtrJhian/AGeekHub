<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//===============Defined Classes=============================//
class Series{
    public function getDataTable(){
        $obj=array();
        $sum=0;
        //$real_sin=sin($this->x);
        for($ctr=0;$ctr<$this->n;$ctr++){
            $sum+=($term=$this->term($ctr));
            $obj[$ctr]=new \stdClass();
            $obj[$ctr]->n=$ctr;
            $obj[$ctr]->term=number_format($term,$this->d,'.',',');
            $obj[$ctr]->total=number_format($sum,$this->d,'.',',');
            $obj[$ctr]->error=number_format(abs(($sum-$this->real)*100/$this->real),2,'.',',')."%";
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($obj),
            "iTotalDisplayRecords" => count($obj),
            "aaData"=>$obj);
        return json_encode($results);
    }
    //------------------PRIVATE FUNCTIONS----------------------//
    protected function f($x){
        return $x<=1?1:$x--*$this->f($x);
    }
    protected function p($x,$n){
        return $n--==0?1:$x*$this->p($x,$n);
    }
}

class MaclaurinSin extends Series{
    function __construct($x,$n,$d){
        $this->x=$x;
        $this->n=$n;
        $this->d=$d;
        $this->real=sin($x);
    }
    function getValue(){ //get Series Computed Value
        $sum=0;
        for($ctr=0;$ctr<$this->n;$ctr++){
            $sum+=$this->term($ctr);
        }
        return number_format($sum,$this->d,'.',',');
    }
    function getStringEquation(){
        $str="y=";
        for($ctr=0;$ctr<$this->n;$ctr++){
            $str.=$this->p(-1,$ctr)>0?'+':'-';
            $str.="x^{\\left(2*$ctr+1\\right)}";
            $str.="/(2*$ctr+1)!";
        }
        return $str;
    }
    //==================PROTECTED FUNCTIONS===========================//
    protected function term($ctr){
        return $this->p(-1,$ctr)*$this->p($this->x,2*$ctr+1)/$this->f(2*$ctr+1);
    }
    //==================PROTECTED FUNCTIONS===========================//
}

class MaclaurinCos extends Series{
    function __construct($x,$n,$d){
        $this->x=$x;
        $this->n=$n;
        $this->d=$d;
        $this->real=cos($x);
    }
    function getValue(){
        $sum=0;
        for($ctr=0;$ctr<$this->n;$ctr++){
            $sum+=$this->term($ctr);
        }
        return number_format($sum,$this->d,'.',',');
    }
    function getStringEquation(){
        $str="y=";
        for($ctr=0;$ctr<$this->n;$ctr++){
            $str.=$this->p(-1,$ctr)>0?'+':'-';
            $str.="x^{\\left(2*$ctr\\right)}";
            $str.="/(2*$ctr)!";
        }
        return $str;
    }
    //======================PROTECTED==========================//
    protected function term($ctr){
        return $this->p(-1,$ctr)*$this->p($this->x,2*$ctr)/$this->f(2*$ctr);
    }
    //======================PROTECTED==========================//
}

class Maclaurinln_x_plus_1 extends Series{
    function __construct($x,$n,$d){
        $this->x=$x;
        $this->n=$n;
        $this->d=$d;
        $this->real=log($x+1);
    }
    function getValue(){
        $sum=0;
        for($ctr=0;$ctr<$this->n;$ctr++){
             $sum+=$this->term($ctr);
        }
        return number_format($sum,$this->d,'.',',');
    }
    function getStringEquation(){
        $str="y=";
        for($ctr=0;$ctr<$this->n;$ctr++){
            $str.=$this->p(-1,$ctr)>0?'+':'-';
            $str.="x^{\\left($ctr+1\\right)}";
            $str.="/($ctr+1)";
        }
        return $str;
    }
    function getDataTable(){
        $sum=0;
        $obj=array();
        $real=log($this->x+1);
        for($ctr=0;$ctr<$this->n;$ctr++){
             $sum+=($term=$this->p(-1,$ctr)*$this->p($this->x,$ctr+1)/($ctr+1));
             $obj[$ctr]=new \stdClass();
             $obj[$ctr]->n=$ctr;
             $obj[$ctr]->term=number_format($term,$this->d,'.',',');
             $obj[$ctr]->error=number_format(abs(($real-$sum)*100/$real),2,'.',',')."%";
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($obj),
            "iTotalDisplayRecords" => count($obj),
            "aaData"=>$obj);
        return json_encode($results);
    }
    //======================PROTECTED===========================//
    protected function term($ctr){
        return $this->p(-1,$ctr)*$this->p($this->x,$ctr+1)/($ctr+1);
    }
    //======================PROTECTED===========================//
}

//===============Defined Classes=============================//
class MaclaurinSeriesController extends Controller
{
    function sin($x,$n,$d,$a='default'){
        if($a=="eq") return (new MaclaurinSin($x,$n,$d))->getStringEquation();
        else if($a=="datatable") return (new MaclaurinSin($x,$n,$d))->getDataTable();
        else if($a=="real") return number_format(sin($x),$d,'.',',');
        else return (new MaclaurinSin($x,$n,$d))->getValue();
    }
    function cos($x,$n,$d,$a='default'){
        if($a=='eq')return (new MaclaurinCos($x,$n,$d))->getStringEquation();
        else if($a=="datatable") return (new MaclaurinCos($x,$n,$d))->getDataTable();
        else if($a=="real") return number_format(cos($x),$d,'.',',');
        else return (new MaclaurinCos($x,$n,$d))->getValue();
    }
    function ln_x_plus_1($x,$n,$d,$a='default'){        
        if($a=='eq')return (new Maclaurinln_x_plus_1($x,$n,$d))->getStringEquation();
        else if($a=="datatable")return (new Maclaurinln_x_plus_1($x,$n,$d))->getDataTable();
        else if($a=='real')return number_format(log($x+1),$d,'.',',');
        else return (new Maclaurinln_x_plus_1($x,$n,$d))->getValue();
    }
}

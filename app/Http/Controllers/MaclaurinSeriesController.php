<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaclaurinSeriesController extends Controller
{
    function sin($x,$n,$d){
        $sum=0;
        for($ctr=0;$ctr<$n;$ctr++){
            $sum+=$this->p(-1,$ctr)*$this->p($x,2*$ctr+1)/$this->f(2*$ctr+1);
        }
        return number_format($sum,$d,'.',',');
    }
    function cos($x,$n,$d){
        $sum=0;
        for($ctr=0;$ctr<$n;$ctr++){
            $sum+=$this->p(-1,$ctr)*$this->p($x,2*$ctr)/$this->f(2*$ctr);
        }
        return number_format($sum,$d,'.',',');
    }
    function ln_x_plus_1($x,$n,$d){
        $sum=0;
        for($ctr=0;$ctr<$n;$ctr++){
             $sum+=$this->p(-1,$ctr)*$this->p($x,$ctr+1)/($ctr+1);
        }
        return number_format($sum,$d,'.',',');
    }
    //------------------PRIVATE FUNCTIONS----------------------//
    private function f($x){
        return $x<=1?1:$x--*$this->f($x);
    }
    private function p($x,$n){
        return $n--==0?1:$x*$this->p($x,$n);
    }
}

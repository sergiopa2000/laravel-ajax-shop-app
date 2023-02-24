<?php

namespace App\Classes;

class QueryHelper {

    public static function checkParameterIn($array, $value, $default, $compoundKey, $compoundSeparator = '&') {
        
        if(is_array($value)){
            $result = [];
            foreach ($value as $val) {
                $find = array_search($val, $array);
                if($find) {
                    $result[] = $find;
                }
            }
            
            return $result;
        }
        
        $find = array_search($value, $array);
        if(!$find) {
            return $default;
        }
        
        if($compoundKey){
            $oldfind = $find;
            $find = explode($compoundSeparator, $find);
            if(count($find) == 1){
                $find = $oldfind;
            }
        }
        
        return $find;
    }
    
    public static function getUrls($parameter, $link, $values, $queryString, $compound = false, $compoundSeparator = '&'){
        $url = [];
        
        if($compound){
            $oldquery = $queryString[$parameter];
            $alreadyIn = explode($compoundSeparator, $oldquery);
        }
        
        foreach ($values as $index => $value) {
            $queryString[$parameter] = null;
            if($compound){
                if(!$oldquery) {
                    $queryString[$parameter] = $value;
                } else if(!in_array($value, $alreadyIn)) {
                    $queryString[$parameter] = $oldquery . $compoundSeparator . $value;
                } else {
                    $inCopy = [...$alreadyIn];
                    unset($inCopy[array_search($value, $inCopy)]);
                    foreach (array_unique($inCopy) as $in) {
                        if(in_array($in, $values)){
                            $queryString[$parameter] .= $in . $compoundSeparator;
                        }
                    }
                }
            }else{
                 $queryString[$parameter] = $value;
            }
            $url[$index] = route($link, $queryString);
        }
        
        $queryString[$parameter] = null;
        $url['unset'] = route($link, $queryString);
        
        return $url;
    }
    
    public static  function getCompoundParam($paramArray, $values, $separator = ','){
        if(!$values || !$paramArray){
            return null;
        }
        
        $param = "";
        
        foreach ($values as $value) {
            $param .= $paramArray[$value] . ',';
        }
        
        return substr($param, 0, strlen($param) - 1);
    }

}
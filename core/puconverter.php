<?php
function length_converter($value,$fromUnit,$toUnit){
  if(is_numeric($value)){
    switch($fromUnit){
      case'km':
        if($toUnit==='m')return$value * 1000;
        elseif($toUnit==='cm')return$value * 100000;
        elseif($toUnit==='mm')return$value * 1000000;
        elseif($toUnit==='um')return$value * 1000000000;
        elseif($toUnit==='nm')return$value * 1000000000000;
        elseif($toUnit==='mi')return$value / 1.609;
        elseif($toUnit==='yd')return$value * 1094;
        elseif($toUnit==='ft')return$value * 3281;
        elseif($toUnit==='in')return$value * 39370;
        else return'UnexpectedArgumentException';
        break;
      case'm':
        if($toUnit==='km')return$value / 1000;
        elseif($toUnit==='cm')return$value * 100;
        elseif($toUnit==='mm')return$value * 1000;
        elseif($toUnit==='um')return$value * 1000000;
        elseif($toUnit==='nm')return$value * 1000000000;
        elseif($toUnit==='mi')return$value / 1609;
        elseif($toUnit==='yd')return$value * 1.094;
        elseif($toUnit==='ft')return$value * 3.281;
        elseif($toUnit==='in')return$value * 39.37;
        else return'UnexpectedArgumentException';
        break;
      case'cm':
        if($toUnit==='m')return$value / 100;
        elseif($toUnit==='km')return$value / 100000;
        elseif($toUnit==='mm')return$value / 10;
        elseif($toUnit==='um')return$value * 10000;
        elseif($toUnit==='nm')return$value * 10000000;
        elseif($toUnit==='mi')return$value / 160934;
        elseif($toUnit==='yd')return$value / 91.44;
        elseif($toUnit==='ft')return$value / 30.48;
        elseif($toUnit==='in')return$value / 2.54;
        else return'UnexpectedArgumentException';
        break;
      case'mm':
        if($toUnit==='m')return$value / 1000;
        elseif($toUnit==='cm')return$value / 10;
        elseif($toUnit==='km')return$value / 1000000;
        elseif($toUnit==='um')return$value * 1000;
        elseif($toUnit==='nm')return$value * 1000000;
        elseif($toUnit==='mi')return$value / 1609000;
        elseif($toUnit==='yd')return$value / 194;
        elseif($toUnit==='ft')return$value / 305;
        elseif($toUnit==='in')return$value / 25.4;
        else return'UnexpectedArgumentException';
        break;
      case'um':
        if($toUnit==='m')return$value / 1000000;
        elseif($toUnit==='cm')return$value / 10000;
        elseif($toUnit==='mm')return$value / 1000;
        elseif($toUnit==='km')return$value / 1000000000;
        elseif($toUnit==='nm')return$value * 1000;
        elseif($toUnit==='mi')return$value / 1609000000;
        elseif($toUnit==='yd')return$value / 914400;
        elseif($toUnit==='ft')return$value / 304800;
        elseif($toUnit==='in')return$value / 25400;
        else return'UnexpectedArgumentException';
        break;
      case'nm':
        if($toUnit==='m')return$value / 1000;
        elseif($toUnit==='cm')return$value / 10000000;
        elseif($toUnit==='mm')return$value / 1000000;
        elseif($toUnit==='um')return$value / 1000;
        elseif($toUnit==='km')return$value / 1000000000000;
        elseif($toUnit==='mi')return$value / 1609000000000;
        elseif($toUnit==='yd')return$value / 914400000;
        elseif($toUnit==='ft')return$value / 304800000;
        elseif($toUnit==='in')return$value / 25400000;
        else return'UnexpectedArgumentException';
        break;
      case'mi':
        if($toUnit==='m')return$value * 1609;
        elseif($toUnit==='cm')return$value * 160934;
        elseif($toUnit==='mm')return$value * 1609000;
        elseif($toUnit==='um')return$value * 1609000000;
        elseif($toUnit==='nm')return$value * 1609000000000;
        elseif($toUnit==='km')return$value * 1.609;
        elseif($toUnit==='yd')return$value * 1760;
        elseif($toUnit==='ft')return$value * 5280;
        elseif($toUnit==='in')return$value * 63360;
        else return'UnexpectedArgumentException';
        break;
      case'yd':
        if($toUnit==='m')return$value / 1.094;
        elseif($toUnit==='cm')return$value * 91.44;
        elseif($toUnit==='mm')return$value * 914;
        elseif($toUnit==='um')return$value * 914400;
        elseif($toUnit==='nm')return$value * 914400000;
        elseif($toUnit==='mi')return$value / 1760;
        elseif($toUnit==='km')return$value / 1094;
        elseif($toUnit==='ft')return$value * 3;
        elseif($toUnit==='in')return$value * 36;
        else return'UnexpectedArgumentException';
        break;
      case'ft':
        if($toUnit==='m')return$value / 3.281;
        elseif($toUnit==='cm')return$value * 30.40;
        elseif($toUnit==='mm')return$value * 305;
        elseif($toUnit==='um')return$value * 304800;
        elseif($toUnit==='nm')return$value * 304800000;
        elseif($toUnit==='mi')return$value / 5280;
        elseif($toUnit==='yd')return$value / 3;
        elseif($toUnit==='km')return$value / 3281;
        elseif($toUnit==='in')return$value * 12;
        else return'UnexpectedArgumentException';
        break;
      case'in':
        if($toUnit==='m')return$value / 39.37;
        elseif($toUnit==='cm')return$value * 2.54;
        elseif($toUnit==='mm')return$value * 25.4;
        elseif($toUnit==='um')return$value * 25400;
        elseif($toUnit==='nm')return$value * 25400000;
        elseif($toUnit==='mi')return$value / 63360;
        elseif($toUnit==='yd')return$value / 36;
        elseif($toUnit==='ft')return$value * 12;
        elseif($toUnit==='km')return$value / 39370;
        else return'UnexpectedArgumentException';
        break;
      default:
        return'UnexpectedArgumentException';
        break;
    }
  }
}
function weight_converter($value,$fromUnit,$toUnit){
  switch($fromUnit){
    case'kg':
      if($toUnit==='g')return$value * 1000;
      elseif($toUnit==='lb')return$value * 2.205;
      elseif($toUnit==='mg')return$value * 1000000;
      elseif($toUnit==='t')return$value / 1000;
      else return'UnexpectedArgumentException';
      break;
    case'g':
      if($toUnit==='kg')return$value / 1000;
      elseif($toUnit==='lb')return$value / 454;
      elseif($toUnit==='mg')return$value * 1000;
      elseif($toUnit==='t')return$value / 1000000;
      else return'UnexpectedArgumentException';
      break;
    case'lb':
      if($toUnit==='g')return$value * 454;
      elseif($toUnit==='kg')return$value / 2.205;
      elseif($toUnit==='mg')return$value * 453592;
      elseif($toUnit==='t')return$value / 2205;
      else return'UnexpectedArgumentException';
      break;
    case'mg':
      if($toUnit==='g')return$value / 1000;
      elseif($toUnit==='lb')return$value / 453592;
      elseif($toUnit==='kg')return$value / 1000000;
      elseif($toUnit==='t')return$value / 1000000000;
      else return'UnexpectedArgumentException';
      break;
    case't':
      if($toUnit==='g')return$value / 1000000000;
      elseif($toUnit==='lb')return$value * 2205;
      elseif($toUnit==='mg')return$value * 1000000000;
      elseif($toUnit==='kg')return$value * 1000;
      else return'UnexpectedArgumentException';
      break;
    default:
      return'UnexpectedArgumentException';
      break;
  }
}

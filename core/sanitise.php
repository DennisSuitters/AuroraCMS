<?php
function kses(
  $string,
  $allowed_html=array(
    'a'=>array('id'=>1,'class'=>1,'href'=>array('maxlen'=>100),'name'=>1,'title'=>1),
    'abbr'=>array('id'=>1,'class'=>1),
    'acronym'=>array('id'=>1,'class'=>1),
    'address'=>array('id'=>1,'class'=>1),
    'article'=>array('id'=>1,'class'=>1,'itemprop'=>1,'itemscope'=>1,'itemtype'=>1,'name'=>1),
    'aside'=>array('id'=>1,'class'=>1,'itemprop'=>1,'itemscope'=>1,'itemtype'=>1),
    'b'=>array('id'=>1,'class'=>1),
    'bdo'=>array('id'=>1,'class'=>1),
    'big'=>array('id'=>1,'class'=>1),
    'blockquote'=>array('id'=>1,'class'=>1),
    'br'=>array(),
    'caption'=>array('id'=>1,'class'=>1),
    'cite'=>array('id'=>1,'class'=>1),
    'code'=>array('id'=>1,'class'=>1),
    'col'=>array('id'=>1,'class'=>1),
    'colgroup'=>array('id'=>1,'class'=>1),
    'dd'=>array('id'=>1,'class'=>1),
    'del'=>array('id'=>1,'class'=>1),
    'details'=>array('id'=>1,'class'=>1),
    'dfn'=>array('id'=>1,'class'=>1),
    'div'=>array('id'=>1,'class'=>1),
    'dl'=>array('id'=>1,'class'=>1),
    'dt'=>array('id'=>1,'class'=>1),
    'em'=>array('id'=>1,'class'=>1),
    'figcaption'=>array('id'=>1,'class'=>1),
    'figure'=>array('id'=>1,'class'=>1),
    'h1'=>array('id'=>1,'class'=>1,'itemprop'=>1,'name'=>1),
    'h2'=>array('id'=>1,'class'=>1,'itemprop'=>1,'name'=>1),
    'h3'=>array('id'=>1,'class'=>1,'itemprop'=>1,'name'=>1),
    'h4'=>array('id'=>1,'class'=>1,'itemprop'=>1,'name'=>1),
    'h5'=>array('id'=>1,'class'=>1,'itemprop'=>1,'name'=>1),
    'h6'=>array('id'=>1,'class'=>1,'itemprop'=>1,'name'=>1),
    'hgroup'=>array('id'=>1,'class'=>1),
    'hr'=>array('id'=>1,'class'=>1),
    'i'=>array('id'=>1,'class'=>1),
    'img'=>array('id'=>1,'class'=>1,'src'=>1,'title'=>1),
    'ins'=>array('id'=>1,'class'=>1),
    'li'=>array('id'=>1,'class'=>1),
    'map'=>array('id'=>1,'class'=>1),
    'mark'=>array('id'=>1,'class'=>1),
    'menu'=>array('id'=>1,'class'=>1),
    'meta'=>array('itemprop'=>1,'content'=>1),
    'meter'=>array('id'=>1,'class'=>1),
    'ol'=>array('id'=>1,'class'=>1),
    'p'=>array('id'=>1,'class'=>1),
    'pre'=>array('id'=>1,'class'=>1),
    'q'=>array('id'=>1,'class'=>1),
    'rp'=>array('id'=>1,'class'=>1),
    'rt'=>array('id'=>1,'class'=>1),
    's'=>array('id'=>1,'class'=>1),
    'samp'=>array('id'=>1,'class'=>1),
    'section'=>array('id'=>1,'class'=>1),
    'small'=>array('id'=>1,'class'=>1),
    'span'=>array('id'=>1,'class'=>1,'title'=>1),
    'strong'=>array('id'=>1,'class'=>1),
    'sub'=>array('id'=>1,'class'=>1),
    'summary'=>array('id'=>1,'class'=>1),
    'sup'=>array('id'=>1,'class'=>1),
    'table'=>array('id'=>1,'class'=>1),
    'tbody'=>array('id'=>1,'class'=>1),
    'td'=>array('id'=>1,'class'=>1,'colspan'=>1,'rowspan'=>1),
    'tfoot'=>array('id'=>1,'class'=>1),
    'th'=>array('id'=>1,'class'=>1,'colspan'=>1,'rowspan'=>1),
    'thead'=>array('id'=>1,'class'=>1),
    'time'=>array('id'=>1,'class'=>1),
    'tr'=>array('id'=>1,'class'=>1),
    'tt'=>array('id'=>1,'class'=>1),
    'u'=>array('id'=>1,'class'=>1),
    'ul'=>array('id'=>1,'class'=>1),
    'var'=>array('id'=>1,'class'=>1),
    'wbr'=>array('id'=>1,'class'=>1)),
  $allowed_protocols=array(
    'http',
    'https',
    'ftp',
    'news',
    'nntp',
    'telnet',
    'gopher',
    'mailto'
  )
){
  if(get_magic_quotes_gpc())
    $string=stripslashes($string);
  $string=kses_no_null($string);
  $string=kses_js_entities($string);
  $string=kses_normalize_entities($string);
  $string=kses_hook($string);
  $allowed_html_fixed=kses_array_lc($allowed_html);
  return kses_split($string,$allowed_html_fixed,$allowed_protocols);
}
function kses_hook($string){
  return$string;
}
function kses_version(){
  return'0.2.3';
}
function kses_split($string,$allowed_html,$allowed_protocols){
  return preg_replace('%(<[^>]*(>|$)|>)%',"kses_split2('\\1', \$allowed_html, ".'$allowed_protocols)',$string);
}
function kses_split2($string,$allowed_html,$allowed_protocols){
  $string=kses_stripslashes($string);
  if(substr($string,0,1)!='<')
    return'&gt;';
  if(!preg_match('%^<\s*(/\s*)?([a-zA-Z0-9]+)([^>]*)>?$%',$string,$matches))
    return'';
  $slash=trim($matches[1]);
  $elem=$matches[2];
  $attrlist=$matches[3];
  if(!@isset($allowed_html[strtolower($elem)]))
    return'';
  if($slash!='')
    return"<$slash$elem>";
  return kses_attr("$slash$elem",$attrlist,$allowed_html,$allowed_protocols);
}
function kses_attr($element,$attr,$allowed_html,$allowed_protocols){
  $xhtml_slash='';
  if(preg_match('%\s/\s*$%',$attr))
    $xhtml_slash=' /';
  if(@count($allowed_html[strtolower($element)])==0)
    return"<$element$xhtml_slash>";
  $attrarr=kses_hair($attr,$allowed_protocols);
  $attr2='';
  foreach($attrarr as$arreach){
    if(!@isset($allowed_html[strtolower($element)][strtolower($arreach['name'])]))
      continue;
    $current=$allowed_html[strtolower($element)][strtolower($arreach['name'])];
    if(!is_array($current))
      $attr2.=' '.$arreach['whole'];
    else{
      $ok=true;
      foreach($current as$currkey =>$currval){
        if(!kses_check_attr_val($arreach['value'],$arreach['vless'],$currkey,$currval)){
          $ok=false;
          break;
        }
      }
      if($ok)
        $attr2.=' '.$arreach['whole'];
    }
  }
  $attr2=preg_replace('/[<>]/','',$attr2);
  return"<$element$attr2$xhtml_slash>";
}
function kses_hair($attr,$allowed_protocols){
  $attrarr=array();
  $mode=0;
  $attrname='';
  while(strlen($attr)!=0){
    $working=0;
    switch($mode){
      case 0:
        if(preg_match('/^([-a-zA-Z]+)/',$attr,$match)){
          $attrname=$match[1];
          $working=$mode=1;
          $attr=preg_replace('/^[-a-zA-Z]+/','',$attr);
        }
        break;
      case 1:
        if(preg_match('/^\s*=\s*/',$attr)){
          $working=1;
          $mode=2;
          $attr=preg_replace('/^\s*=\s*/','',$attr);
          break;
        }
        if(preg_match('/^\s+/',$attr)){
          $working=1;
          $mode=0;
          $attrarr[]=array(
            'name'=> $attrname,
            'value'=>'',
            'whole'=>$attrname,
            'vless'=>'y'
          );
          $attr=preg_replace('/^\s+/','',$attr);
        }
        break;
      case 2:
        if(preg_match('/^"([^"]*)"(\s+|$)/',$attr,$match)){
          $thisval=kses_bad_protocol($match[1],$allowed_protocols);
          $attrarr[]=array(
            'name'=>$attrname,
            'value'=>$thisval,
            'whole'=>"$attrname=\"$thisval\"",
            'vless'=>'n'
          );
          $working=1;
          $mode=0;
          $attr=preg_replace('/^"[^"]*"(\s+|$)/','',$attr);
          break;
        }
        if(preg_match("/^'([^']*)'(\s+|$)/",$attr,$match)){
          $thisval=kses_bad_protocol($match[1],$allowed_protocols);
          $attrarr[]=array(
            'name'=>$attrname,
            'value'=>$thisval,
            'whole'=>"$attrname='$thisval'",
            'vless'=>'n'
          );
          $working=1;
          $mode=0;
          $attr=preg_replace("/^'[^']*'(\s+|$)/",'',$attr);
          break;
        }
        if(preg_match("%^([^\s\"']+)(\s+|$)%",$attr,$match)){
          $thisval=kses_bad_protocol($match[1],$allowed_protocols);
          $attrarr[]=array(
            'name'=>$attrname,
            'value'=>$thisval,
            'whole'=>"$attrname=\"$thisval\"",
            'vless'=>'n'
          );
          $working=1;
          $mode=0;
          $attr=preg_replace("%^[^\s\"']+(\s+|$)%",'',$attr);
        }
        break;
      }
      if($working==0){
        $attr=kses_html_error($attr);
        $mode=0;
      }
    }
    if($mode==1){
      $attrarr[]=array(
        'name'=>$attrname,
        'value'=>'',
        'whole'=>$attrname,
        'vless'=>'y'
      );
    }
    return$attrarr;
}
function kses_check_attr_val($value,$vless,$checkname,$checkvalue){
  $ok=true;
  switch(strtolower($checkname)){
    case'maxlen':
      if(strlen($value)>$checkvalue)
        $ok=false;
      break;
    case'minlen':
      if(strlen($value)<$checkvalue)
        $ok=false;
      break;
    case'maxval':
      if(!preg_match('/^\s{0,6}[0-9]{1,6}\s{0,6}$/',$value))
        $ok=false;
      if($value>$checkvalue)
        $ok=false;
      break;
    case'minval':
      if(!preg_match('/^\s{0,6}[0-9]{1,6}\s{0,6}$/',$value))
        $ok=false;
      if($value<$checkvalue)
        $ok=false;
      break;
    case'valueless':
      if(strtolower($checkvalue)!=$vless)
        $ok=false;
      break;
  }
  return$ok;
}
function kses_bad_protocol($string,$allowed_protocols){
  $string=kses_no_null($string);
  $string=preg_replace('/\xad+/','',$string);
  $string2=$string.'a';
  while($string!=$string2){
    $string2=$string;
    $string=kses_bad_protocol_once($string,$allowed_protocols);
  }
  return$string;
}
function kses_no_null($string){
  $string=preg_replace('/\0+/','',$string);
  $string=preg_replace('/(\\\\0)+/','',$string);
  return$string;
}
function kses_stripslashes($string){
  return preg_replace('%\\\\"%','"',$string);
}
function kses_array_lc($inarray){
  $outarray=array();
  foreach($inarray as$inkey=>$inval){
    $outkey=strtolower($inkey);
    $outarray[$outkey]=array();
    foreach($inval as$inkey2=>$inval2){
      $outkey2=strtolower($inkey2);
      $outarray[$outkey][$outkey2]=$inval2;
    }
  }
  return$outarray;
}
function kses_js_entities($string){
  return preg_replace('%&\s*\{[^}]*(\}\s*;?|$)%','',$string);
}
function kses_html_error($string){
  return preg_replace('/^("[^"]*("|$)|\'[^\']*(\'|$)|\S)*\s*/','',$string);
}
function kses_bad_protocol_once($string,$allowed_protocols){
  return preg_replace('/^((&[^;]*;|[\sA-Za-z0-9])*)(:|&#58;|&#[Xx]3[Aa];)\s*/','kses_bad_protocol_once2("\\1",$allowed_protocols)',$string);
}
function kses_bad_protocol_once2($string,$allowed_protocols){
  $string2=kses_decode_entities($string);
  $string2=preg_replace('/\s/','',$string2);
  $string2=kses_no_null($string2);
  $string2=preg_replace('/\xad+/','',$string2);
  $string2=strtolower($string2);
  $allowed=false;
  foreach($allowed_protocols as$one_protocol){
    if(strtolower($one_protocol)==$string2){
      $allowed=true;
      break;
    }
  }
  if($allowed)
    return"$string2:";
  else
    return'';
}
function kses_normalize_entities($string){
  $string=str_replace('&','&amp;',$string);
  $string=preg_replace('/&amp;([A-Za-z][A-Za-z0-9]{0,19});/', '&\\1;',$string);
  $string=preg_replace('/&amp;#0*([0-9]{1,5});/','kses_normalize_entities2("\\1")',$string);
  $string=preg_replace('/&amp;#([Xx])0*(([0-9A-Fa-f]{2}){1,2});/','&#\\1\\2;',$string);
  return$string;
}
function kses_normalize_entities2($i){
  return(($i>65535)?"&amp;#$i;":"&#$i;");
}
function kses_decode_entities($string){
  $string=preg_replace('/&#([0-9]+);/','chr("\\1")',$string);
  $string=preg_replace('/&#[Xx]([0-9A-Fa-f]+);/e','chr(hexdec("\\1"))',$string);
  return$string;
}

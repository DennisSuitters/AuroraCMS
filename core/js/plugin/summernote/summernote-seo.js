(function(factory){
  if(typeof define==='function'&&define.amd){
    define(['jquery'],factory);
  }else if(typeof module==='object'&&module.exports){
    module.exports=factory(require('jquery'));
  }else{
    factory(window.jQuery);
  }
}(function($){
  $.extend(true,$.summernote.lang,{
    'en-US':{
      seo:{
        tooltip:'SEO',
        keyNot:'Keywords Extracted, you should review them!!!',
        keyNotError:'Something went wrong!!!',
        capNot:'Caption has been Copied!!!',
        capNotError:'You haven\'t Selected Any Text for the Caption!!!',
        desNot:'Description has been Copied!!!',
        desNotError:'You haven\'t Selected Any Text for the Description!!!',
      }
    }
  });
  $.extend($.summernote.options,{
    seo:{
      el:'.summernote', // Element ID or Class used to Initialise Summernote.
      notTime:2400, // Time to display Notifications.
      keyEl:'#seoKeywords', // ID or Class of the Target Element to place Keywords.
      keyElType:'input', // input|html
      capEl:'#seoCaption', // ID or Class of the Target Element to place Caption.
      capElType:'input', // input|html
      desEl:'#seoDescription', // ID or Class of the Target Element to place Description.
      desElType:'input', // input|html
      triggerInput:true, // Set this to True if like me you use AJAX to update single fields
      action:'replace', // replace|append Replace or Append Content.
      successClass:'alert alert-success',
      errorClass:'alert alert-danger',
      icon:'<i class="note-icon"><svg xmlns="http://www.w3.org/2000/svg" id="libre-seo" viewBox="0 0 14 14"><path d="m 5.900978,8.5734763 c 0.57772,0 1.122935,0.12568 1.606781,0.34835 -0.377331,-0.42276 -0.96108,-0.6955 -1.618199,-0.6955 -0.666351,0 -1.257265,0.28066 -1.633576,0.71365 0.493486,-0.23377 1.052332,-0.3665 1.644994,-0.3665 z m 1.654664,-5.33156 c -0.899973,-0.89998 -2.353986,-0.89272 -3.254134,0.007 -0.899973,0.89992 -0.906148,2.35737 -0.0061,3.25714 l 1.6258,1.61694 1.629325,-1.62956 c 0.900031,-0.90006 0.905012,-2.35177 0.0052,-3.2517101 z m -1.62845,3.00577 c -0.765672,0 -1.386324,-0.62074 -1.386324,-1.38623 0,-0.7658201 0.620652,-1.38647 1.386324,-1.38647 0.765817,0 1.386498,0.62079 1.386498,1.38647 0,0.7653799 -0.620506,1.38623 -1.386498,1.38623 z m 3.482804,-3.80628 c -1.92114,-1.92163005 -5.047381,-1.92163005 -6.968813,0 -1.921577,1.9211399 -1.921577,5.0475299 0,6.96881 1.855519,1.8554897 4.834556,1.9186397 6.767084,0.19043 l 0.390671,0.39082 c -0.09728,0.2489997 -0.04628,0.5424197 0.154807,0.7435297 l 2.061471,2.06145 c 0.270991,0.27116 0.710564,0.27116 0.98141,0 0.271165,-0.27085 0.271165,-0.71031 0,-0.98159 L 10.735329,9.7538263 c -0.201262,-0.20141 -0.494797,-0.25238 -0.743827,-0.15496 l -0.39067,-0.39081 c 1.728528,-1.93241 1.6648,-4.91145 -0.190836,-6.76665 z m -6.379938,6.38008 c -1.596673,-1.59649 -1.596673,-4.19476 0,-5.7914401 1.596528,-1.59667 4.19471,-1.59667 5.791354,0 1.596674,1.59668 1.596674,4.1949201 0,5.7914401 -1.596644,1.5964997 -4.194826,1.5964997 -5.791354,0 z"/></svg></i> &nbsp;<span class="caret"></span>',
      menu:[
        'Extract Keywords',
        'Copy Caption',
        'Copy Description'
      ]
    }
  });
  $.extend($.summernote.plugins,{
    'seo':function(context){
      var self=this;
      var ui=$.summernote.ui;
      var $note=context.layoutInfo.note;
      var $editor=context.layoutInfo.editor;
      var $editable=context.layoutInfo.editable;
      var options=context.options;
      var lang=options.langInfo;
      context.memo('button.seo',function(){
        var button=ui.buttonGroup([
          ui.button({
            className:'dropdown-toggle',
            contents:options.seo.icon,
            container:options.container,
            tooltip:lang.seo.tooltip,
            placement:options.placement,
            data:{
              toggle:'dropdown'
            }
          }),
          ui.dropdown({
            className:'dropdown-template',
            items:options.seo.menu,
            click:function(event){
              var $button=$(event.target);
              var value=$button.data('value');
              event.preventDefault();
              switch(value){
                case'Copy Caption':
                  var text=$(options.seo.el).summernote('createRange');
                  text.toString();
                  if(text==''){
                    $('.note-editing-area').append('<div class="summernote-seoAlert '+options.seo.errorClass+'" style="position:absolute;top:0;left:0;right:0;">'+lang.seo.capNotError+'</div>');
                    setTimeout(function(){$('.summernote-seoAlert').remove();},options.seo.notTime);
                  }else{
                    if(options.seo.capElType=='input'){
                      if(options.seo.action=='replace'){
                        $(options.seo.capEl).val(text);
                      }else{
                        var preText=$(options.seo.capEl).val();
                        if(preText!='')preText+=', ';
                        $(options.seo.capEl).val(preText+text);
                      }
                      if(options.seo.triggerInput==true)$(options.seo.capEl).trigger("change");
                    }else{
                      if(options.seo.action=='replace'){
                        $(options.seo.capEl).html(text);
                      }else{
                        var preText=$(options.seo.capEl).html();
                        $(options.seo.capEl).html(preText+text);
                      }
                    }
                    $('.note-editing-area').append('<div class="summernote-seoAlert '+options.seo.successClass+'" style="position:absolute;top:0;left:0;right:0">'+lang.seo.capNot+'</div>');
                    setTimeout(function(){$('.summernote-seoAlert').remove();},options.seo.notTime);
                  }
                  break;
                case'Copy Description':
                  var text=$(options.seo.el).summernote('createRange');
                  text.toString();
                  if(text==''){
                    $('.note-editing-area').append('<div class="summernote-seoAlert '+options.seo.errorClass+'" style="position:absolute;top:0;left:0;right:0">'+lang.seo.desNotError+'</div>');
                    setTimeout(function(){$('.summernote-seoAlert').remove();},options.seo.notTime);
                  }else{
                    if(options.seo.desElType=='input'){
                      if(options.seo.action=='replace'){
                        $(options.seo.desEl).val(text);
                      }else{
                        var preText=$(options.seo.desEl).val();
                        if(preText!='')preText+=', ';
                        $(options.seo.desEl).val(preText+text);
                      }
                      if(options.seo.triggerInput==true)$(options.seo.desEl).trigger("change");
                    }else{
                      if(options.seo.action=='replace'){
                        $(options.seo.desEl).html(text);
                      }else{
                        var preText=$(options.seo.desEl).html();
                        $(options.seo.desEl).html(preText+text);
                      }
                    }
                    $('.note-editing-area').append('<div class="summernote-seoAlert '+options.seo.successClass+'" style="position:absolute;top:0;left:0;right:0">'+lang.seo.desNot+'</div>');
                    setTimeout(function(){$('.summernote-seoAlert').remove();},options.seo.notTime);
                  }
                  break;
                case'Extract Keywords':
                  var text=getKeywords($(options.seo.el).text());
                  if(options.seo.keyElType=='input'){
                    if(options.seo.action=='replace'){
                      $(options.seo.keyEl).val(text);
                    }else{
                      var preText=$(options.seo.keyEl).val();
                      if(preText!='')preText+=',';
                      $(options.seo.keyEl).val(preText+','+text);
                    }
                    if(options.seo.triggerInput==true)$(options.seo.keyEl).trigger("change");
                  }else{
                    if(options.seo.action=='replace'){
                      $(options.seo.keyEl).html(text);
                    }else{
                      var preText=$(options.seo.keyEl).html();
                      $(options.seo.keyEl).html(preText+','+text);
                    }
                  }
                  $('.note-editing-area').append('<div class="summernote-seoAlert '+options.seo.successClass+'" style="position:absolute;top:0;left:0;right:0">'+lang.seo.keyNot+'</div>');
                  setTimeout(function(){$('.summernote-seoAlert').remove();},options.seo.notTime);
                  break;
                }
              }
            })
          ]);
          return button.render();
        });
      }
  });
}));
var soundex={
  codes:{A:{0:[0,-1,-1],I:[[0,1,-1]],J:[[0,1,-1]],Y:[[0,1,-1]],U:[[0,7,-1]]},B:[[7,7,7]],C:{0:[5,5,5],1:[4,4,4],Z:{0:[4,4,4],S:[[4,4,4]]},S:{0:[4,4,4],Z:[[4,4,4]]},K:[[5,5,5],[45,45,45]],H:{0:[5,5,5],1:[4,4,4],S:[[5,54,54]]}},D:{0:[3,3,3],T:[[3,3,3]],Z:{0:[4,4,4],H:[[4,4,4]],S:[[4,4,4]]},S:{0:[4,4,4],H:[[4,4,4]],Z:[[4,4,4]]},R:{S:[[4,4,4]],Z:[[4,4,4]]}},E:{0:[0,-1,-1],I:[[0,1,-1]],J:[[0,1,-1]],Y:[[0,1,-1]],U:[[1,1,-1]],W:[[1,1,-1]]},F:{0:[7,7,7],B:[[7,7,7]]},G:[[5,5,5]],H:[[5,5,-1]],I:{0:[0,-1,-1],A:[[1,-1,-1]],E:[[1,-1,-1]],O:[[1,-1,-1]],U:[[1,-1,-1]]},J:[[4,4,4]],K:{0:[5,5,5],H:[[5,5,5]],S:[[5,54,54]]},L:[[8,8,8]],M:{0:[6,6,6],N:[[66,66,66]]},N:{0:[6,6,6],M:[[66,66,66]]},O:{0:[0,-1,-1],I:[[0,1,-1]],J:[[0,1,-1]],Y:[[0,1,-1]]},P:{0:[7,7,7],F:[[7,7,7]],H:[[7,7,7]]},Q:[[5,5,5]],R:{0:[9,9,9],Z:[[94,94,94],[94,94,94]],S:[[94,94,94],[94,94,94]]},S:{0:[4,4,4],Z:{0:[4,4,4],T:[[2,43,43]],C:{Z:[[2,4,4]],S:[[2,4,4]]},D:[[2,43,43]]},D:[[2,43,43]],T:{0:[2,43,43],R:{Z:[[2,4,4]],S:[[2,4,4]]},C:{H:[[2,4,4]]},S:{H:[[2,4,4]],C:{H:[[2,4,4]]}}},C:{0:[2,4,4],H:{0:[4,4,4],T:{0:[2,43,43],S:{C:{H:[[2,4,4]]},H:[[2,4,4]]},C:{H:[[2,4,4]]}},D:[[2,43,43]]}},H:{0:[4,4,4],T:{0:[2,43,43],C:{H:[[2,4,4]]},S:{H:[[2,4,4]]}},C:{H:[[2,4,4]]},D:[[2,43,43]]}},T:{0:[3,3,3],C:{0:[4,4,4],H:[[4,4,4]]},Z:{0:[4,4,4],S:[[4,4,4]]},S:{0:[4,4,4],Z:[[4,4,4]],H:[[4,4,4]],C:{H:[[4,4,4]]}},T:{S:{0:[4,4,4],Z:[[4,4,4]],C:{H:[[4,4,4]]}},C:{H:[[4,4,4]]},Z:[[4,4,4]]},H:[[3,3,3]],R:{Z:[[4,4,4]],S:[[4,4,4]]}},U:{0:[0,-1,-1],E:[[0,-1,-1]],I:[[0,1,-1]],J:[[0,1,-1]],Y:[[0,1,-1]]},V:[[7,7,7]],W:[[7,7,7]],X:[[5,54,54]],Y:[[1,-1,-1]],Z:{0:[4,4,4],D:{0:[2,43,43],Z:{0:[2,4,4],H:[[2,4,4]]}},H:{0:[4,4,4],D:{0:[2,43,43],Z:{H:[[2,4,4]]}}},S:{0:[4,4,4],H:[[4,4,4]],C:{H:[[4,4,4]]}}}},
  en:['A','a','B','b','V','v','G','g','D','d','E','e','E','e','ZH','zh','Z','z','I','i','I','i','K','k','L','l','M','m','N','n','O','o','P','p','R','r','S','s','T','t','U','u','F','f','H','h','C','c','CH','ch','SH','sh','SCH','sch','\'','\'','Y','y','\'','\'','E','e','YU','Yu','YA','ya'],
  accented:{
    'A': /[Aa\xaa\xc0-\xc5\xe0-\xe5\u0100-\u0105\u01cd\u01ce\u0200-\u0203\u0226\u0227\u1d2c\u1d43\u1e00\u1e01\u1e9a\u1ea0-\u1ea3\u2090\u2100\u2101\u213b\u249c\u24b6\u24d0\u3371-\u3374\u3380-\u3384\u3388\u3389\u33a9-\u33af\u33c2\u33ca\u33df\u33ff\uff21\uff41]/ig,
    'B': /[Bb\u1d2e\u1d47\u1e02-\u1e07\u212c\u249d\u24b7\u24d1\u3374\u3385-\u3387\u33c3\u33c8\u33d4\u33dd\uff22\uff42]/ig,
    'C': /[Cc\xc7\xe7\u0106-\u010d\u1d9c\u2100\u2102\u2103\u2105\u2106\u212d\u216d\u217d\u249e\u24b8\u24d2\u3376\u3388\u3389\u339d\u33a0\u33a4\u33c4-\u33c7\uff23\uff43]/ig,
    'D': /[Dd\u010e\u010f\u01c4-\u01c6\u01f1-\u01f3\u1d30\u1d48\u1e0a-\u1e13\u2145\u2146\u216e\u217e\u249f\u24b9\u24d3\u32cf\u3372\u3377-\u3379\u3397\u33ad-\u33af\u33c5\u33c8\uff24\uff44]/ig,
    'E': /[Ee\xc8-\xcb\xe8-\xeb\u0112-\u011b\u0204-\u0207\u0228\u0229\u1d31\u1d49\u1e18-\u1e1b\u1eb8-\u1ebd\u2091\u2121\u212f\u2130\u2147\u24a0\u24ba\u24d4\u3250\u32cd\u32ce\uff25\uff45]/ig,
    'F': /[Ff\u1da0\u1e1e\u1e1f\u2109\u2131\u213b\u24a1\u24bb\u24d5\u338a-\u338c\u3399\ufb00-\ufb04\uff26\uff46]/ig,
    'G': /[Gg\u011c-\u0123\u01e6\u01e7\u01f4\u01f5\u1d33\u1d4d\u1e20\u1e21\u210a\u24a2\u24bc\u24d6\u32cc\u32cd\u3387\u338d-\u338f\u3393\u33ac\u33c6\u33c9\u33d2\u33ff\uff27\uff47]/ig,
    'H': /[Hh\u0124\u0125\u021e\u021f\u02b0\u1d34\u1e22-\u1e2b\u1e96\u210b-\u210e\u24a3\u24bd\u24d7\u32cc\u3371\u3390-\u3394\u33ca\u33cb\u33d7\uff28\uff48]/ig,
    'I': /[Ii\xcc-\xcf\xec-\xef\u0128-\u0130\u0132\u0133\u01cf\u01d0\u0208-\u020b\u1d35\u1d62\u1e2c\u1e2d\u1ec8-\u1ecb\u2071\u2110\u2111\u2139\u2148\u2160-\u2163\u2165-\u2168\u216a\u216b\u2170-\u2173\u2175-\u2178\u217a\u217b\u24a4\u24be\u24d8\u337a\u33cc\u33d5\ufb01\ufb03\uff29\uff49]/ig,
    'J': /[Jj\u0132-\u0135\u01c7-\u01cc\u01f0\u02b2\u1d36\u2149\u24a5\u24bf\u24d9\u2c7c\uff2a\uff4a]/ig,
    'K': /[Kk\u0136\u0137\u01e8\u01e9\u1d37\u1d4f\u1e30-\u1e35\u212a\u24a6\u24c0\u24da\u3384\u3385\u3389\u338f\u3391\u3398\u339e\u33a2\u33a6\u33aa\u33b8\u33be\u33c0\u33c6\u33cd-\u33cf\uff2b\uff4b]/ig,
    'L': /[Ll\u0139-\u0140\u01c7-\u01c9\u02e1\u1d38\u1e36\u1e37\u1e3a-\u1e3d\u2112\u2113\u2121\u216c\u217c\u24a7\u24c1\u24db\u32cf\u3388\u3389\u33d0-\u33d3\u33d5\u33d6\u33ff\ufb02\ufb04\uff2c\uff4c]/ig,
    'M': /[Mm\u1d39\u1d50\u1e3e-\u1e43\u2120\u2122\u2133\u216f\u217f\u24a8\u24c2\u24dc\u3377-\u3379\u3383\u3386\u338e\u3392\u3396\u3399-\u33a8\u33ab\u33b3\u33b7\u33b9\u33bd\u33bf\u33c1\u33c2\u33ce\u33d0\u33d4-\u33d6\u33d8\u33d9\u33de\u33df\uff2d\uff4d]/ig,
    'N': /[Nn\xd1\xf1\u0143-\u0149\u01ca-\u01cc\u01f8\u01f9\u1d3a\u1e44-\u1e4b\u207f\u2115\u2116\u24a9\u24c3\u24dd\u3381\u338b\u339a\u33b1\u33b5\u33bb\u33cc\u33d1\uff2e\uff4e]/ig,
    'O': /[Oo\xba\xd2-\xd6\xf2-\xf6\u014c-\u0151\u01a0\u01a1\u01d1\u01d2\u01ea\u01eb\u020c-\u020f\u022e\u022f\u1d3c\u1d52\u1ecc-\u1ecf\u2092\u2105\u2116\u2134\u24aa\u24c4\u24de\u3375\u33c7\u33d2\u33d6\uff2f\uff4f]/ig,
    'P': /[Pp\u1d3e\u1d56\u1e54-\u1e57\u2119\u24ab\u24c5\u24df\u3250\u3371\u3376\u3380\u338a\u33a9-\u33ac\u33b0\u33b4\u33ba\u33cb\u33d7-\u33da\uff30\uff50]/ig,
    'Q': /[Qq\u211a\u24ac\u24c6\u24e0\u33c3\uff31\uff51]/ig,
    'R': /[Rr\u0154-\u0159\u0210-\u0213\u02b3\u1d3f\u1d63\u1e58-\u1e5b\u1e5e\u1e5f\u20a8\u211b-\u211d\u24ad\u24c7\u24e1\u32cd\u3374\u33ad-\u33af\u33da\u33db\uff32\uff52]/ig,
    'S': /[Ss\u015a-\u0161\u017f\u0218\u0219\u02e2\u1e60-\u1e63\u20a8\u2101\u2120\u24ae\u24c8\u24e2\u33a7\u33a8\u33ae-\u33b3\u33db\u33dc\ufb06\uff33\uff53]/ig,
    'T': /[Tt\u0162-\u0165\u021a\u021b\u1d40\u1d57\u1e6a-\u1e71\u1e97\u2121\u2122\u24af\u24c9\u24e3\u3250\u32cf\u3394\u33cf\ufb05\ufb06\uff34\uff54]/ig,
    'U': /[Uu\xd9-\xdc\xf9-\xfc\u0168-\u0173\u01af\u01b0\u01d3\u01d4\u0214-\u0217\u1d41\u1d58\u1d64\u1e72-\u1e77\u1ee4-\u1ee7\u2106\u24b0\u24ca\u24e4\u3373\u337a\uff35\uff55]/ig,
    'V': /[Vv\u1d5b\u1d65\u1e7c-\u1e7f\u2163-\u2167\u2173-\u2177\u24b1\u24cb\u24e5\u2c7d\u32ce\u3375\u33b4-\u33b9\u33dc\u33de\uff36\uff56]/ig,
    'W': /[Ww\u0174\u0175\u02b7\u1d42\u1e80-\u1e89\u1e98\u24b2\u24cc\u24e6\u33ba-\u33bf\u33dd\uff37\uff57]/ig,
    'X': /[Xx\u02e3\u1e8a-\u1e8d\u2093\u213b\u2168-\u216b\u2178-\u217b\u24b3\u24cd\u24e7\u33d3\uff38\uff58]/ig,
    'Y': /[Yy\xdd\xfd\xff\u0176-\u0178\u0232\u0233\u02b8\u1e8e\u1e8f\u1e99\u1ef2-\u1ef9\u24b4\u24ce\u24e8\u33c9\uff39\uff59]/ig,
    'Z': /[Zz\u0179-\u017e\u01f1-\u01f3\u1dbb\u1e90-\u1e95\u2124\u2128\u24b5\u24cf\u24e9\u3390-\u3394\uff3a\uff5a]/ig},
  cache:{},
  word:function(str,iscyr){
    var l=str.length,
      output='',
      i=0,
      iscyr=iscyr||true,
      previous=-1,
      power=6;
      while(i<l){
        var current=last=this.codes[str[i]];
        for(var j=k=1;k<power+1;k++){
          if(!str[i+k]||!current[str[i+k]])break;
          current=current[str[i+k]];
          if(current[0]){
            last=current;
            j=k+1;
          }
        }
        var code;
        if(i==0){
          code=last[0][0];
        }else if(!str[i+j]||this.codes[str[i+j]][0][0]!=0){
          code=iscyr?(last.length>1?last[1][2]:last[0][2]):last[0][2];
        }else{
          code=iscyr?(last.length>1?last[1][1]:last[0][1]):last[0][1];
        }
        if((code!=-1)&&(code!=previous))output+=code;
        previous=code;
        i+=j;
      }
      if(output&&output.length<3)output+=(new Array(3-output.length+1)).join('0');
      return output;
    },
    calc:function(str){
      var str=str.toUpperCase(),
        iscyr=false,
        trans=str.match(/[А-Я]/g);
      for(var letter in this.accented){
        str.replace(this.accented[letter],letter);
      }
      if(trans){
        str=this.translit(str,trans);
        iscyr=true;
      }
      str=str.replace(/[^\s^A-Z]/g,'').replace(/\s{2,}/g,' ').replace(/^\s+|\s+$/g,'');
      if(!str)return null;
      var matches=str.split(' ');
      for(var i=0,l=matches.length;i<l;i++){
        var word=matches[i];
        if(this.cache[word]){
          matches[i]=this.cache[word];
        }else{
          matches[i]=this.cache[word]=this.word(word,iscyr);
        }
      }
      matches=matches.toString().substr(0,4);
      return matches;
    },
    translit:function(str,matches){
      for(var i=0,l=matches.length;i<l;i++){
        var index=$.inArray(matches[i],this.ru);
        str=str.replace(matches[i],this.en[index]);
      }
      return str;
    }
};
function getKeywords(sourceText){
  var start=Date.now();
	sourceText=sourceText.replace(/<style([\s\S]*?)\/style>/ig," ");
	sourceText=sourceText.replace(/<script([\s\S]*?)\/script>/ig," ");
	sourceText=sourceText.replace(/<\/?[a-z][a-z0-9]*[^<>]*>/ig," ");
	sourceText=sourceText.replace(/&([\s\S]*?);/ig," ");
	sourceText=sourceText.replace(/<!--([\s\S]*?)-->/ig," ");
	sourceText=sourceText.replace(/[^a-zA-Zа-яА-Я\s]/g," ");
	sourceText=sourceText.replace(/\s+/g,' ');
	sourceText=sourceText.replace(/^\s+/,'');
	sourceText=sourceText.replace(/\s+$/,'');
	sourceText=sourceText.toLowerCase();
	txt=sourceText.split(' ');
	var wordsArray=[];
	var finalArray=[];
	for(key in txt){
		if(txt[key].length>=5){
			var SoundexNumber=soundex.calc(txt[key]);
			if(typeof wordsArray[SoundexNumber]!="undefined"){
				wordsArray[SoundexNumber].count++;
				if(wordsArray[SoundexNumber].string.indexOf(txt[key])==-1&&wordsArray[SoundexNumber].word!=txt[key]){
					wordsArray[SoundexNumber].string.push(txt[key]);
				}
			}else{
				wordsArray[SoundexNumber]={'word':txt[key],'count':1,'string':[]};
			}
		}
	}
	txt='';
	for(key in wordsArray){
		finalArray.push(wordsArray[key]);
	}
	finalArray.sort(function(obj1,obj2){
		if(obj1.count==obj2.count){return 0;}
		if(obj1.count>obj2.count){return -1;}else{return 1;}
	});
	keywords='';
	for(key in finalArray){
		if(keywords!=''){keywords=keywords+',';}
		if((keywords+finalArray[key].word).length>255){
			break;
		}else{
			keywords=keywords+finalArray[key].word;
		}
	}
	keywords=keywords.replace(/,+$/,'');
    var stop=Date.now();
	return keywords;
}

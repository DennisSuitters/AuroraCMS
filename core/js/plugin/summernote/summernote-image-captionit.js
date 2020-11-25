/* https://github.com/StudioJunkyard/summernote-image-captionit */

(function(factory){
  if(typeof define==='function'&&define.amd){
    define(['jquery'],factory)
  }else if(typeof module==='object'&&module.exports){
    module.exports=factory(require('jquery'));
  }else{
    factory(window.jQuery)
  }
}
(function($){
  $.extend(true,$.summernote.lang,{
    'en-US':{
      captionIt:{
        tooltip:'Caption It'
      }
    }
  });
  $.extend($.summernote.options,{
    captionIt:{
      icon:'<i class="note-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14" id="libre-figcaption"><path d="M 8.781,11.11 7,11.469 7.3595,9.688 8.781,11.11 Z M 7.713,9.334 9.135,10.7565 13,6.8915 11.5775,5.469 7.713,9.334 Z M 6.258,9.5 8.513,7.12 7.5,5.5 6.24,7.5 5,6.52 3,9.5 6.258,9.5 Z M 4.5,5.25 C 4.5,4.836 4.164,4.5 3.75,4.5 3.336,4.5 3,4.836 3,5.25 3,5.6645 3.336,6 3.75,6 4.164,6 4.5,5.6645 4.5,5.25 Z m 1.676,5.25 -4.176,0 0,-7 9,0 0,1.156 1,0 0,-2.156 -11,0 0,9 4.9845,0 0.1915,-1 z"/></svg></i>',
      figureClass:'',
      figcaptionClass:''
    }
  });
  $.extend($.summernote.plugins,{
    'captionIt':function(context){
      var ui=$.summernote.ui;
      var $editable=context.layoutInfo.editable;
      var $note=context.layoutInfo.note;
      var options=context.options;
      var lang=options.langInfo;
      context.memo('button.captionIt',function(){
        var button=ui.button({
          contents:options.captionIt.icon,
          container:options.container,
          tooltip:lang.captionIt.tooltip,
          click:function(){
            var img=$($editable.data('target'));
            var titleText=img.attr('title'),
                altText=img.attr('alt'),
                classList=img.attr('class'),
                inlineStyles=img.attr('style'),
                classList=img.attr('class');
                inlineStyles=img.attr('style');
                imgWidth=img.width();
      			var captionText="";
    		    if(titleText){
      			  captionText=titleText;
    		    }else if(altText){
      			  captionText=altText;
    		    } else {
      			  captionText="Caption goes here.";
    		    }
            var $parentAnchorLink=img.parent();
            if($parentAnchorLink.is('a')){
              $newFigure=$parentAnchorLink.wrap('<figure class="'+options.captionIt.figureClass+'"></figure>').parent();
              $parentAnchorLink.after('<figcaption class="'+options.captionIt.figcaptionClass+'>'+captionText+'</figcaption>');
              $newFigure.width(imgWidth);
              $newFigure.parent('p').before($newFigure);
            }else{
              $newFigure=img.wrap('<figure class="'+options.captionIt.figureClass+'"></figure>').parent();
              img.after('<figcaption class="'+options.captionIt.figcaptionClass+'">'+captionText+'</figcaption>');
              $newFigure.width(imgWidth);
              $newFigure.parent('p').before($newFigure);
            }
          }
        });
        return button.render();
      });
//      this.events={
//        'summernote.keydown':function(we,e){
//          if(e.keyCode==8||e.keyCode==46){

//          }
//        }
//      };
    }
  });
}));

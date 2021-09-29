(function(factory){
  if(typeof define==='function' && define.amd){
    define(['jquery'], factory);
  }else if(typeof module==='object' && module.exports){
    module.exports=factory(require('jquery'));
  }else{
    factory(window.jQuery);
  }
}(function($){
  $.extend(true, $.summernote.lang, {
    'en-US': {
      emoji: {
        tooltip: 'Emojis'
      }
    },
  });
  $.extend($.summernote.options,{
    emoji:{
      url:'',
    }
  });
  $.extend($.summernote.plugins,{
    'emoji':function(context){
      var self=this,
          ui=$.summernote.ui,
          options=context.options,
          lang = options.langInfo;
      var addListener=function(){
        $('body').on('click','.note-ext-emoji-search :input',function(e){
          e.stopPropagation();
        });
      };
      this.events={
        'summernote.init':function(we,e){
          addListener();
        }
      };
      context.memo('button.emoji',function(){
        return ui.buttonGroup({
          className:'',
          children:[
            ui.button({
              className:'note-dropdown-toggle',
              contents:'<i class="note-icon-emoji"><svg role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14"><path d="m 7,2 c 2.757,0 5,2.243 5,5 0,2.757 -2.243,5 -5,5 C 4.243,12 2,9.757 2,7 2,4.243 4.243,2 7,2 Z M 7,1 C 3.6865,1 1,3.6865 1,7 c 0,3.3135 2.6865,6 6,6 3.3135,0 6,-2.6865 6,-6 C 13,3.6865 10.3135,1 7,1 Z M 9.7535,7.9705 C 8.9975,8.568 8.1665,8.936 7.0005,8.936 5.8335,8.936 5.0025,8.568 4.2465,7.9705 L 4,8.217 C 4.5635,9.077 5.6,10 7.0005,10 8.4005,10 9.4365,9.077 10,8.217 Z M 5.25,5 C 4.836,5 4.5,5.3355 4.5,5.75 4.5,6.1645 4.836,6.5 5.25,6.5 5.664,6.5 6,6.1645 6,5.75 6,5.3355 5.664,5 5.25,5 Z m 3.5,0 C 8.336,5 8,5.3355 8,5.75 8,6.1645 8.336,6.5 8.75,6.5 9.164,6.5 9.5,6.1645 9.5,5.75 9.5,5.3355 9.164,5 8.75,5 Z"/></svg></i>'+ui.icon(options.icons.caret,'span'),
              container: options.container,
              tooltip: lang.emoji.tooltip,
              data:{
                toggle:'dropdown'
              },
              click:function(){
                context.invoke('editor.saveRange');
              }
            }),
            ui.dropdown({
              className:'dropdown-emoji',
              items:[
                '<div class="note-emoji-search">',
                  '<input type="text" placeholder="search..." class="note-control">',
                '</div>',
                '<div class="note-emoji-list">',
                  '<div class="note-emoji-loading">Loading...</div>',
                '</div>'
              ].join(''),
              callback:function($dropdown){
                self.$search=$('.note-emoji-search :input',$dropdown);
                self.$list=$('.note-emoji-list',$dropdown);
              }
            })
          ]
        }).render();
      });
      self.initialize=function(){
        var $search=self.$search;
        var $list=self.$list;
        $.ajax({
          url:options.emoji.url+'emojis.json'
        }).then(function(data){
          window.emojis=Object.keys(data);
          window.emojiUrls=data;
          $('.note-emoji-loading').remove();
          $.each(window.emojiUrls,function(name,url){
            setTimeout(function(){
              var $btn=$('<button/>',
              {
                'class':'note-emoji-btn btn btn-link',
                'title':name,
                'type':'button',
                'tabindex':'-1'
              });
              var $img=$('<img/>',{'src':url});
              $btn.html($img);
              $btn.click(function(event){
                event.preventDefault();
                context.invoke('emoji.insertEmoji',name,url);
              });
              $list.append($btn);
            },0);
          });
        });
        self.$search.keyup(function(){
          self.filter($search.val());
        });
      };
      self.filter=function(filter){
        var $icons=$('button',self.$list);
        var rx_filter;
        if(filter===''){
          $icons.show();
        }else{
          rx_filter=new RegExp(filter);
          $icons.each(function(){
            var $item=$(this);
            if(rx_filter.test($item.attr('title'))){
              $item.show();
            }else{
              $item.hide();
            }
          });
        }
      };
      self.insertEmoji=function(name,url){
        var img=new Image();
        img.src=url;
        img.alt=name;
        img.title=name;
        img.className='emoji-img-inline';
        context.invoke('editor.restoreRange');
        context.invoke('editor.focus');
        context.invoke('editor.insertNode',img);
      };
    }
  });
}));

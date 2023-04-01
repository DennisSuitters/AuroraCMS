(function(factory){
  if(typeof define==='function'&&define.amd){
    define(['jquery'],factory);
  }else if(typeof module==='object'&&module.exports){
    module.exports=factory(require('jquery'));
  }else{
    factory(window.jQuery);
  }
}(function($){
  $.extend(true,$.summernote.lang, {
    'en-US': {
      checkbox: {
        tooltip: 'Checkbox'
      }
    }
  });
  $.extend($.summernote.options, {
    checkbox: {
      icon: '<i class="note-icon"><svg role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14" width="16" height="16" style="fill:currentColor"><path d="m 4.2666667,5.73333 -0.9333334,0.93334 3,3 L 13,3 12.066667,2.06667 6.3333333,7.8 4.2666667,5.73333 Z m 7.4000003,5.93334 -9.3333337,0 0,-9.33334 L 9,2.33333 9,1 2.3333333,1 C 1.6,1 1,1.6 1,2.33333 l 0,9.33334 C 1,12.4 1.6,13 2.3333333,13 l 9.3333337,0 C 12.4,13 13,12.4 13,11.66667 l 0,-5.33334 -1.333333,0 0,5.33334 z"/></svg></i>'
    }
  });
  $.extend($.summernote.plugins, {
    'checkbox': function (context) {
      var self = this;
      var ui      = $.summernote.ui,
          $editor = context.layoutInfo.editor,
          $note   = context.layoutInfo.note,
          options = context.options,
          lang    = options.langInfo;
      context.memo('button.checkbox', function () {
        var button = ui.button({
          contents: options.checkbox.icon,
          container:  options.container,
          tooltip: lang.checkbox.tooltip,
          placement:options.placement,
          click: function (e) {
            e.preventDefault();
            context.invoke('insertNode', self.createCheckbox());
          }
        });
        return button.render();
      });
      this.createCheckbox = function () {
        var el = document.createElement('input');
        el.type = "checkbox";
        return el;
      }
      this.initialize = function () {
        var layoutInfo = context.layoutInfo;
        var $editor = layoutInfo.editor;
        $editor.click(function (e) {
          if (e.target.type && e.target.type == 'checkbox') {
            var checked = $(e.target).is(':checked');
            $(e.target).attr('checked', checked);
            context.invoke('insertText', '');
          }
        });
      };
    }
  });
}));

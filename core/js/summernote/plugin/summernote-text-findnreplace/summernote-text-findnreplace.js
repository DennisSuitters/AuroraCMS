(function (factory) {
  if (typeof define === 'function' && define.amd) {
    define(['jquery'], factory);
  } else if (typeof module === 'object' && module.exports) {
    module.exports = factory(require('jquery'));
  } else {
    factory(window.jQuery);
  }
}(function ($) {
  $.extend(true,$.summernote.lang, {
    'en-US': { /* English */
      findnreplace: {
        tooltip:            `Find 'N Replace`,
        findBtn:            'Find ',
        findPlaceholder:    'Enter the text you want to find...',
        findResult:         ' results found for ',
        findError:          'Nothing entered to find...',
        replaceBtn:         'Replace',
        replacePlaceholder: 'Enter the text to replace the text above or selected...',
        replaceResult:      ', replaced by ',
        replaceError:       'Nothing entered to replace...',
        noneSelected:       'Nothing selected to replace...'
      }
    }
  });
  $.extend($.summernote.options, {
    findnreplace: {
      classHidden: 'note-display-none',
      icon:      '<i class="note-icon" data-toggle="findnreplace"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14" width="16" height="16" style="fill:currentColor"><path d="m 5.8,2.3764705 c 0.941176,0 1.811765,0.376471 2.423529,1.011765 l -1.741176,1.741176 4.117647,0 0,-4.117647 -1.411765,1.411765 C 8.317647,1.5529415 7.117647,1.0117645 5.8,1.0117645 c -2.423529,0 -4.423529,1.788236 -4.752941,4.117647 l 1.388235,0 C 2.741176,3.5529415 4.129412,2.3764705 5.8,2.3764705 Z m 3.8588235,6.282353 c 0.4470585,-0.611764 0.7764705,-1.341176 0.8705885,-2.164706 l -1.388236,0 c -0.305882,1.552942 -1.694117,2.752942 -3.364705,2.752942 -0.941177,0 -1.811765,-0.376471 -2.42353,-1.011765 L 5.094118,6.4941175 1,6.4941175 1,10.611765 2.411765,9.2000005 C 3.282353,10.070589 4.482353,10.611765 5.8,10.611765 c 1.058824,0 2.047059,-0.352942 2.847059,-0.9411765 L 11.988235,12.988236 13,11.97647 9.6588235,8.6588235 Z"/></svg></i>'
    }
  });
  $.extend($.summernote.plugins, {
    'findnreplace': function (context) {
      var ui       = $.summernote.ui,
          $note    = context.layoutInfo.note,
          $editor  = context.layoutInfo.editor,
          $toolbar = context.layoutInfo.toolbar,
          options  = context.options,
          lang     = options.langInfo,
          interface = $.summernote.interface;
      $('<link/>', {
        rel: 'stylesheet',
        type: 'text/css',
        href: '../summernote-text-findnreplace/css/lite.css'
      }).appendTo('head');
      context.memo('button.findnreplace', function() {
        var button = ui.button({
          contents: options.findnreplace.icon,
          container: options.container,
          tooltip:  lang.findnreplace.tooltip,
          placement: options.placement,
          click: function (e) {
            e.preventDefault();
            $editor.find('.note-findnreplace').contents().unwrap('mark');
            $('#findnreplaceToolbar').toggleClass(options.findnreplace.classHidden);
            $('.note-status-output').text('');
            if ($note.summernote('createRange').toString()) {
              var selected = $note.summernote('createRange').toString();
              $('#note-findnreplace-find').val(selected);
            }
          }
        });
        return button.render();
      });
      this.initialize = function () {
        var fnrBody =
        '<div id="findnreplaceToolbar" class="note-display-none">' +
          '<div class="note-form-row">' +
            '<input id="note-findnreplace-find" type="text" class="note-findnreplace-find note-input" value="" placeholder="' + lang.findnreplace.findPlaceholder + '">' +
            '<button class="note-findnreplace-find-btn note-btn">' + lang.findnreplace.findBtn + '</button>' +
          '</div>' +
          '<div class="note-form-row">' +
            '<input id="note-findnreplace-replace" type="text" class="note-findnreplace-replace note-input" value="" placeholder="' + lang.findnreplace.replacePlaceholder + '">' +
            '<button class="note-findnreplace-replace-btn btn btn-default note-btn" style="width:100px;">' + lang.findnreplace.replaceBtn + '</button>' +
          '</div>' +
        '</div>';
        $('.note-toolbar').append(fnrBody);
        this.show();
      };
      this.findnreplace = function() {
        var $fnrFindBtn    = $('.note-findnreplace-find-btn');
        var $fnrReplaceBtn = $('.note-findnreplace-replace-btn');
        $fnrFindBtn.click(function (e) {
          e.preventDefault();
          $editor.find('.note-findnreplace').contents().unwrap('mark');
          var fnrCode    = context.invoke('code');
          var fnrFind    = $('.note-findnreplace-find').val();
          var fnrReplace = $('.note-findnreplace-replace').val();
          var fnrCount   = (fnrCode.match(new RegExp(fnrFind + "(?![^<>]*>)", "gi")) || []).length
          if (fnrFind) {
            $('.note-status-output').text(fnrCount + lang.findnreplace.findResult + "`" + fnrFind + "`");
            var fnrReplaced = fnrCode.replace(new RegExp(fnrFind + "(?![^<>]*>)", "gi"), function(e){return '<mark class="note-findnreplace">' + e + '</mark>';});
            $note.summernote('code',fnrReplaced);
          } else
            $('.note-status-output').html(lang.findnreplace.findError);
        });
        $fnrReplaceBtn.click(function (e) {
          e.preventDefault();
          $editor.find('.note-findnreplace').contents().unwrap('mark');
          var fnrCode    = context.invoke('code');
          var fnrFind    = $('.note-findnreplace-find').val();
          var fnrReplace = $('.note-findnreplace-replace').val();
          var fnrCount   = (fnrCode.match(new RegExp(fnrFind, "gi")) || []).length
          if (fnrFind) {
            $('.note-status-output').text(fnrCount + lang.findnreplace.findResult + "`" + fnrFind + "`" + lang.findnreplace.replaceResult +"`" + fnrReplace + "`");
            var fnrReplaced = fnrCode.replace(new RegExp(fnrFind + "(?![^<>]*>)", "gi"), fnrReplace);
            $note.summernote('code', fnrReplaced);
          } else {
            if (fnrReplace) {
              if ($note.summernote('createRange').toString()) {
                $note.summernote('insertText',fnrReplace);
                $('.note-status-output').text('');
              } else
                $('.note-status-output').html(lang.findnreplace.noneSelected);
            } else
              $('.note-status-output').html(lang.findnreplace.replaceError);
          }
        });
      };
      this.show = function() {
        this.findnreplace();
      };
    }
  });
}));

/* https://github.com/DiemenDesign/summernote-cleaner */
(function (factory) {
  if (typeof define === 'function' && define.amd) {
    define(['jquery'], factory);
  } else if (typeof module === 'object' && module.exports) {
    module.exports = factory(require('jquery'));
  } else {
    factory(window.jQuery);
  }
}
(function ($) {
  $.extend(true, $.summernote.lang, {
    'en-US': {
      cleaner: {
        tooltip: 'Cleaner',
        not: 'Text has been Cleaned!!!',
        limitText: 'Text',
        limitHTML: 'HTML'
      }
    },
    'de-DE': {
      cleaner: {
        tooltip: 'Cleaner',
        not: 'Inhalt wurde bereinigt!',
        limitText: 'Text',
        limitHTML: 'HTML'
      }
    },
  });
  $.extend($.summernote.options, {
    cleaner: {
      action: 'both', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
      newline: '<br>', // Summernote's default is to use '<p><br></p>'
      icon: '<i class="note-icon"><svg xmlns="http://www.w3.org/2000/svg" id="libre-paintbrush" viewBox="0 0 14 14" width="14" height="14"><path d="m 11.821425,1 q 0.46875,0 0.82031,0.311384 0.35157,0.311384 0.35157,0.780134 0,0.421875 -0.30134,1.01116 -2.22322,4.212054 -3.11384,5.035715 -0.64956,0.609375 -1.45982,0.609375 -0.84375,0 -1.44978,-0.61942 -0.60603,-0.61942 -0.60603,-1.469866 0,-0.857143 0.61608,-1.419643 l 4.27232,-3.877232 Q 11.345985,1 11.821425,1 z m -6.08705,6.924107 q 0.26116,0.508928 0.71317,0.870536 0.45201,0.361607 1.00781,0.508928 l 0.007,0.475447 q 0.0268,1.426339 -0.86719,2.32366 Q 5.700895,13 4.261155,13 q -0.82366,0 -1.45982,-0.311384 -0.63616,-0.311384 -1.0212,-0.853795 -0.38505,-0.54241 -0.57924,-1.225446 -0.1942,-0.683036 -0.1942,-1.473214 0.0469,0.03348 0.27455,0.200893 0.22768,0.16741 0.41518,0.29799 0.1875,0.130581 0.39509,0.24442 0.20759,0.113839 0.30804,0.113839 0.27455,0 0.3683,-0.247767 0.16741,-0.441965 0.38505,-0.753349 0.21763,-0.311383 0.4654,-0.508928 0.24776,-0.197545 0.58928,-0.31808 0.34152,-0.120536 0.68974,-0.170759 0.34821,-0.05022 0.83705,-0.07031 z"/></svg></i>',
      keepHtml: true, //Remove all Html formats
      keepOnlyTags: ['p','h1','h2','h3','h4','h5','h6','div','span'], // If keepHtml is true, remove all tags except these
      keepClasses: false, //Remove Classes
      badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html', 'body'], //Remove full tags with contents
      badAttributes: ['style', 'start'], //Remove attributes from remaining tags
      limitChars: 0, // 0|# 0 disables option
      limitDisplay: 'none', // none|text|html|both
      limitStop: false // true/false
    }
  });
  $.extend($.summernote.plugins, {
    'cleaner': function (context) {
      var self = this,
            ui = $.summernote.ui,
         $note = context.layoutInfo.note,
       $editor = context.layoutInfo.editor,
       options = context.options,
          lang = options.langInfo;
      if (options.cleaner.action == 'both' || options.cleaner.action == 'button') {
        context.memo('button.cleaner', function () {
          var button = ui.button({
            contents: options.cleaner.icon,
            container: options.container,
            tooltip: lang.cleaner.tooltip,
            placement: options.placement,
            click: function () {
              if ($note.summernote('createRange').toString()) {
                $note.summernote('pasteHTML', $note.summernote('createRange').toString());
              } else {
                $note.summernote('code', parseWordDocxFile($note.summernote('code')));
              }

              if ($editor.find('.note-status-output').length > 0) {
                $editor.find('.note-status-output').html(lang.cleaner.not);
              }
            }
          });
          return button.render();
        });
      }
      this.events = {
        'summernote.init': function () {
          if (options.cleaner.limitChars != 0 || options.cleaner.limitDisplay != 'none') {
            var textLength = $editor.find(".note-editable").text().replace(/(<([^>]+)>)/ig, "").replace(/( )/, " ");
            var codeLength = $editor.find('.note-editable').html();
            var lengthStatus = '';
            if (textLength.length > options.cleaner.limitChars && options.cleaner.limitChars > 0) {
              lengthStatus += 'note-text-danger">';
            } else {
              lengthStatus += '">';
            }

            if (options.cleaner.limitDisplay == 'text' || options.cleaner.limitDisplay == 'both') {
              lengthStatus += lang.cleaner.limitText + ': ' + textLength.length;
            }

            if (options.cleaner.limitDisplay == 'both') {
              lengthStatus += ' / ';
            }

            if (options.cleaner.limitDisplay == 'html' || options.cleaner.limitDisplay == 'both') {
              lengthStatus += lang.cleaner.limitHTML + ': ' + codeLength.length;
            }

            $editor.find('.note-status-output').html('<small class="note-pull-right ' + lengthStatus + '&nbsp;</small>');
          }
        },
        'summernote.keydown': function (we, e) {
          if (options.cleaner.limitChars != 0 || options.cleaner.limitDisplay != 'none') {
            var textLength =  $editor.find(".note-editable").text().replace(/(<([^>]+)>)/ig, "").replace(/( )/, " ");
            var codeLength =  $editor.find('.note-editable').html();
            var lengthStatus = '';
            if (options.cleaner.limitStop == true && textLength.length >= options.cleaner.limitChars) {
              var key = e.keyCode;
              allowed_keys = [8, 37, 38, 39, 40, 46]
              if ($.inArray(key, allowed_keys) != -1) {
                $editor.find('.cleanerLimit').removeClass('note-text-danger');
                return true;
              } else {
                $editor.find('.cleanerLimit').addClass('note-text-danger');
                e.preventDefault();
                e.stopPropagation();
              }
            } else {
              if (textLength.length > options.cleaner.limitChars && options.cleaner.limitChars > 0) {
                lengthStatus += 'note-text-danger">';
              } else {
                lengthStatus += '">';
              }

              if (options.cleaner.limitDisplay == 'text' || options.cleaner.limitDisplay == 'both') {
                lengthStatus += lang.cleaner.limitText + ': ' + textLength.length;
              }

              if (options.cleaner.limitDisplay == 'both') {
                lengthStatus += ' / ';
              }

              if (options.cleaner.limitDisplay == 'html' || options.cleaner.limitDisplay == 'both') {
                lengthStatus += lang.cleaner.limitHTML + ': ' + codeLength.length;
              }
              $editor.find('.note-status-output').html('<small class="cleanerLimit note-pull-right ' + lengthStatus + '&nbsp;</small>');
            }
          }
        },
        'summernote.paste': function (we, e) {
          if (options.cleaner.action == 'both' || options.cleaner.action == 'paste') {
            e.preventDefault();
            var ua   = window.navigator.userAgent;
            var msie = ua.indexOf("MSIE ");
                msie = msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./);
            var ffox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
            if (msie) {
              var text = window.clipboardData.getData("Text");
            } else {
              var text = e.originalEvent.clipboardData.getData(options.cleaner.keepHtml ? 'text/html' : 'text/plain');
            }

            if (text) {
              if (msie || ffox) {
                setTimeout(function () {
                  $note.summernote('pasteHTML', parseWordDocxFile(text));
                }, 1);
              } else {
                $note.summernote('pasteHTML', parseWordDocxFile(text));
              }

              if ($editor.find('.note-status-output').length > 0) {
                $editor.find('.note-status-output').html(lang.cleaner.not);
              }
            }
          }
        }
      }
    }
  });
}));
function parseWordDocxFile(html) {
  html = html.replace(/<(\/)*(\\?xml:|meta|link|span|font|del|ins|st1:|[ovwxp]:)((.|\s)*?)>/gi, ''); // Unwanted tags
  html = html.replace(/(class|style|type|start|lang|tag|target|title|alt|width|height|bgcolor)=("(.*?)"|(\w*))/gi, ''); // Unwanted sttributes
  html = html.replace(/(align)="center"(""|(\w*))/gi, 'class="text-center"'); // Unwanted sttributes
  html = html.replace(/(align)="justify"(""|(\w*))/gi, 'class="text-justify"'); // Unwanted sttributes
  html = html.replace(/<style(.*?)style>/gi, '');   // Style tags
  html = html.replace(/<script(.*?)script>/gi, ''); // Script tags
  html = html.replace(/<b([^>]*)>/gi, '');
  html = html.replace(/<\/b>/gi, '');
  html = html.replace(/<u([^>]*)>/gi, '');
  html = html.replace(/<\/u>/gi, '');
  html = html.replace(/<i([^>]*)>/gi, '');
  html = html.replace(/<\/i>/gi, '');
  html = html.replace(/<ol([^>]*)>/gi, '');
  html = html.replace(/<\/ol>/gi, '');
  html = html.replace(/<ul([^>]*)>/gi, '');
  html = html.replace(/<\/ul>/gi, '');
  html = html.replace(/<li([^>]*)>/gi, '');
  html = html.replace(/<\/li>/gi, '');
  html = html.replace(/<strong([^>]*)>/gi, '');
  html = html.replace(/<\/strong>/gi, '');
  html = html.replace( /<H1([^>]*)>/gi, '<h1>');
  html = html.replace( /<H2([^>]*)>/gi, '<h2>');
  html = html.replace( /<H3([^>]*)>/gi, '<h3>');
  html = html.replace( /<H4([^>]*)>/gi, '<h4>');
  html = html.replace( /<H5([^>]*)>/gi, '<h5>');
  html = html.replace( /<H6([^>]*)>/gi, '<h6>');
  html = html.replace(/<!--(.*?)-->/gi, '');        // HTML comments
  html = html.replace(/<p>\s*<\/p>/g, "");
  html = html.replace(/<p>.*?<\/p>/g, "");
  html = html.replace(/<(\w[^>]*) style="([^\"]*)"([^>]*)/gi, "<$1$3");
  html = html.replace(/\s*style="\s*"/gi, '');

  html = html.replace(/<[\^>]+><\/[\S]+>/gim, "");

  html = html.replace(/<[\S]+?><\/[\S]+>/gim, "");

//  html = html.replace(/<[\S] (.*?)="(.*?)">(\s<\s?br\s?\/>)*<\/[\S]>/gi, "");
  return html;
}

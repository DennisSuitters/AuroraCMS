/*! summernote-classes v0.2 + includes Bootstrap 4 sample classes */
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
      classes: {
        a: [ 'btn' , 'btn-block', 'btn-link', 'btn-dark', 'btn-primary', 'btn-secondary', 'btn-success', 'btn-info', 'btn-danger', 'btn-warning', 'text-lowercase', 'text-uppercase', 'text-capitalize', 'text-monospace' ],
        blockquote: [ 'color-muted', 'margin-top-1', 'margin-top-2', 'margin-top-3', 'margin-top-4', 'margin-top-5', 'margin-y-1', 'margin-y-2', 'margin-y-3', 'margin-y-4', 'margin-y-5', 'padding-1', 'padding-2', 'padding-3', 'padding-4' ,'padding-5', 'select-disabled', 'select-all' ],
        button: [ 'btn-block', 'btn-link', 'btn-primary', 'btn-secondary', 'btn-success', 'btn-info', 'btn-danger', 'btn-warning', 'text-lowercase', 'text-uppercase', 'text-capitalize', 'text-monospace' ],
        caption: [ 'text-center', 'text-right', 'font-weight-light', 'font-weight-bold', 'small', 'select-disabled', 'select-all' ],
        dd: [ 'padding-1', 'padding-2', 'padding-3', 'padding-4', 'padding-5' ],
        details: [ 'border', 'margin-y-1', 'margin-y-2', 'margin-y-3', 'margin-y-4', 'margin-y-5', 'padding-1', 'padding-2', 'padding-3', 'padding-4', 'padding-5', 'select-disabled', 'select-all' ],
        div: [ 'alert', 'alert-default', 'alert-primary', 'alert-info', 'alert-danger', 'alert-warning', 'alert-success', 'font-weight-light', 'font-weight-bold', 'color-muted', 'text-center', 'text-right', 'text-justify', 'text-wrap', 'text-nowrap', 'text-truncate', 'text-break', 'text-lowercase', 'text-uppercase', 'text-capitalize', 'text-monospace', 'lead', 'small', 'text-2x', 'border', 'margin-top-1', 'margin-top-2', 'margin-top-3', 'margin-top-4', 'margin-top-5', 'margin-y-1', 'margin-y-2', 'margin-y-3', 'margin-y-4', 'margin-y-5', 'padding-1', 'padding-2', 'padding-3', 'padding-4' ,'padding-5', 'select-disabled' ,'select-all' ],
        dl: [ 'margin-top-1', 'margin-top-2', 'margin-top-3', 'margin-top-4', 'margin-top-5', 'select-disabled' ,'select-all'  ],
        dt: [ 'margin-top-1', 'margin-top-2', 'margin-top-3', 'margin-top-4', 'margin-top-5', 'margin-y-1', 'margin-y-2', 'margin-y-3', 'margin-y-4', 'margin-y-5', 'text-center', 'text-right', 'text-lowercase', 'text-uppercase', 'text-capitalize' ],
        fieldset: [ 'margin-top-1', 'margin-top-2', 'margin-top-3', 'margin-top-4', 'margin-top-5', 'margin-y-1', 'margin-y-2', 'margin-y-3', 'margin-y-4', 'margin-y-5', 'padding-1', 'padding-2', 'padding-3', 'padding-4', 'padding-5', 'select-disabled' ,'select-all'  ],
        figcaption: [ 'text-center', 'text-right', 'font-weight-light', 'font-weight-bold', 'small', 'select-disabled', 'select-all' ],
        figure: [ 'responsive', 'float-left', 'float-center', 'float-right', 'shadow-sm', 'shadow', 'shadow-lg', 'border', 'margin-top-1', 'margin-top-2', 'margin-top-3', 'margin-top-4', 'margin-top-5', 'margin-y-1', 'margin-y-2', 'margin-y-3', 'margin-y-4', 'margin-y-5', 'padding-1', 'padding-2', 'padding-3', 'padding-4', 'padding-5', 'select-disabled', 'select-all' ],
        h1: [ 'margin-top-1', 'margin-top-2', 'margin-top-3', 'margin-top-4', 'margin-top-5', 'margin-y-1', 'margin-y-2', 'margin-y-3', 'margin-y-4', 'margin-y-5', 'select-disabled' ,'select-all' ],
        h2: [ 'margin-top-1', 'margin-top-2', 'margin-top-3', 'margin-top-4', 'margin-top-5', 'margin-y-1', 'margin-y-2', 'margin-y-3', 'margin-y-4', 'margin-y-5', 'select-disabled' ,'select-all' ],
        h3: [ 'margin-top-1', 'margin-top-2', 'margin-top-3', 'margin-top-4', 'margin-top-5', 'margin-y-1', 'margin-y-2', 'margin-y-3', 'margin-y-4', 'margin-y-5', 'select-disabled' ,'select-all' ],
        h4: [ 'margin-top-1', 'margin-top-2', 'margin-top-3', 'margin-top-4', 'margin-top-5', 'margin-y-1', 'margin-y-2', 'margin-y-3', 'margin-y-4', 'margin-y-5', 'select-disabled' ,'select-all' ],
        h5: [ 'margin-top-1', 'margin-top-2', 'margin-top-3', 'margin-top-4', 'margin-top-5', 'margin-y-1', 'margin-y-2', 'margin-y-3', 'margin-y-4', 'margin-y-5', 'select-disabled' ,'select-all' ],
        h6: [ 'margin-top-1', 'margin-top-2', 'margin-top-3', 'margin-top-4', 'margin-top-5', 'margin-y-1', 'margin-y-2', 'margin-y-3', 'margin-y-4', 'margin-y-5', 'select-disabled' ,'select-all' ],
        img: [ 'img-fluid', 'float-left', 'float-center', 'float-right', 'img-rounded', 'img-circle', 'shadow-sm', 'shadow' ,'shadow-lg' ,'img-thumbnail', 'select-disabled', 'select-all'],
        legend: [ 'd-inline', 'd-block' ],
        ol: [ 'list-unstyled', 'margin-top-1', 'margin-top-2', 'margin-top-3', 'margin-top-4', 'margin-top-5', 'margin-y-1', 'margin-y-2', 'margin-y-3', 'margin-y-4', 'margin-y-5', 'select-disabled' ,'select-all' ],
        p: [ 'first-letter-2', 'first-letter-3', 'first-letter-4', 'first-letter-5', 'first-line', 'font-weight-light', 'font-weight-bold', 'color-muted', 'color-danger', 'color-success', 'color-info', 'color-warning', 'text-center', 'text-right', 'text-justify', 'text-wrap', 'text-nowrap', 'text-truncate', 'text-break', 'text-lowercase', 'text-uppercase', 'text-capitalize', 'text-monospace', 'lead', 'small', 'text-2x', 'border', 'margin-top-1', 'margin-top-2', 'margin-top-3', 'margin-top-4', 'margin-top-5', 'margin-y-1', 'margin-y-2', 'margin-y-3', 'margin-y-4', 'margin-y-5', 'padding-1', 'padding-2', 'padding-3', 'padding-4' ,'padding-5' ,'select-disabled', 'select-all'],
        span: [ 'font-weight-light', 'font-weight-bold', 'color-muted', 'color-danger', 'color-success', 'color-info', 'color-warning' ],
        summary: [ 'font-weight-light', 'font-weight-bold'],
        table: [ 'margin-top-1', 'margin-top-2', 'margin-top-3', 'margin-top-4', 'margin-top-5', 'margin-y-1', 'margin-y-2', 'margin-y-3', 'margin-y-4', 'margin-y-5', 'select-disabled' ,'select-all' ],
        ul: [ 'list-unstyled', 'margin-top-1', 'margin-top-2', 'margin-top-3', 'margin-top-4', 'margin-top-5', 'margin-y-1', 'margin-y-2', 'margin-y-3', 'margin-y-4', 'margin-y-5', 'select-disabled' ,'select-all' ],
      }
    }
  });
  $.extend($.summernote.options, {
    disableTableNesting: true,
    classes: {
      a: [ 'btn' , 'btn-block', 'btn-link', 'btn-dark', 'btn-primary', 'btn-secondary', 'btn-success', 'btn-info', 'btn-danger', 'btn-warning', 'text-lowercase', 'text-uppercase', 'text-capitalize', 'text-monospace' ],
      blockquote: [ 'text-muted', 'mt-1', 'mt-2', 'mt-3', 'mt-4', 'mt-5', 'my-1', 'my-2', 'my-3', 'my-4', 'my-5', 'p-1', 'p-2', 'p-3', 'p-4' ,'p-5', 'select-disabled', 'select-all' ],
      button: [ 'btn-block', 'btn-link', 'btn-primary', 'btn-secondary', 'btn-success', 'btn-info', 'btn-danger', 'btn-warning', 'text-lowercase', 'text-uppercase', 'text-capitalize', 'text-monospace' ],
      caption: [ 'text-center', 'text-right', 'font-weight-light', 'font-weight-bold', 'small', 'select-disabled', 'select-all' ],
      dd: [ 'p-1', 'p-2', 'p-3', 'p-4', 'p-5' ],
      details: [ 'border', 'my-1', 'my-2', 'my-3', 'my-4', 'my-5', 'p-1', 'p-2', 'p-3', 'p-4', 'p-5', 'select-disabled', 'select-all' ],
      div: [ 'alert', 'alert-default', 'alert-primary', 'alert-info', 'alert-danger', 'alert-warning', 'alert-success', 'font-weight-light', 'font-weight-bold', 'text-muted', 'text-center', 'text-right', 'text-justify', 'text-wrap', 'text-nowrap', 'text-truncate', 'text-break', 'text-lowercase', 'text-uppercase', 'text-capitalize', 'text-monospace', 'lead', 'small', 'text-2x', 'border', 'mt-1', 'mt-2', 'mt-3', 'mt-4', 'mt-5', 'my-1', 'my-2', 'my-3', 'my-4', 'my-5', 'p-1', 'p-2', 'p-3', 'p-4' ,'p-5', 'select-disabled' ,'select-all' ],
      dl: [ 'mt-1', 'mt-2', 'mt-3', 'mt-4', 'mt-5', 'select-disabled' ,'select-all'  ],
      dt: [ 'mt-1', 'mt-2', 'mt-3', 'mt-4', 'mt-5', 'my-1', 'my-2', 'my-3', 'my-4', 'my-5', 'text-center', 'text-right', 'text-lowercase', 'text-uppercase', 'text-capitalize' ],
      fieldset: [ 'mt-1', 'mt-2', 'mt-3', 'mt-4', 'mt-5', 'my-1', 'my-2', 'my-3', 'my-4', 'my-5', 'p-1', 'p-2', 'p-3', 'p-4', 'p-5', 'select-disabled' ,'select-all'  ],
      figcaption: [ 'text-center', 'text-right', 'font-weight-light', 'font-weight-bold', 'small', 'select-disabled', 'select-all' ],
      figure: [ 'responsive', 'float-left', 'float-center', 'float-right', 'shadow-sm', 'shadow', 'shadow-lg', 'border', 'mt-1', 'mt-2', 'mt-3', 'mt-4', 'mt-5', 'my-1', 'my-2', 'my-3', 'my-4', 'my-5', 'p-1', 'p-2', 'p-3', 'p-4', 'p-5', 'select-disabled', 'select-all' ],
      h1: [ 'mt-1', 'mt-2', 'mt-3', 'mt-4', 'mt-5', 'my-1', 'my-2', 'my-3', 'my-4', 'my-5', 'select-disabled' ,'select-all' ],
      h2: [ 'mt-1', 'mt-2', 'mt-3', 'mt-4', 'mt-5', 'my-1', 'my-2', 'my-3', 'my-4', 'my-5', 'select-disabled' ,'select-all' ],
      h3: [ 'mt-1', 'mt-2', 'mt-3', 'mt-4', 'mt-5', 'my-1', 'my-2', 'my-3', 'my-4', 'my-5', 'select-disabled' ,'select-all' ],
      h4: [ 'mt-1', 'mt-2', 'mt-3', 'mt-4', 'mt-5', 'my-1', 'my-2', 'my-3', 'my-4', 'my-5', 'select-disabled' ,'select-all' ],
      h5: [ 'mt-1', 'mt-2', 'mt-3', 'mt-4', 'mt-5', 'my-1', 'my-2', 'my-3', 'my-4', 'my-5', 'select-disabled' ,'select-all' ],
      h6: [ 'mt-1', 'mt-2', 'mt-3', 'mt-4', 'mt-5', 'my-1', 'my-2', 'my-3', 'my-4', 'my-5', 'select-disabled' ,'select-all' ],
      img: [ 'img-fluid', 'float-left', 'float-center', 'float-right', 'img-rounded', 'img-circle', 'shadow-sm', 'shadow' ,'shadow-lg' ,'img-thumbnail', 'select-disabled', 'select-all'],
      legend: [ 'd-inline', 'd-block' ],
      ol: [ 'list-unstyled', 'mt-1', 'mt-2', 'mt-3', 'mt-4', 'mt-5', 'my-1', 'my-2', 'my-3', 'my-4', 'my-5', 'select-disabled' ,'select-all' ],
      p: [ 'first-letter-2', 'first-letter-3', 'first-letter-4', 'first-letter-5', 'first-line', 'font-weight-light', 'font-weight-bold', 'color-muted', 'color-danger', 'color-success', 'color-info', 'color-warning', 'text-center', 'text-right', 'text-justify', 'text-wrap', 'text-nowrap', 'text-truncate', 'text-break', 'text-lowercase', 'text-uppercase', 'text-capitalize', 'text-monospace', 'lead', 'small', 'text-2x', 'border', 'mt-1', 'mt-2', 'mt-3', 'mt-4', 'mt-5', 'my-1', 'my-2', 'my-3', 'my-4', 'my-5', 'p-1', 'p-2', 'p-3', 'p-4', 'p-5', 'select-disabled', 'select-all'],
      span: [ 'font-weight-light', 'font-weight-bold', 'color-muted', 'color-danger', 'color-success', 'color-info', 'color-warning' ],
      summary: [ 'font-weight-light', 'font-weight-bold'],
      table: [ 'mt-1', 'mt-2', 'mt-3', 'mt-4', 'mt-5', 'my-1', 'my-2', 'my-3', 'my-4', 'my-5', 'select-disabled' ,'select-all' ],
      ul: [ 'list-unstyled', 'mt-1', 'mt-2', 'mt-3', 'mt-4', 'mt-5', 'my-1', 'my-2', 'my-3', 'my-4', 'my-5', 'select-disabled' ,'select-all' ],
    }
  });
  $.extend($.summernote.plugins, {
    'classes': function (context) {
      var self = this,
            ui = $.summernote.ui,
         $note = context.layoutInfo.note,
       $editor = context.layoutInfo.editor,
       $editable = context.layoutInfo.editable,
       options = context.options,
          lang = options.langInfo;
      this.events = {
        'summernote.mousedown': function (we,e) {
          e.stopPropagation();
          var el = e.target;
          var elem = $(":focus");
          var outputText='';
          if (options.disableTableNesting === true) {
            $('.note-toolbar [aria-label="Table"]').prop('disabled', false);
          }
          if (!el.classList.contains('note-editable')) {
            if (options.disableTableNesting === true) {
              if (el.nodeName == 'TD') {
                $('.note-toolbar [aria-label="Table"]').prop('disabled', true);
              }
            }
            outputText += el.nodeName;
            var nN=el.nodeName.toLowerCase();
            if(nN in options.classes) {
              outputText += ' class=&quot;';
              var nNc=options.classes[nN];
              $.each(nNc, function (index, value){
                if(el.classList.contains(options.classes[nN][index])){
                  outputText += '<span class="note-classes text-success cursor-default"';
                } else {
                  outputText += '<span class="note-classes cursor-default"';
                }
                outputText += ' data-class="' + options.classes[nN][index] + '"';
                outputText += '>' + lang.classes[nN][index] + ' </span>';
              });
              outputText += '&quot;';
            }
            $editor.find('.note-statusbar').html(outputText);
            $('.note-classes').on('click', function(){
              $(this).toggleClass('text-success');
              var classes=$(this).data('class');
              $(el).toggleClass(classes);
            });
          } else if (el.classList.contains('note-editable')) {
            $editor.find('.note-statusbar').html('');
          }
        },
        'summernote.codeview.toggled': function (we,e) {
          $editor.find('.note-statusbar').html('');
        }
      }
    }
  });
}));

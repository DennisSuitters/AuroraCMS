/* https://github.com/DiemenDesign/summernote-image-attributes */
(function (factory) {
  if (typeof define === 'function' && define.amd) {
    define(['jquery'], factory);
  } else if (typeof module === 'object' && module.exports) {
    module.exports = factory(require('jquery'));
  } else {
    factory(window.jQuery);
  }
}(function ($) {
  var readFileAsDataURL = function (file) {
    return $.Deferred( function (deferred) {
      $.extend(new FileReader(),{
        onload: function (event) {
          var sDataURL = event.target.result;
          deferred.resolve(sDataURL);
        },
        onerror: function () {
          deferred.reject(this);
        }
      }).readAsDataURL(file);
    }).promise();
  };
  $.extend(true,$.summernote.lang, {
    'en-US': { /* US English(Default Language) */
      imageAttributes: {
        dialogTitle: 'Edit Image',
        tooltip: 'Edit Image',
        tooltipButtonLock: 'Locked',
        tooltipButtonUnlock: 'Unlocked',
        tooltipButtonReset: 'Reset Size',
        source: 'Source',
        url: 'URL',
        browse: 'Browse',
        link: 'Link',
        target: 'Target',
        caption: 'Caption',
        captionHelp: 'Entering a Caption will place Image inside a Figure element',
        alt: 'Alt Text',
        class: 'Class',
        style: 'Style',
        width: 'Width',
        height: 'Height',
        editBtn: 'OK'
      }
    }
  });
  $.extend($.summernote.options, {
    imageAttributes: {
      icon: '<span class="note-icon-pencil"></span>',
      classShow: 'note-show',
      classHide: 'note-hide',
      class: true,
      style: true,
      sizing: true,
      figure: false,
      removeEmpty: true,
      imageFolder: '',
    }
  });
  $.extend($.summernote.plugins, {
    'imageAttributes': function (context) {
      var self      = this,
          ui        = $.summernote.ui,
          $note     = context.layoutInfo.note,
          $editor   = context.layoutInfo.editor,
          $editable = context.layoutInfo.editable,
          options   = context.options,
          lang      = options.langInfo,
          imageAttributesLimitation = '';
      if (options.maximumImageFileSize) {
        var unit = Math.floor(Math.log(options.maximumImageFileSize) / Math.log(1024));
        var readableSize = (options.maximumImageFileSize/Math.pow(1024,unit)).toFixed(2) * 1 + ' ' + ' KMGTP'[unit] + 'B';
        imageAttributesLimitation = '<small class="note-help-block">' + lang.image.maximumFileSize + ' : ' + readableSize+'</small>';
      }
      if( !('_counter' in $.summernote.options.imageAttributes)) {
        $.summernote.options.imageAttributes._counter = 0;
      }
      context.memo('button.imageAttributes', function() {
        var button = ui.button({
          contents: options.imageAttributes.icon,
          container: "body",
          tooltip:  lang.imageAttributes.tooltip,
          click: function () {
            context.invoke('imageAttributes.show');
          }
        });
        return button.render();
      });
      this.initialize = function () {
        var $container = options.dialogsInBody ? this.$body : options.container;
        $.summernote.options.imageAttributes._counter++;
        var i = $.summernote.options.imageAttributes._counter;
        var body =
          (options.disableUpload === false ?
            '<label for="note-imageAttributes-input' + i + '" class="note-form-label">' + lang.imageAttributes.source + '</label>' +
            '<div class="note-form-group">' +
              '<input id="note-imageAttributes-input' + i +'" class="note-imageAttributes-input note-input" type="file" name="files" accept="image/*" multiple="multiple">' +
              imageAttributesLimitation +
            '</div>'
          :
            ''
          ) +
          '<label for="note-imageAttributes-src' + i + '" class="note-form-label">' + lang.imageAttributes.url + '</label>' +
          '<div class="note-form-group">' +
            '<input id="note-imageAttributes-src-' + i + '" class="note-imageAttributes-src note-input" type="text">' +
            (options.fileExplorer !== '' ?
              '<button class="note-btn" onclick="' + options.fileExplorer + '(`note-imageAttributes-src-' + i + '`);">' + lang.image.fileBrowser + '</button>'
            :
              ''
            ) +
          '</div>' +
          '<label for="note-imageAttributes-alt' + i + '" class="note-form-label">' + lang.imageAttributes.alt + '</label>' +
          '<div class="note-form-group">' +
            '<input id="note-imageAttributes-alt' + i + '" class="note-imageAttributes-alt note-input" type="text">' +
          '</div>' +
          (options.imageAttributes.figure === true ?
            '<label for="note-imageAttributes-caption' + i + '" class="note-form-label">' + lang.imageAttributes.caption + '</label>' +
            '<div class="note-form-group">' +
              '<input id="note-imageAttributes-caption' + i + '" class="note-imageAttributes-caption note-input" type="text" placeholder="' + lang.imageAttributes.captionHelp + '">' +
            '</div>'
          :
            ''
          ) +
          (options.imageAttributes.class === true ?
            '<label for="note-imageAttributes-class' + i + '" class="note-form-label">' + lang.imageAttributes.class + '</label>' +
            '<div class="note-form-group">' +
              '<input id="note-imageAttributes-class' + i + '" class="note-imageAttributes-class note-input" type="text">' +
            '</div>'
          :
            ''
          ) +
          ( options.imageAttributes.style === true ?
            '<label for="note-imageAttributes-style' + i + '" class="note-form-label">' + lang.imageAttributes.style + '</label>' +
            '<div class="note-form-group">' +
              '<input id="note-imageAttributes-style' + i + '" class="note-imageAttributes-style note-input" type="text">' +
            '</div>'
          :
            ''
          ) +
          (options.imageAttributes.sizing === true ?
            '<div class="note-form-group pb-0">' +
              '<label for="note-imageAttributes-width' + i +'" class="note-form-label">' + lang.imageAttributes.width + '</label>' +
              '<label for="note-imageAttributes-height' + i +'" class="note-form-label">' + lang.imageAttributes.height + '</label>' +
            '</div>' +
            '<div class="note-form-group">' +
              '<div style="width:50%">' +
                '<input id="note-imageAttributes-width' + i +'" class="note-imageAttributes-width note-input" type="text">' +
              '</div>' +
              '<div style="width:50%">' +
                '<div class="note-form-group">' +
                  '<input id="note-imageAttributes-height' + i +'" class="note-imageAttributes-height note-input" type="text">' +
                  '<button class="note-btn note-btn-default note-imageAttributes-lock-button" aria-label="' + lang.imageAttributes.tooltipButtonLock + '" title="' + lang.imageAttributes.tooltipButtonLock + '">' +
                    '<span class="note-icon note-imageAttributes-icon-lock"><svg xmlns="http://www.w3.org/2000/svg" width="14px" height="14px" viewBox="0 0 1000 1000"><g><path d="M321.8,455.5h356.4V321.8c0-49.2-17.4-91.2-52.2-126c-34.8-34.8-76.8-52.2-126-52.2c-49.2,0-91.2,17.4-126,52.2c-34.8,34.8-52.2,76.8-52.2,126L321.8,455.5L321.8,455.5z M900.9,522.3v400.9c0,18.6-6.5,34.3-19.5,47.3c-13,13-28.8,19.5-47.3,19.5H165.9c-18.6,0-34.3-6.5-47.3-19.5c-13-13-19.5-28.8-19.5-47.3V522.3c0-18.6,6.5-34.3,19.5-47.3c13-13,28.8-19.5,47.3-19.5h22.3V321.8c0-85.4,30.6-158.7,91.9-219.9C341.3,40.7,414.7,10,500,10c85.3,0,158.7,30.6,219.9,91.9c61.3,61.3,91.9,134.6,91.9,219.9v133.6h22.3c18.6,0,34.3,6.5,47.3,19.5C894.4,488,900.9,503.7,900.9,522.3L900.9,522.3z"/></g></svg></span>' +
                  '<span class="note-icon note-imageAttributes-icon-unlock note-hide"><svg xmlns="http://www.w3.org/2000/svg" width="14px" height="14px" viewBox="0 0 438.533 438.533"><g><path d="M375.721,227.259c-5.331-5.331-11.8-7.992-19.417-7.992H146.176v-91.36c0-20.179,7.139-37.402,21.415-51.678 c14.277-14.273,31.501-21.411,51.678-21.411c20.175,0,37.402,7.137,51.673,21.411c14.277,14.276,21.416,31.5,21.416,51.678   c0,4.947,1.807,9.229,5.42,12.845c3.621,3.617,7.905,5.426,12.847,5.426h18.281c4.945,0,9.227-1.809,12.848-5.426 c3.606-3.616,5.42-7.898,5.42-12.845c0-35.216-12.515-65.331-37.541-90.362C284.603,12.513,254.48,0,219.269,0 c-35.214,0-65.334,12.513-90.366,37.544c-25.028,25.028-37.542,55.146-37.542,90.362v91.36h-9.135 c-7.611,0-14.084,2.667-19.414,7.992c-5.33,5.325-7.994,11.8-7.994,19.414v164.452c0,7.617,2.665,14.089,7.994,19.417   c5.33,5.325,11.803,7.991,19.414,7.991h274.078c7.617,0,14.092-2.666,19.417-7.991c5.325-5.328,7.994-11.8,7.994-19.417V246.673 C383.719,239.059,381.053,232.591,375.721,227.259z"/></g></svg></span>' +
                '</button>' +
                '<button class="note-btn note-btn-default note-imageAttributes-reset-size-button" aria-label="' + lang.imageAttributes.tooltipButtonReset + '" title="' + lang.imageAttributes.tooltipButtonReset + '">' +
                  '<span class="note-icon"><svg role="img" focusable="false" aria-hidden="true" width="14px" height="14px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14"><path d="M 1.9022804,3.8361672 C 2.9614922,2.1342268 4.8494698,1 7.0003,1 10.311762,1 12.9997,3.6885377 12.9997,6.9993999 12.9997,10.311462 10.311762,13 7.0003,13 3.8526705,13 1.2673534,10.570714 1.0195038,7.4860972 1.005101,7.304861 1.1329265,6.9993999 1.4689937,6.9993999 c 0.234647,0 0.4290859,0.180036 0.4482897,0.4140828 C 2.1279255,10.035407 4.3249649,12.09982 7.0003,12.09982 c 2.814563,0 5.09922,-2.2852571 5.09922,-5.1004201 0,-2.8139628 -2.284657,-5.0992199 -5.09922,-5.0992199 -1.8225645,0 -3.4230846,0.9583917 -4.3244649,2.3974795 l 1.194839,0.003 c 0.2484497,0 0.45009,0.2016404 0.45009,0.4500901 0,0.2484496 -0.2016403,0.45009 -0.45009,0.45009 H 1.45039 c -0.2484497,0 -0.45009,-0.2016404 -0.45009,-0.45009 v -2.429886 c 0,-0.2484497 0.2016403,-0.4500901 0.45009,-0.4500901 0.2484497,0 0.45009,0.2010403 0.45009,0.4500901 z m 5.0962192,1.3634727 c 0.9937988,0 1.8003601,0.8065613 1.8003601,1.8003601 0,0.9937988 -0.8065613,1.8003601 -1.8003601,1.8003601 -0.9937987,0 -1.80036,-0.8065613 -1.80036,-1.8003601 0,-0.9937988 0.8065613,-1.8003601 1.80036,-1.8003601 z"/></svg></span>' +
                '</button>' +
              '</div>' +
            '</div>' +
          '</div>'
        :
          '');
        this.$dialog=ui.dialog({
          className: 'note-image-modal' + (options.dialogsAnim != '' ? ' note-' + options.dialogsAnim : ''),
          title:  lang.imageAttributes.dialogTitle,
          body:   body,
          footer: '<button href="#" class="note-btn note-btn-primary note-imageAttributes-btn">' + lang.imageAttributes.editBtn + '</button>'
        }).render().appendTo($container);
      };
      this.destroy = function () {
        ui.hideDialog(this.$dialog);
        this.$dialog.remove();
      };
      this.bindEnterKey = function ($input,$btn) {
        $input.on('keypress', function (event) {
          if (event.keyCode === key.code.ENTER) {
            event.preventDefault();
            $btn.trigger('click');
          }
        });
      };
      this.bindLabels = function () {
        self.$dialog.find('.form-control:first').focus().select();
        self.$dialog.find('label').on('click', function () {
          $(this).parent().find('.form-control:first').focus();
        });
      };
      this.show = function () {
        var $img    = $($editable.data('target'));
        var imgInfo = {
          imgDom:  $img,
          src:     $img.attr('src'),
          alt:     $img.attr('alt'),
          class:   (options.imageAttributes.class ? $img.attr('class') : null),
          style:   (options.imageAttributes.style ? $img.attr('style') : null),
          width:   (options.imageAttributes.sizing ? $img.attr('width') : null),
          height:  (options.imageAttributes.sizing ? $img.attr('height') : null),
          caption: (options.imageAttributes.figure ? ($($img).next("figcaption") ? $img.next("figcaption").text() : null) : null),
          width:   $img.width(),
          height:  $img.height()
        };

        var img = new Image()
        img.onload = function () {
          imgInfo.naturalWidth = img.width;
          imgInfo.naturalHeight = img.height;
        }
        img.src = $img.attr('src');

        this.showImageAttributesDialog(imgInfo).then( function (imgInfo) {
          ui.hideDialog(self.$dialog);
          var $img = imgInfo.imgDom;
          if (options.imageAttributes.removeEmpty) {
            if (imgInfo.alt)    $img.attr('alt',   imgInfo.alt);    else $img.removeAttr('alt');
            if (imgInfo.class)  $img.attr('class', imgInfo.class);  else $img.removeAttr('class');
            if (imgInfo.style)  $img.attr('style', imgInfo.style);  else $img.removeAttr('style');
            if (imgInfo.width)  $img.attr('width', imgInfo.width);  else $img.removeAttr('width');
            if (imgInfo.height) $img.attr('height',imgInfo.height); else $img.removeAttr('height');
            if (imgInfo.src)    $img.attr('src',   imgInfo.src);    else $img.attr('src', '#');
          } else {
            $img.attr('alt',   imgInfo.alt);
            $img.attr('class', imgInfo.class);
            $img.attr('style', imgInfo.style);
            $img.attr('width', imgInfo.width);
            $img.attr('height',imgInfo.height);
            $img.attr('src',   imgInfo.src);
          }

          if (imgInfo.width) {
            $img.css('width', imgInfo.width);
          }

          if (imgInfo.height) {
            $img.css('height', imgInfo.height);
          }

          if (options.imageAttributes.figure === true) {
            $img.find("figcaption").remove();
            $img.unwrap("figure");
            $img.wrap('<figure></figure>');
            if(imgInfo.caption)$('<figcaption>' + imgInfo.caption + '</figcaption>').insertAfter($img);
          }
          $note.val(context.invoke('code'));
          $note.change();
        });
      };
      this.showImageAttributesDialog = function (imgInfo) {
        return $.Deferred( function (deferred) {
          var $imageSrc    = self.$dialog.find('.note-imageAttributes-src'),
              $imageInput  = self.$dialog.find('.note-imageAttributes-input'),
              $imageAlt    = self.$dialog.find('.note-imageAttributes-alt'),
              $imageClass  = self.$dialog.find('.note-imageAttributes-class'),
              $imageStyle  = self.$dialog.find('.note-imageAttributes-style'),
              $imageWidth  = self.$dialog.find('.note-imageAttributes-width'),
              $imageHeight = self.$dialog.find('.note-imageAttributes-height'),
              $lockButton  = self.$dialog.find('.note-imageAttributes-lock-button'),
              $lockIcon    = $lockButton.find('.note-imageAttributes-icon-lock'),
              $unlockIcon = $lockButton.find('.note-imageAttributes-icon-unlock'),
              $resetSizeButton = self.$dialog.find('.note-imageAttributes-reset-size-button'),
              $imageCaption= self.$dialog.find('.note-imageAttributes-caption'),
              $editBtn     = self.$dialog.find('.note-imageAttributes-btn');

          var isLocked = (typeof options.imageAttributes.manageAspectRatio === 'undefined') ? true : options.imageAttributes.manageAspectRatio;
          if(isLocked){
            $unlockIcon.addClass('note-hide').removeClass('note-show');
            $lockIcon.addClass('note-show').removeClass('note-hide');
            $lockButton.attr('aria-label',lang.imageAttributes.tooltipButtonLock).attr('title',lang.imageAttributes.tooltipButtonLock);
          } else {
            $unlockIcon.addClass('note-show').removeClass('note-hide');
            $lockIcon.addClass('note-hide').removeClass('note-show');
            $lockButton.attr('aria-label',lang.imageAttributes.tooltipButtonUnlock).attr('title',lang.imageAttributes.tooltipButtonUnlock);
          }

          $lockButton.on('click', function (event) {
            event.preventDefault();
            isLocked = !isLocked;

            if (isLocked) {
              $unlockIcon.addClass('note-hide').removeClass('note-show')
              $lockIcon.addClass('note-show').removeClass('note-hide')
              $imageHeight.val(imageAdjustedHeight($imageWidth.val(), imgInfo.naturalWidth, imgInfo.naturalHeight));
              $lockButton.attr('aria-label',lang.imageAttributes.tooltipButtonLock).attr('title',lang.imageAttributes.tooltipButtonLock);
            } else {
              $unlockIcon.addClass('note-show').removeClass('note-hide')
              $lockIcon.addClass('note-hide').removeClass('note-show')
              $lockButton.attr('aria-label',lang.imageAttributes.tooltipButtonUnlock).attr('title',lang.imageAttributes.tooltipButtonUnlock);
            }
          });

          $resetSizeButton.on('click', function (event) {
            event.preventDefault();
            $imageWidth.val(imgInfo.width);
            $imageHeight.val(imgInfo.height);
          });

          $imageHeight.on("input", function () {
            if (isLocked) {
              $imageWidth.val(imageAdjustedWidth(this.value, imgInfo.naturalWidth, imgInfo.naturalHeight));
            }
          });

          $imageWidth.on("input", function () {
            if (isLocked) {
              $imageHeight.val(imageAdjustedHeight(this.value, imgInfo.naturalWidth, imgInfo.naturalHeight));
            }
          });

          ui.onDialogShown(self.$dialog, function () {
            context.triggerEvent('dialog.shown');
            $imageInput.replaceWith(
              $imageInput.clone().on('change', function () {
                var callbacks = options.callbacks;
                if (callbacks.onImageUpload) {
                  context.triggerEvent('image.upload',this.files[0]);
                } else {
                  readFileAsDataURL(this.files[0]).then( function (dataURL) {
                    $imageSrc.val(dataURL);
                  }).fail( function () {
                    context.triggerEvent('image.upload.error');
                  });
                }
              }).val('')
            );
            $editBtn.click( function (event) {
              event.preventDefault();
              deferred.resolve({
                imgDom:     imgInfo.imgDom,
                src:        $imageSrc.val(),
                alt:        $imageAlt.val(),
                class:      $imageClass.val(),
                style:      $imageStyle.val(),
                width:      $imageWidth.val(),
                height:     $imageHeight.val(),
                caption:    $imageCaption.val(),
              }).then(function (img) {
                context.triggerEvent('change', $editable.html());
              });
            });
            $imageSrc.val(imgInfo.src);
            $imageAlt.val(imgInfo.alt);
            $imageClass.val(imgInfo.class);
            $imageStyle.val(imgInfo.style);
            $imageWidth.val(imgInfo.width);
            $imageHeight.val(imgInfo.height);
            $imageCaption.val(imgInfo.caption);
            self.bindEnterKey($editBtn);
            self.bindLabels();
          });
          ui.onDialogHidden(self.$dialog, function () {
            $editBtn.off('click');
            if (deferred.state() === 'pending') deferred.reject();
          });
          ui.showDialog(self.$dialog);
        });
      };

      function imageAdjustedHeight(heightInputValue, imageOriginalWidth, imageOriginalHeight) {
        return parseInt(heightInputValue * (imageOriginalHeight / imageOriginalWidth), 10)
      }

      function imageAdjustedWidth(widthInputValue, imageOriginalWidth, imageOriginalHeight) {
        return parseInt(widthInputValue * (imageOriginalWidth / imageOriginalHeight), 10)
      }

    }
  });
}));

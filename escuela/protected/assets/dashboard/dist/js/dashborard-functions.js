(function(){


    window.uniqid = function(){
        function rand(){
              return "xxxx_xxxx_xxxx_xxxx_xxxx".replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0, v = c == "x" ? r : (r & 0x3 | 0x8);
                return v.toString(16);
              });
        }
        return "node_" + rand();
    };

    window.isFunction = function(o){

        return Function.prototype.isPrototypeOf(o);
    };

    window.isElementNode = function(o){
        if($.isEmptyObject(o))

            return false;

        if($.isEmptyObject(o))
            return false;
        try{
            var obj = $(o)[0];
            return obj.nodeType === Node.ELEMENT_NODE  ? true : false;
        }
        catch(e){
            return false;
        }
    };

    window.isElementText = function(o, noEmpty){
        if(typeof o === 'string'  || typeof o === 'number' ){
            if(typeof noEmpty == 'undefined')
                return true;

            if(o.toString().length > 0)
                return true;
        }

        return false;
    };

    window.isBoolean = function (o){
        if(typeof o == 'boolean')
            return true;
        else
            return false;
    };

    window.registerWickedpicker = function(){

        $('input[type=text][data-runtime="wickedpicker"] ').each(function(k,v){

            function setDefaultTime(){
                if($(v).val().length > 0)
                    return $(v).val();

                if($(v).data('init') || false)
                    return $(v).data('init');

                return '07:00';
            }

            var options = {
                clearable       : false,
                minutesInterval : 15,
                twentyFour      : true,
                timeSeparator   : ':',
                now             : setDefaultTime(),
                beforeShow      : function(){
                    $(".wickedpicker").hide();
                    $(".wickedpicker__title").text( $(v).data('title') || 'Hora' );
                    resetBtn.show();
                }
            };

            var resetBtn = $('<span>');

            resetBtn.css({
                'position'  : 'absolute',
                'left'      :  '-5px',
                'top'       : '24px',
                'font-size' : '13px',
                'cursor'    : 'pointer',
                'color'     : '#a94442',
            });

            resetBtn.html('<i class="fa fa-times"></i>');
            resetBtn.appendTo($(v).parent());

            if($(v).val()=='')
                resetBtn.hide();

            resetBtn.on('click', function(){
                $(v).val('');
                $(this).hide();
            });

            $(v).off();
            $(v).on("focusin", function(){
                $(".wickedpicker").hide();
                $(v).wickedpicker(options);
            });
        });
    };


})();

//loader:
(function($){
    $.fn.addLoader = function(options){

        var config = {
            background   : 'rgba(255,255,255, 0.7)',
            borderRadius : '0px',
        };

        $.extend(config, options);

        var e  = $(this);

        if(e.find('[role="loader"]').length  > 0)
            return;


        var size  =  function(){
            var size = e.get(0).getBoundingClientRect();
            e.css({
                'max-height' : size.height + 'px',
                'overflow'   : 'hidden',
            });
            return size;
        }

        var loader = $("<div>")
            .attr('role', 'loader')
            .css({
                'top'             : 0,
                'width'           : '100%',
                'height'          : size().height + 'px',
                'display'         : 'flex',
                'flex-direction'  : 'column',
                'justify-content' : 'center',
                'align-items'     : 'center',
                'background-color': config.background,
                'border-radius'   : config.borderRadius,
                'position'        : 'absolute',
                'z-index'         : '999',

            })
            .addClass("fade in")
            .html('<span class="fa fa-circle-o-notch fa-spin fa-2x"></span>')
            .appendTo(e);
    }

    $.fn.rmLoader =  function(){
        var e = $(this);

        e.css({'max-height':'none', 'overflow' : 'visible'})
        e.find('[role="loader"]').removeClass("in").remove()
    }
})(jQuery);

//modal
(function(){

    function domModal(){
        var obj = {};
            obj.loginUrl = null;
        obj.setLoginUrl = function(url){
            obj.loginUrl = url;
        }

        obj.getLoginUrl = function(){
           return obj.loginUrl;
        }

        obj.icon = (function(){
            var e = $('<i>');
            return e;
        })();

        obj.title = (function(){
            var e = $('<span>')
            return e;
        })();

        obj.header = (function(){

            var e = $('<div>')

            e.btnClose = $('<button>').attr({
                'type'  : 'button',
                'class' : 'close',
                'data-dismiss' : 'modal',
            }).html('&times;');

            (function(){
                e.append(e.btnClose);

                $('<h4>')
                    .addClass('modal-title')
                    .append(obj.icon)
                    .append(obj.title)
                    .appendTo(e);
            })();

            return e;
        })();

        obj.body = (function(){
            var e = $('<div>')
            return e;
        })();

        obj.footer = (function(){

            var e = $('<div>')
                .addClass('modal-footer');
            return e;
        })();

        obj.content = (function(){

            var e = $('<div>')
                .append(obj.header)
                .append(obj.body)
                .append(obj.footer);

            return e;
        })();

        obj.dialog = (function(){
            var e = $('<div>')
                .append(obj.content);
            return e;
        })();

        obj.bsModal = (function(){
            var e = $('<div>')
                .attr('id',   uniqid())
                .attr('role', 'dialog')
                .html(obj.dialog)
            return e;
        })();

        obj.addLoader = function( callback ){

            if(obj.content.find('[role="loader"]').length > 0)
                return;

            if( obj.bsModal.is(':visible') == 0)
            {
                obj.reset('css');
                obj.reset('content');
                dialogH = 150;
                obj.header.hide();
                obj.footer.hide();
                obj.body.hide();

                var loader = $("<div>")
                    .attr('role', 'loader')
                    .css({
                        'top'             : 0,
                        'width'           : '100%',
                        'height'          : dialogH + 'px',
                        'display'         : 'flex',
                        'flex-direction'  : 'column',
                        'justify-content' : 'center',
                        'align-items'     : 'center',
                        'border-radius'    : '4px',
                        'background-color' : '#FFF',
                    }).html('<span class="fa fa-circle-o-notch fa-spin fa-2x"></span>');
                obj.content.append(loader);
                obj.open();
            }
            else
                $(obj.content).addLoader();

            if(isFunction(callback))
                callback();
        }

        obj.rmLoader = function( callback ){
            $(obj.content)
                .rmLoader();
        }

        obj.open = function(){

            if(obj.bsModal.is(':visible') == false)
            {
                $('body').prepend(obj.bsModal);
                obj.bsModal.modal({
                    'backdrop' : 'static',
                    'keyboard' : 'true',
                });
            }
        };

        obj.hide = function(){
            obj.content.addClass("fade");
        };

        obj.show = function(){
            obj.content.addClass("fade in");
        };

        obj.fail = function(titleError, msnError, btnCloseTitle, closeCallBack){

            var msnError = $('<p>')
                .html(msnError);

            var btnClose = $('<button>').attr({
                'class'         : 'btn btn-danger',
                'type'          : 'button',
                'data-dismiss'  : 'modal',
            });

            if(isElementText(btnCloseTitle, true))
                btnClose.text(btnCloseTitle);
            else
                btnClose.html('Ok');

            this.icon.attr('class', 'fa fa-bug text-danger');
            this.title.attr('class','text-danger');
            this.title.html(titleError);
            this.header.show();

            this.body.html(msnError).show();
            this.footer.html(btnClose).show();

            this.bsModal.off('hide.bs.modal');
            this.bsModal.off('hidden.bs.modal');

            this.bsModal.on('hide.bs.modal', function(e){
                return true;
            });

            this.bsModal.on('hidden.bs.modal', function (e){

                if( isFunction(closeCallBack))
                {
                    $(this).remove();
                    closeCallBack();
                }
                /*
                // dev off
                else
                    window.location.reload(true);
                */
            });

            obj.open();
        }

        obj.load = function(url){

            obj.addLoader();
            setTimeout(function(){
                $.ajax({
                    url : url,
                    data : {'modal-load' : true },
                    type : 'get',
                    dataType : 'html',
                })
                .done(function(data){
                    obj.reset.default(true);
                    obj.rmLoader();
                    obj.body.html(data).show();
                })
                .fail(function(data){
                    var prevUrl = this.url;

                    switch(data.status)
                    {
                        case 0:
                            window.location.reload(true);
                            return;

                        case 401:
                            $.ajax({
                                url : obj.loginUrl,
                                data : {'modal-load' : true , 'prev-url' : prevUrl},
                                type : 'get',
                                dataType : 'html',
                            })
                            .done(function(data){

                                obj.reset.default(true);
                                obj.size('modal-confirm');
                                obj.icon.attr('class', 'fa fa-lock');
                                obj.title.html('Iniciar sesión');
                                obj.header.show();
                                obj.body.html(data).show();
                                obj.rmLoader();
                                obj.registerEvent('afterClose', function(){
                                    window.location.reload(true);
                                }, true);
                            })
                            .fail(function(data){
                                window.location.reload(true);
                            });
                            return;

                        default:
                            obj.fail(data.status, data.responseText);
                            obj.rmLoader();
                            return;
                    }
                });
            }, 200);
        }

        obj.close = function(){

            if(obj.bsModal.is(':visible') == true)
                obj.bsModal.modal('hide');
        };

        obj.remove = function(overload){
            obj.close();

            overload = overload || false;

            obj.registerEvent('afterClose', function(){
                obj.bsModal.remove();
            }, overload);
        }

        obj.reset = function(param){

            switch(param)
            {
                //
                case 'events':
                    obj.bsModal.off("show.bs.modal");
                    obj.bsModal.off("shown.bs.modal");
                    obj.bsModal.off("hide.bs.modal");
                    obj.bsModal.off("hidden.bs.modal");
                    break;

                case 'show.bs.modal':
                case 'beforeOpen':
                    obj.bsModal.off("show.bs.modal");
                    break;

                case 'shown.bs.modal':
                case 'afterOpen':
                    obj.bsModal.off("shown.bs.modal");
                    break;

                case 'hide.bs.modal':
                case 'beforeClose':
                    obj.bsModal.off("hide.bs.modal");
                    break;

                case 'hidden.bs.modal':
                case 'afterClose':
                    obj.bsModal.off("hidden.bs.modal");
                    break;

                //
                case 'css':
                    if(obj.bsModal.is(':visible'))
                        obj.bsModal.attr('class', 'modal fade in');
                    else
                        obj.bsModal.attr('class', 'modal fade');

                    obj.dialog.attr('class',  'modal-dialog');
                    obj.content.attr('class', 'modal-content');
                    obj.header.attr('class', 'modal-header');
                    obj.header.btnClose.attr('class', 'close');
                    obj.icon.removeAttr('class');
                    obj.title.removeAttr('class');
                    obj.body.attr('class','modal-body');
                    obj.footer.attr('class','modal-footer');
                    break;

                //
                case 'content':
                    obj.icon.html('').removeAttr('class');
                    obj.title.html('');
                    obj.body.html('');
                    obj.footer.html('');
                    break;

                case 'icon-content':
                    obj.icon.html('').removeAttr('class');
                    break;

                case 'title-content':
                    obj.title.html('');
                    break;

                case 'body-content':
                    obj.body.html('');
                    break;

                case 'footer-content':
                    obj.footer.html('');
                    break;
            }
        }

        obj.reset.default = function(forceBodyContent ){

            forceBodyContent = (isBoolean(forceBodyContent)) ? forceBodyContent : false;
            obj.reset("events");
            obj.reset("icon-content");
            obj.reset("title-conten");
            obj.reset("footer-content");
            obj.reset("css");
            obj.body.attr("style", "");

            if(forceBodyContent)
                obj.reset("body-content");
        }

        obj.registerEvent = function(eventName, fn, overload)
        {
            overload = (isBoolean(overload)) ? overload : false;
            switch(eventName)
            {
                case 'show.bs.modal':
                case 'beforeOpen':
                    if(overload === true)
                        obj.reset(eventName);

                    if(isFunction(fn))
                        obj.bsModal.on('show.bs.modal', fn);
                    break;

                case 'shown.bs.modal':
                case 'afterOpen':
                    if(overload === true)
                        obj.reset(eventName);

                    if(isFunction(fn))
                        obj.bsModal.on('shown.bs.modal', fn);
                    break;

                case 'hide.bs.modal':
                case 'beforeClose':
                    if(overload === true)
                        obj.reset(eventName);

                    if(isFunction(fn))
                        obj.bsModal.on('hide.bs.modal', fn);
                    break;

                case 'hidden.bs.modal':
                case 'afterClose':
                    if(overload === true)
                        obj.reset(eventName);

                    if(isFunction(fn))
                        obj.bsModal.on('hidden.bs.modal', fn);
                    break;
            }
        }

        obj.size = function(sizeClass){

            obj.dialog.attr('class',  'modal-dialog');
            if(isElementText(sizeClass, true))
                obj.dialog.addClass(sizeClass);
        }

        obj.reset('css');
        return obj;
    }

    var modal = new domModal();

    modal.confirm = function(options){

        var m = new domModal();

        var config = {
            size            : 'modal-confirm',
            icon            : 'fa fa-question-circle',
            title           : 'Confirmación' ,
            confirm         : '¿Desea continuar?',
            label           : 'Si',
            labelCancel     : 'No',
            callbackOk      : function(){},
            callbackCancel  : function(){}
        };

        $.extend(config, options);
        m.size(config.size);
        m.icon.attr('class', config.icon);
        m.size(config.size);
        m.title.html(config.title);
        m.header.btnClose.hide();
        m.body.html(config.confirm);

        $("<button>")
            .addClass('btn btn-default')
            .html(config.label)
            .on('click', function(e){
                e.preventDefault();
                e.stopPropagation()
                m.registerEvent('afterClose', config.callbackOk)
                m.close();
            }).appendTo(m.footer);

        $("<button>")
            .addClass('btn btn-danger')
            .html(config.labelCancel)
            .on('click', function(e){
                e.preventDefault();
                e.stopPropagation();
                m.registerEvent('afterClose', config.callbackCancel)
                m.close();
            }).appendTo(m.footer);

        if($(".modal").has(':visible').length > 0)
        {
            var _modal = $(".modal").has(':visible').first();
                _modal
                    .fadeOut(450)
                    .removeClass('fade');

            setTimeout(function(){

                m.bsModal
                    .removeClass('fade')
                    .appendTo( $('body') )
                    .modal({
                        'backdrop' : false,
                        'keyboard' : false,
                    });

                m.registerEvent('afterClose', function(){
                    m.bsModal.remove();
                    _modal.fadeIn('450' , function(){
                        _modal.addClass('fade');
                    });
                });

            },420);
        }
        else{
            m.bsModal
                .modal({
                    'backdrop' : 'static',
                    'keyboard' : false,
                });
        }
    }

    window.modal  = window.modal  || modal;
})();

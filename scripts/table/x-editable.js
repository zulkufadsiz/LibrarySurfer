'use strict';
(function($) {
    'use strict';
    var countries=[];
    $(document).on('click', '#enable', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('#user .editable').editable('toggleDisabled');
    }
    );
    $.fn.editable.defaults.mode='inline';
    $.fn.editable.defaults.url='static_texts_change.php';
    $.fn.editableform.buttons='<button type="submit" class="btn btn-primary editable-submit">'+'<i class="material-icons">check</i>'+'</button>'+'<button type="button" class="btn btn-default editable-cancel">'+'<i class="material-icons">close</i>'+'</button>';
    $.fn.editabletypes.address.defaults=$.extend( {}
    , $.fn.editabletypes.abstractinput.defaults, {
        tpl: '<div class="editable-address"><label><span>City: </span><input type="text" name="city" class="form-control"></label></div>'+'<div class="editable-address"><label><span>Street: </span><input type="text" name="street" class="form-control"></label></div>'+'<div class="editable-address"><label><span>Building: </span><input type="text" name="building" class="form-control"></label></div>'
    }
    );
    $('#username').editable( {
        url: 'static_texts_change.php', type: 'text', pk: 1, name: 'username', title: 'Enter username'
    }
    );
    $('#user .editable').on('hidden', function(e, reason) {
        if(reason==='save'||reason==='nochange') {
            var $next=$(this).closest('tr').next().find('.editable');
            if($('#autoopen').is(':checked')) {
                setTimeout(function() {
                    $next.editable('show');
                }
                , 300);
            }
            else {
                $next.focus();
            }
        }
    }
    );
}

)(jQuery); //# sourceMappingURL=x-editable.js.map
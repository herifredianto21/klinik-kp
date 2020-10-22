$('a[href="#login"]').on('click', function(){
    $(this).attr('disabled', 'disabled');
    var missing = false;
    $('#formLogin').find('input').each(function(){
        if($(this).prop('required')){
            if($(this).val() == ''){
                var placeholder = $(this).attr('placeholder');
                $.notify({
                    icon: 'now-ui-icons ui-1_bell-53',
                    message: 'Kolom '+ placeholder +' tidak boleh kosong.'
                }, {
                    type: 'warning',
                    delay: 1000,
                    timer: 500,
                    placement: {
                      from: 'top',
                      align: 'center'
                    }
                });
                $(this).focus();
                missing = true;
                return false;
            }
        }
    });

    $(this).removeAttr('disabled');
    if(missing){
        return;
    }

    $.ajax({
        type: 'POST',
        url: baseurl + 'login/services?request=login',
        data: $('#formLogin').serialize(),
        dataType: 'json',
        success: function(response){
            if(response.result){
                window.location.replace(response.target);
            } else{
                $('input[name="password"]').val('');
                $('input[name="password"]').focus();
                $.notify({
                    icon: "now-ui-icons ui-1_bell-53",
                    message: response.msg
                }, {
                    type: 'danger',
                    delay: 3000,
                    timer: 1000,
                    placement: {
                      from: 'top',
                      align: 'center'
                    }
                });
            }
        }
    });
});

$('input').on('keypress', function(e){
    if (e.keyCode == '13') {
      $('a[href="#login"]').trigger('click');
    }
  });
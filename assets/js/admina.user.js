var table = '';
var selectType = '';

$('a[href="#menuTim"]').attr('aria-expanded', 'true');
$('#menuTim').addClass('show');
$('#li-user').addClass('active');

$(document).ready(function(){
	table = $('#tableUser').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'user/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'    : i,
                            'nik'   : response.data[x].nik,
                            'name'  : response.data[x].name,
                            'email' : response.data[x].email,
                            'type'  : response.data[x].type,
	            			'aksi'	: button
	            		});
	            		i = i + 1;
	            	}

	            	response.data = row;
            		return row;
            	} else{
            		response.draw = 0;
            		return [];
            	}
            }
        },

        'columns' : [
        	{ 'data' : 'no' },
            { 'data' : 'nik' },
            { 'data' : 'name' },
            { 'data' : 'email' },
            { 'data' : 'type' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 2, 'ASC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 5 ]
    		}
  		]
	});

    $('select[name="type"]').append('<option value="0">- Pilih User Type -</option>');
    selectType = $('select[name="type"]').select2({
        'theme': 'bootstrap4'
    });
});

$('button[name="btn_add"]').click(function(){
	$('button[name="btn_save"]').attr('id', '0');
    $('input[name="nik"]').val('');
    $('input[name="name"]').val('');
    $('input[name="email"]').val('');
    $('input[name="password"]').val('');
    $('input[name="retype_password"]').val('');
    $(selectType).val('0').trigger('change');
    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tableUser').on('click', 'button[name="btn_edit"]', function(){
	var id = $(this).attr('id');
	var nik = '';
    var name = '';
    var email = '';
    var type = '';
	$('#tableUser tbody tr').each(function(){
		var selected = $(this).find(':button').attr('id');
		if (selected == id) {
			nik = $(this).find('td:eq(1)').text();
            name = $(this).find('td:eq(2)').text();
            email = $(this).find('td:eq(3)').text();
            type = $(this).find('td:eq(4)').text();
		}
	});

	$('button[name="btn_save"]').attr('id', id);
	$('input[name="nik"]').val(nik);
    $('input[name="name"]').val(name);
    $('input[name="email"]').val(email);
    $('input[name="password"]').val('');
    $('input[name="retype_password"]').val('');
    $('input[name="type"]').val(type);
    $('#formTitle').text('Edit Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tableUser').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'user/delete/',
        data: {
        	'id': id
        },
        dataType: 'json',
        success: function(response){
            if(response.result){
            	$.notify({
                    icon: "now-ui-icons ui-1_bell-53",
                    message: response.msg
                }, {
                    type: 'primary',
                    delay: 3000,
                    timer: 1000,
                    placement: {
                      from: 'top',
                      align: 'center'
                    }
                });
                table.ajax.reload(null, false);
            } else{
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

$('button[name="btn_cancel"]').click(function(){
	$('button[name="btn_save"]').attr('id', '0');
	$('input[name="nik"]').val('');
    $('input[name="name"]').val('');
    $('input[name="email"]').val('');
    $('input[name="password"]').val('');
    $('input[name="retype_password"]').val('');
    $(selectType).val('0').trigger('change');

	$('#form').hide();
	setTimeout(function(){
		$('#table').fadeIn();
	}, 100);
});

$('button[name="btn_save"]').click(function(){
	$(this).attr('disabled', 'disabled');
    var missing = false;
    $('#formData').find('input').each(function(){
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

    var p1 = $('input[name="password"]').val();
    var p2 = $('input[name="retype_password"]').val();
    if (p1.length > 0) {
        if (p1 != p2) {
            $.notify({
                icon: 'now-ui-icons ui-1_bell-53',
                message: 'Password tidak sesuai.'
            }, {
                type: 'warning',
                delay: 1000,
                timer: 500,
                placement: {
                  from: 'top',
                  align: 'center'
                }
            });

            $('input[name="password"]').val('');
            $('input[name="retype_password"]').val('');
            $('input[name="password').focus();
            return;
        }
    } else{
        var id = $('this').attr('id');
        if (id == 0) {
            $.notify({
                icon: 'now-ui-icons ui-1_bell-53',
                message: 'Kolom Password tidak boleh kosong.'
            }, {
                type: 'warning',
                delay: 1000,
                timer: 500,
                placement: {
                  from: 'top',
                  align: 'center'
                }
            });

            return;
        }
    }

    if ($('select[name="type"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih user type terlebih dahulu.'
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
        return;
    }

    $.ajax({
        type: 'POST',
        url: baseurl + 'user/save/',
        data: {
        	'id': $(this).attr('id'),
        	'form': $('#formData').serialize()
        },
        dataType: 'json',
        success: function(response){
            if(response.result){
            	$.notify({
                    icon: "now-ui-icons ui-1_bell-53",
                    message: response.msg
                }, {
                    type: 'primary',
                    delay: 3000,
                    timer: 1000,
                    placement: {
                      from: 'top',
                      align: 'center'
                    }
                });
                table.ajax.reload(null, false);
                $('#form').hide();
				setTimeout(function(){
					$('#table').fadeIn();
				}, 100);
            } else{
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
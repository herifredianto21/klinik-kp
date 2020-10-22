var table = '';
var selectKota = '';

$('#li-supplier').addClass('active');

$(document).ready(function(){
	table = $('#tableSupplier').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'supplier/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'                : i,
                            'nama_supplier'     : response.data[x].nama_supplier,
                            'alamat_supplier'   : response.data[x].alamat_supplier,
                            'no_telepon'        : response.data[x].no_telepon,
                            'no_handphone'      : response.data[x].no_handphone,
                            'kontak_person'     : response.data[x].kontak_person,
                            'nama_bank'         : response.data[x].nama_bank,
                            'no_rekening'       : response.data[x].no_rekening,
                            'email'             : response.data[x].email,
                            'website'           : response.data[x].website,
                            'nama_kota'         : response.data[x].nama_kota,
	            			'aksi'	            : button
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
            { 'data' : 'nama_supplier' },
            { 'data' : 'alamat_supplier' },
            { 'data' : 'no_telepon' },
            { 'data' : 'no_handphone' },
            { 'data' : 'kontak_person' },
            { 'data' : 'nama_bank' },
            { 'data' : 'no_rekening' },
            { 'data' : 'email' },
            { 'data' : 'website' },
            { 'data' : 'nama_kota' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 1, 'ASC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 11 ]
    		}
  		]
	});

    $.ajax({
        type: 'GET',
        url: baseurl + 'supplier/select-kota/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_kota"]').append('<option value="0">- Pilih Kota -</option>');
                for(var x in response.data){
                    $('select[name="id_kota"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_kota+'</option>');
                }
            } else{
                $('select[name="id_kota"]').append('<option value="0">- Pilih Kota -</option>');
            }
        }
    });
    selectKota = $('select[name="id_kota"]').select2({
        'theme': 'bootstrap4'
    });
});

$('button[name="btn_add"]').click(function(){
	$('button[name="btn_save"]').attr('id', '0');
    $('input[name="nama_supplier"]').val('');
    $('input[name="alamat_supplier"]').val('');
    $('input[name="no_telepon"]').val('');
    $('input[name="no_handphone"]').val('');
    $('input[name="kontak_person"]').val('');
    $('input[name="nama_bank"]').val('');
    $('input[name="no_rekening"]').val('');
    $('input[name="email"]').val('');
    $('input[name="website"]').val('');
    $(selectKota).val('0').trigger('change');
    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tableSupplier').on('click', 'button[name="btn_edit"]', function(){
	var id = $(this).attr('id');

    $.ajax({
        type: 'GET',
        url: baseurl + 'supplier/edit/'+ id +'/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data;

                $('input[name="nama_supplier"]').val(d.nama_supplier);
                $('input[name="alamat_supplier"]').val(d.alamat_supplier);
                $('input[name="no_telepon"]').val(d.no_telepon);
                $('input[name="no_handphone"]').val(d.no_handphone);
                $('input[name="kontak_person"]').val(d.kontak_person);
                $('input[name="nama_bank"]').val(d.nama_bank);
                $('input[name="no_rekening"]').val(d.no_rekening);
                $('input[name="email"]').val(d.email);
                $('input[name="website"]').val(d.website);

                $(selectKota).find('option').each(function(){
                    if ($(this).val() == d.id_kota) {
                        $(selectKota).val($(this).val()).trigger('change');
                    }
                });

                $('button[name="btn_save"]').attr('id', id);
                $('#formTitle').text('Edit Data');

                $('#table').hide();
                setTimeout(function(){
                    $('#form').fadeIn()
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

$('#tableSupplier').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'supplier/delete/',
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

    if ($('select[name="id_kota"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih kota terlebih dahulu.'
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
        url: baseurl + 'supplier/save/',
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
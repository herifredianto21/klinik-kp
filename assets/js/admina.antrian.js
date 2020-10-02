var table = '';
var selectJenisPelayanan = '';
var selectPasien = '';
var selectDokter = '';

$('#li-antrian').addClass('active');

$(document).ready(function(){
	table = $('#tableAntrian').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'antrian/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'                : i,
                            'nama_pelayanan'    : response.data[x].nama_pelayanan,
                            'nama_pasien'       : response.data[x].nama_pasien,
                            'nama_dokter'       : response.data[x].nama_dokter,
                            'no_antrian'        : response.data[x].no_antrian,
                            'tgl_antrian'       : response.data[x].tgl_antrian,
                            'status_antrian'    : response.data[x].status_antrian,
                            'kode_antrian'      : response.data[x].kode_antrian,
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
            { 'data' : 'nama_pelayanan' },
            { 'data' : 'nama_pasien' },
            { 'data' : 'nama_dokter' },
            { 'data' : 'no_antrian' },
            { 'data' : 'tgl_antrian' },
            { 'data' : 'status_antrian' },
            { 'data' : 'kode_antrian' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 5, 'DESC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 8 ]
    		}
  		]
	});

    $.ajax({
        type: 'GET',
        url: baseurl + 'antrian/select-jenis-pelayanan/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('select[name="id_jenis_pelayanan"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_pelayanan+'</option>');
                }
            }
        }
    });
    selectJenisPelayanan = $('select[name="id_jenis_pelayanan"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'antrian/select-pasien/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('select[name="id_pasien"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].no_registrasi+' | '+response.data[x].nama_pasien+'</option>');
                }
            }
        }
    });
    selectPasien = $('select[name="id_pasien"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'antrian/select-dokter/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('select[name="id_dokter"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_dokter+'</option>');
                }
            }
        }
    });
    selectDokter = $('select[name="id_dokter"]').select2({
        'theme': 'bootstrap4'
    });
});

$('button[name="btn_add"]').click(function(){
	$('button[name="btn_save"]').attr('id', '0');
    $(selectJenisPelayanan).val('9').trigger('change');
    $(selectPasien).val('1').trigger('change');
    $(selectDokter).val('1').trigger('change');
    $('input[name="no_antrian"]').val('0');
    $.ajax({
        type: 'GET',
        url: baseurl + 'antrian/input-tgl-antrian/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('input[name="tgl_antrian"]').val(response.value);
            }
        }
    });
    $.ajax({
        type: 'GET',
        url: baseurl + 'antrian/input-kode-antrian/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('input[name="kode_antrian"]').val(response.value);
            }
        }
    });
    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tableAntrian').on('click', 'button[name="btn_edit"]', function(){
	var id = $(this).attr('id');

    $.ajax({
        type: 'GET',
        url: baseurl + 'antrian/edit/'+ id +'/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data;

                $(selectJenisPelayanan).find('option').each(function(){
                    if ($(this).val() == d.id_jenis_pelayanan) {
                        $(selectJenisPelayanan).val($(this).val()).trigger('change');
                    }
                });

                $(selectPasien).find('option').each(function(){
                    if ($(this).val() == d.id_pasien) {
                        $(selectPasien).val($(this).val()).trigger('change');
                    }
                });

                $(selectDokter).find('option').each(function(){
                    if ($(this).val() == d.id_dokter) {
                        $(selectDokter).val($(this).val()).trigger('change');
                    }
                });

                $('input[name="no_antrian"]').val(d.no_antrian);
                $('input[name="tgl_antrian"]').val(d.tgl_antrian);
                $('input[name="kode_antrian"]').val(d.kode_antrian);

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

$('#tableAntrian').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'antrian/delete/',
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

    $.ajax({
        type: 'POST',
        url: baseurl + 'antrian/save/',
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

$('select[name="id_dokter"], select[name="id_jenis_pelayanan"]').change(function(){
    $.ajax({
        type: 'POST',
        url: baseurl + 'antrian/input-no-antrian/',
        data: {
            'id_dokter': $('select[name="id_dokter"]').val(),
            'id_jenis_pelayanan': $('select[name="id_jenis_pelayanan"]').val(),
        },
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('input[name="no_antrian"]').val(response.value);
            }
        }
    });
});
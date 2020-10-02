var table = '';
var selectPasien = '';
var selectDokter = '';

$('a[href="#menuSurat"]').attr('aria-expanded', 'true');
$('#menuSurat').addClass('show');
$('#li-surat-postpartum').addClass('active');

$(document).ready(function(){
	table = $('#tablePostpartum').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'surat-postpartum/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_print" class="btn btn-success btn-sm" title="Cetak Surat"><i class="fa fa-print"></i></button> <button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'                : i,
                            'nama_pasien'       : response.data[x].nama_pasien,
                            'alamat_pasien'     : response.data[x].alamat_pasien,
                            'diagnosa'          : response.data[x].diagnosa,
                            'tanggal_kontrol'   : response.data[x].tanggal_kontrol,
                            'nama_dokter'       : response.data[x].nama_dokter,
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
            { 'data' : 'nama_pasien' },
            { 'data' : 'alamat_pasien' },
            { 'data' : 'diagnosa' },
            { 'data' : 'tanggal_kontrol' },
            { 'data' : 'nama_dokter' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 4, 'DESC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 6 ]
    		}
  		]
	});

    $.ajax({
        type: 'GET',
        url: baseurl + 'surat-postpartum/select-pasien/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_pasien"]').append('<option value="0">- Pilih Pasien -</option>');
                for(var x in response.data){
                    $('select[name="id_pasien"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_pasien+'</option>');
                }
            } else{
                $('select[name="id_pasien"]').append('<option value="0">- Pilih Pasien -</option>');
            }
        }
    });
    selectPasien = $('select[name="id_pasien"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'surat-postpartum/select-dokter/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_dokter"]').append('<option value="0">- Pilih Dokter -</option>');
                for(var x in response.data){
                    $('select[name="id_dokter"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_dokter+'</option>');
                }
            } else{
                $('select[name="id_dokter"]').append('<option value="0">- Pilih Dokter -</option>');
            }
        }
    });
    selectDokter = $('select[name="id_dokter"]').select2({
        'theme': 'bootstrap4'
    });
});

$('button[name="btn_add"]').click(function(){
    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var output = d.getFullYear() + '-' + ((''+month).length<2 ? '0' : '') + month + '-' + ((''+day).length<2 ? '0' : '') + day;

    $(selectPasien).val('0').trigger('change');
    $('input[name="alamat_pasien"]').val('');
    $('input[name="diagnosa"]').val('');
    $('input[name="tanggal_kontrol"]').val(output);
    $(selectDokter).val('0').trigger('change');
    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tablePostpartum').on('click', 'button[name="btn_edit"]', function(){
	var id = $(this).attr('id');

    $.ajax({
        type: 'GET',
        url: baseurl + 'surat-postpartum/edit/'+ id +'/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data;

                $(selectPasien).find('option').each(function(){
                    if ($(this).val() == d.id_pasien) {
                        $(selectPasien).val($(this).val()).trigger('change');
                    }
                });

                $('input[name="alamat_pasien"]').val(d.alamat_pasien);
                $('input[name="diagnosa"]').val(d.diagnosa);
                $('input[name="tanggal_kontrol"]').val(d.tanggal_kontrol);

                $(selectDokter).find('option').each(function(){
                    if ($(this).val() == d.id_dokter) {
                        $(selectDokter).val($(this).val()).trigger('change');
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

$('#tablePostpartum').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'surat-postpartum/delete/',
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

    if ($('select[name="id_pasien"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih pasien terlebih dahulu.'
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

    if ($('select[name="id_dokter"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih dokter terlebih dahulu.'
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
        url: baseurl + 'surat-postpartum/save/',
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

$('select[name="id_pasien"]').change(function(){
    var id = $(this).val();

    $.ajax({
        type: 'GET',
        url: baseurl + 'surat-postpartum/select-pasien/'+ id +'/',
        dataType: 'json',
        success: function(response){
            if(response.result && id != 0){
                for(var x in response.data){
                    $('input[name="alamat_pasien"]').val(response.data[x].alamat_istri);
                }
            }
        }
    });
});

$('#tablePostpartum').on('click', 'button[name="btn_print"]', function(){
    var id = $(this).attr('id');
    window.open(baseurl + 'surat-postpartum/cetak/' + id + '/', '_blank');
});
var table = '';
var selectPasien = '';
var selectAntrian = '';

$('#li-penjualan').addClass('active');

$(document).ready(function(){
	table = $('#tablePenjualan').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'penjualan/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_tambah" class="btn btn-success btn-sm" title="Tambah"><i class="fa fa-plus"></i></button> <button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'                : i,
                            'no_faktur'         : response.data[x].no_faktur,
                            'nama_pasien'       : response.data[x].nama_pasien,
                            'tgl_penjualan'     : response.data[x].tgl_penjualan,
                            'total_penjualan'   : response.data[x].total_penjualan,
                            'cash'              : response.data[x].cash,
                            'status_penjualan'  : response.data[x].status_penjualan,
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
            { 'data' : 'no_faktur' },
            { 'data' : 'nama_pasien' },
            { 'data' : 'tgl_penjualan' },
            { 'data' : 'total_penjualan' },
            { 'data' : 'cash' },
            { 'data' : 'status_penjualan' },
            { 'data' : 'kode_antrian' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 1, 'DESC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 8 ]
    		}
  		]
	});

    $.ajax({
        type: 'GET',
        url: baseurl + 'penjualan/select-pasien/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('select[name="id_pasien"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_pasien+'</option>');
                }
            }
        }
    });
    selectPasien = $('select[name="id_pasien"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'penjualan/select-kode-antrian/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_antrian"]').append('<option value="0">- Pilih Antrian -</option>');
                for(var x in response.data){
                    $('select[name="id_antrian"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].kode_antrian+'</option>');
                }
            } else{
                $('select[name="id_antrian"]').append('<option value="0">- Pilih Antrian -</option>');
            }
        }
    });
    selectAntrian = $('select[name="id_antrian"]').select2({
        'theme': 'bootstrap4'
    });
});

$('button[name="btn_add"]').click(function(){
	$('button[name="btn_save"]').attr('id', '0');
    $.ajax({
        type: 'GET',
        url: baseurl + 'penjualan/input-no-faktur/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('input[name="no_faktur"]').val(response.value);
            }
        }
    });
    $(selectPasien).val('1').trigger('change');

    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' + ((''+month).length<2 ? '0' : '') + month + '-' + ((''+day).length<2 ? '0' : '') + day;
    $('input[name="tgl_penjualan"]').val(output);
    $(selectAntrian).val('0').trigger('change');

    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tablePenjualan').on('click', 'button[name="btn_edit"]', function(){
	var id = $(this).attr('id');

    $.ajax({
        type: 'GET',
        url: baseurl + 'penjualan/edit/'+ id +'/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data;

                $(selectPasien).find('option').each(function(){
                    if ($(this).val() == d.id_pasien) {
                        $(selectPasien).val($(this).val()).trigger('change');
                    }
                });

                $('input[name="no_faktur"]').val(d.no_faktur);
                $('input[name="tgl_penjualan"]').val(d.tgl_penjualan);

                $(selectAntrian).find('option').each(function(){
                    if ($(this).val() == d.id_antrian) {
                        $(selectAntrian).val($(this).val()).trigger('change');
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

$('#tablePenjualan').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'penjualan/delete/',
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
        url: baseurl + 'penjualan/save/',
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

$('#tablePenjualan').on('click', 'button[name="btn_tambah"]', function(){
    var id = $(this).attr('id');
    window.location.replace(baseurl + 'penjualan-detail/index/' + id + '/');
});

$('select[name="id_antrian"]').change(function(){
    var id = $(this).val();
    
    $.ajax({
        type: 'GET',
        url: baseurl + 'penjualan/select-kode-antrian/' + id + '/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                if (id != 0) {
                    var d = response.data;
                    for(var x in d){
                        $(selectPasien).val(d[x].id_pasien).trigger('change');
                    }
                }
            }
        }
    });
});
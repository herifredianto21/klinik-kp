var table = '';
var selectAsuransi = '';

$('a[href="#menuMaster"]').attr('aria-expanded', 'true');
$('#menuMaster').addClass('show');
$('#li-kelas-asuransi').addClass('active');

$(document).ready(function(){
	table = $('#tableKelasAsuransi').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'kelas-asuransi/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'			: i,
	            			'nama_kelas'	: response.data[x].nama_kelas,
	            			'limit_biaya'	: response.data[x].limit_biaya,
                            'nama_asuransi' : response.data[x].nama_asuransi,
	            			'aksi'			: button
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
            { 'data' : 'nama_kelas' },
            { 'data' : 'limit_biaya' },
        	{ 'data' : 'nama_asuransi' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 1, 'ASC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 4 ]
    		}
  		]
	});

    $.ajax({
        type: 'GET',
        url: baseurl + 'kelas-asuransi/select-asuransi/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_asuransi"]').append('<option value="0">- Pilih Asuransi -</option>');
                for(var x in response.data){
                    $('select[name="id_asuransi"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_asuransi+'</option>');
                }
            } else{
                $('select[name="id_asuransi"]').append('<option value="0">- Pilih Asuransi -</option>');
            }
        }
    });
    selectAsuransi = $('select[name="id_asuransi"]').select2({
        'theme': 'bootstrap4'
    });
});

$('button[name="btn_add"]').click(function(){
	$('button[name="btn_save"]').attr('id', '0');
	$('input[name="nama_kelas"]').val('');
	$('input[name="limit_biaya"]').val(0);
    $(selectAsuransi).val('0').trigger('change');
    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tableKelasAsuransi').on('click', 'button[name="btn_edit"]', function(){
	var id = $(this).attr('id');
	var nama = '';
	var limit = '';
    var asuransi = '';
	$('#tableKelasAsuransi tbody tr').each(function(){
		var selected = $(this).find(':button').attr('id');
		if (selected == id) {
			nama = $(this).find('td:eq(1)').text();
			limit = $(this).find('td:eq(2)').text();
            asuransi = $(this).find('td:eq(3)').text();
		}
	});

	$('button[name="btn_save"]').attr('id', id);
	$('input[name="nama_kelas"]').val(nama);
    $('input[name="limit_biaya"]').val(limit);
    $(selectAsuransi).find('option').each(function(){
        if ($(this).text() == asuransi) {
            $(selectAsuransi).val($(this).val()).trigger('change');
        }
    });
    $('#formTitle').text('Edit Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tableKelasAsuransi').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'kelas-asuransi/delete/',
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
	$('input[name="nama_kelas"]').val('');
    $('input[name="limit_biaya"]').val(0);
    $(selectAsuransi).val('0').trigger('change');

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

    if ($('select[name="id_asuransi"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih asuransi terlebih dahulu.'
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
        url: baseurl + 'kelas-asuransi/save/',
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
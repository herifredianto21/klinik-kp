var table = '';
var selectDokter = '';
var selectHari = '';

$('a[href="#menuMaster"]').attr('aria-expanded', 'true');
$('#menuMaster').addClass('show');
$('#li-hari-praktek').addClass('active');

$(document).ready(function(){
	table = $('#tableHariPraktek').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'hari-praktek/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'                    : i,
                            'nama_dokter'           : response.data[x].nama_dokter,
                            'hari_praktek'          : response.data[x].hari_praktek,
                            'jam_praktek_mulai'     : response.data[x].jam_praktek_mulai,
                            'jam_praktek_selesai'   : response.data[x].jam_praktek_selesai,
	            			'aksi'		            : button
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
            { 'data' : 'nama_dokter' },
            { 'data' : 'hari_praktek' },
            { 'data' : 'jam_praktek_mulai' },
            { 'data' : 'jam_praktek_selesai' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 1, 'ASC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 5 ]
    		}
  		]
	});

    $.ajax({
        type: 'GET',
        url: baseurl + 'hari-praktek/select-dokter/',
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
    $('select[name="hari_praktek"]').append('<option value="0">- Pilih Hari -</option>');
    selectHari = $('select[name="hari_praktek"]').select2({
        'theme': 'bootstrap4'
    });
});

$('button[name="btn_add"]').click(function(){
	$('button[name="btn_save"]').attr('id', '0');
    $('input[name="jam_praktek_mulai"]').val('');
    $('input[name="jam_praktek_selesai"]').val('');
    $(selectDokter).val('0').trigger('change');
    $(selectHari).val('0').trigger('change');
    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tableHariPraktek').on('click', 'button[name="btn_edit"]', function(){
	var id = $(this).attr('id');
	var dokter = '';
    var hari = '';
    var mulai = '';
    var selesai = '';
	$('#tableHariPraktek tbody tr').each(function(){
		var selected = $(this).find(':button').attr('id');
		if (selected == id) {
			dokter = $(this).find('td:eq(1)').text();
            hari = $(this).find('td:eq(2)').text();
            mulai = $(this).find('td:eq(3)').text();
            selesai = $(this).find('td:eq(4)').text();
		}
	});

	$('button[name="btn_save"]').attr('id', id);
	$('input[name="jam_praktek_mulai"]').val(mulai);
    $('input[name="jam_praktek_selesai"]').val(selesai);
    $(selectDokter).find('option').each(function(){
        if ($(this).text() == dokter) {
            $(selectDokter).val($(this).val()).trigger('change');
        }
    });
    $(selectHari).find('option').each(function(){
        if ($(this).text() == hari) {
            $(selectHari).val($(this).val()).trigger('change');
        }
    });
    $('#formTitle').text('Edit Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tableHariPraktek').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'hari-praktek/delete/',
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
	$('input[name="jam_praktek_mulai"]').val('');
    $('input[name="jam_praktek_selesai"]').val('');
    $(selectDokter).val('0').trigger('change');
    $(selectHari).val('0').trigger('change');

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

    if ($('select[name="hari_praktek"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih hari terlebih dahulu.'
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
        url: baseurl + 'hari-praktek/save/',
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
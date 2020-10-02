var table = '';

$('a[href="#menuMaster"]').attr('aria-expanded', 'true');
$('#menuMaster').addClass('show');
$('#li-penyakit').addClass('active');

$(document).ready(function(){
	table = $('#tablePenyakit').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'penyakit/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
                            'no'			: i,
                            'kode_penyakit'	: response.data[x].kode_penyakit,
	            			'nama_penyakit'	: response.data[x].nama_penyakit,
	            			'ket_penyakit'	: response.data[x].ket_penyakit,
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
            { 'data' : 'kode_penyakit' },
        	{ 'data' : 'nama_penyakit' },
        	{ 'data' : 'ket_penyakit' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 2, 'ASC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 4 ]
    		}
  		]
	});
});

$('button[name="btn_add"]').click(function(){
	$('button[name="btn_save"]').attr('id', '0');
    $('input[name="kode_penyakit"]').val('');
    $('input[name="nama_penyakit"]').val('');
	$('input[name="ket_penyakit"]').val('');
    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tablePenyakit').on('click', 'button[name="btn_edit"]', function(){
	var id = $(this).attr('id');
    var kode = '';
    var nama = '';
	var ket = '';
	$('#tablePenyakit tbody tr').each(function(){
		var selected = $(this).find(':button').attr('id');
		if (selected == id) {
            kode = $(this).find('td:eq(1)').text();
			nama = $(this).find('td:eq(2)').text();
			ket = $(this).find('td:eq(3)').text();
		}
	});

	$('button[name="btn_save"]').attr('id', id);
    $('input[name="kode_penyakit"]').val(kode);
    $('input[name="nama_penyakit"]').val(nama);
	$('input[name="ket_penyakit"]').val(ket);
    $('#formTitle').text('Edit Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tablePenyakit').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'penyakit/delete/',
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
    $('input[name="kode_penyakit"]').val('');
    $('input[name="nama_penyakit"]').val('');
	$('input[name="ket_penyakit"]').val('');

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
        url: baseurl + 'penyakit/save/',
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
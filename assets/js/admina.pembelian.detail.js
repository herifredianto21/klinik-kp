var table = '';
var selectObat = '';
var idPembelian = 0;
var passObat = true;

$('#li-pembelian').addClass('active');

$(document).ready(function(){
	table = $('#tablePembelianDetail').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'pembelian-detail/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'                : i,
                            'nama_obat'         : response.data[x].nama_obat,
                            'qty_beli'          : response.data[x].qty_beli,
                            'harga_beli_obat'   : response.data[x].harga_beli_obat,
                            'harga_jual_obat'   : response.data[x].harga_jual_obat,
                            'jumlah'            : response.data[x].qty_beli * response.data[x].harga_beli_obat,                            
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
            { 'data' : 'nama_obat' },
            { 'data' : 'qty_beli' },
            { 'data' : 'harga_beli_obat' },
            { 'data' : 'harga_jual_obat' },
            { 'data' : 'jumlah' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 1, 'ASC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 6 ]
    		}
  		]
	});

    $.ajax({
        type: 'GET',
        url: baseurl + 'pembelian-detail/select-obat/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_obat"]').append('<option value="0">- Pilih Obat -</option>');
                for(var x in response.data){
                    $('select[name="id_obat"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_obat+'</option>');
                }
            } else{
                $('select[name="id_obat"]').append('<option value="0">- Pilih Obat -</option>');
            }
        }
    });
    selectObat = $('select[name="id_obat"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'pembelian-detail/get-id-pembelian/',
        dataType: 'json',
        success: function(response){
            idPembelian = response;

            if (idPembelian == 0) {
                $('button[name="btn_add"]').hide();                
            } else{
                $('button[name="btn_add"]').show();
            }
        }
    });
});

$('button[name="btn_add"]').click(function(){
	$('button[name="btn_save"]').attr('id', '0');
    $('input[name="id_pembelian"]').val(idPembelian);
    $(selectObat).val('0').trigger('change');
    $('input[name="qty_beli"]').val('1');
    $('input[name="harga_beli_obat"]').val('0');
    $('input[name="harga_jual_obat"]').val('0');
    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tablePembelianDetail').on('click', 'button[name="btn_edit"]', function(){
	var id = $(this).attr('id');

    $.ajax({
        type: 'GET',
        url: baseurl + 'pembelian-detail/edit/'+ id +'/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data;

                $('input[name="id_pembelian"]').val(d.id_pembelian);

                $(selectObat).find('option').each(function(){
                    if ($(this).val() == d.id_obat) {
                        passObat = false;
                        $(selectObat).val($(this).val()).trigger('change');
                    }
                });

                $('input[name="qty_beli"]').val(d.qty_beli);
                $('input[name="harga_beli_obat"]').val(d.harga_beli_obat);
                $('input[name="harga_jual_obat"]').val(d.harga_jual_obat);

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

$('#tablePembelianDetail').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'pembelian-detail/delete/',
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
                window.location.reload();
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

    if ($('select[name="id_obat"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih obat terlebih dahulu.'
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

    if ($('select[name="id_pembelian"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih dari faktur pembelian.'
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
        url: baseurl + 'pembelian-detail/save/',
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

                window.location.reload();
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

$('select[name="id_obat"]').change(function(string){
    if (passObat) {
        $.ajax({
            type: 'POST',
            url: baseurl + 'pembelian-detail/input-detail-obat/',
            data: {
                'id_obat': $(this).val()
            },
            dataType: 'json',
            success: function(response){
                if(response.result){
                    var d = response.data;
                    $('input[name="nama_obat"]').val(d.nama_obat);
                    $('input[name="harga_beli_obat"]').val(parseInt(d.harga_pokok_obat));
                    $('input[name="harga_jual_obat"]').val(parseInt(d.harga_jual_obat));
                }
            }
        });
    }

    passObat = true;
});

$('button[name="btn_back"]').on('click', function(){
    window.location.href = baseurl + 'pembelian/';
});
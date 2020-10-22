var table = '';
var selectSupplier = '';
var selectJenisPembelian = '';

$('#li-pembelian').addClass('active');

$(document).ready(function(){
	table = $('#tablePembelian').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'pembelian/datatable/',
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
                            'nama_supplier'     : response.data[x].nama_supplier,
                            'jenis_pembelian'   : response.data[x].jenis_pembelian,
                            'tgl_beli'          : response.data[x].tgl_beli,
                            'tgl_bayar'         : response.data[x].tgl_bayar,
                            'diskon_pembelian'  : response.data[x].diskon_pembelian,
                            'total_harga_beli'  : response.data[x].total_harga_beli,
                            'status_pembelian'  : response.data[x].status_pembelian,
                            'name'              : response.data[x].name,
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
            { 'data' : 'nama_supplier' },
            { 'data' : 'jenis_pembelian' },
            { 'data' : 'tgl_beli' },
            { 'data' : 'tgl_bayar' },
            { 'data' : 'diskon_pembelian' },
            { 'data' : 'total_harga_beli' },
            { 'data' : 'status_pembelian' },
            { 'data' : 'name' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 4, 'DESC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 10 ]
    		}
  		]
	});

    $.ajax({
        type: 'GET',
        url: baseurl + 'pembelian/select-supplier/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('select[name="id_supplier"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_supplier+'</option>');
                }
            }
        }
    });
    selectSupplier = $('select[name="id_supplier"]').select2({
        'theme': 'bootstrap4'
    });

    selectJenisPembelian = $('select[name="jenis_pembelian"]').select2({
        'theme': 'bootstrap4'
    });
});

$('button[name="btn_add"]').click(function(){
	$('button[name="btn_save"]').attr('id', '0');
    $('input[name="no_faktur"]').val('');
    $(selectSupplier).val('2').trigger('change');
    $(selectJenisPembelian).val('Tunai').trigger('change');

    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var output = d.getFullYear() + '-' + ((''+month).length<2 ? '0' : '') + month + '-' + ((''+day).length<2 ? '0' : '') + day;
    $('input[name="tgl_beli"]').val(output);
    $('input[name="tgl_bayar"]').val('');

    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tablePembelian').on('click', 'button[name="btn_edit"]', function(){
	var id = $(this).attr('id');

    $.ajax({
        type: 'GET',
        url: baseurl + 'pembelian/edit/'+ id +'/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data;

                $('input[name="no_faktur"]').val(d.no_faktur);

                $(selectSupplier).find('option').each(function(){
                    if ($(this).val() == d.id_supplier) {
                        $(selectSupplier).val($(this).val()).trigger('change');
                    }
                });

                $(selectJenisPembelian).find('option').each(function(){
                    if ($(this).val() == d.jenis_pembelian) {
                        $(selectJenisPembelian).val($(this).val()).trigger('change');
                    }
                });

                $('input[name="tgl_beli"]').val(d.tgl_beli);
                $('input[name="tgl_bayar"]').val(d.tgl_bayar);

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

$('#tablePembelian').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'pembelian/delete/',
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
        url: baseurl + 'pembelian/save/',
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

$('#tablePembelian').on('click', 'button[name="btn_tambah"]', function(){
    var id = $(this).attr('id');
    window.location.replace(baseurl + 'pembelian-detail/index/' + id + '/');
});

$('select[name="jenis_pembelian"]').change(function(){
    var id = $(this).val();
    
    if (id == 'Tunai') {
        $('input[name="status_pembelian"]').val('Close');
        // $('input[name="tgl_bayar"]').val('');
        $('input[name="tgl_bayar"]').prop('readonly', false);
    } else if (id == 'Hutang') {
        $('input[name="status_pembelian"]').val('Open');
        $('input[name="tgl_bayar"]').prop('readonly', true);
    }
});
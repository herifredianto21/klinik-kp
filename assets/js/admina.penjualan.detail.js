var table = '';
var selectFaktur = '';
var selectObat = '';
var idPenjualan = 0;
var passObat = true;

$('#li-penjualan').addClass('active');

$(document).ready(function(){
	table = $('#tablePenjualanDetail').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'penjualan-detail/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'                    : i,
                            'no_faktur'             : response.data[x].no_faktur,
                            'nama_obat'             : response.data[x].nama_obat,
                            'nama_obat_jual'        : response.data[x].nama_obat_jual,
                            'harga_beli_penjualan'  : response.data[x].harga_beli_penjualan,
                            'qty_jual'              : response.data[x].qty_jual,
                            'harga_jual_penjualan'  : response.data[x].harga_jual_penjualan,                            
	            			'aksi'	                : button
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
            { 'data' : 'nama_obat' },
            { 'data' : 'nama_obat_jual' },
            { 'data' : 'harga_beli_penjualan' },
            { 'data' : 'qty_jual' },
            { 'data' : 'harga_jual_penjualan' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 1, 'DESC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 7 ]
    		}
  		]
	});

    $.ajax({
        type: 'GET',
        url: baseurl + 'penjualan-detail/select-no-faktur/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_penjualan"]').append('<option value="0">- Pilih Faktur -</option>');
                for(var x in response.data){
                    $('select[name="id_penjualan"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].no_faktur+'</option>');
                }
            } else{
                $('select[name="id_penjualan"]').append('<option value="0">- Pilih Faktur -</option>');
            }
        }
    });
    selectFaktur = $('select[name="id_penjualan"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'penjualan-detail/select-obat/',
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
        url: baseurl + 'penjualan-detail/get-id-penjualan/',
        dataType: 'json',
        success: function(response){
            idPenjualan = response;
        }
    });
});

$('button[name="btn_add"]').click(function(){
	$('button[name="btn_save"]').attr('id', '0');
    $(selectFaktur).val(idPenjualan).trigger('change');
    $(selectObat).val('0').trigger('change');
    $('input[name="nama_obat_jual"]').val('');
    $('input[name="harga_beli_penjualan"]').val('0');
    $('input[name="qty_jual"]').val('0');
    $('input[name="harga_jual_penjualan"]').val('0');
    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tablePenjualanDetail').on('click', 'button[name="btn_edit"]', function(){
	var id = $(this).attr('id');

    $.ajax({
        type: 'GET',
        url: baseurl + 'penjualan-detail/edit/'+ id +'/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data;

                $(selectFaktur).find('option').each(function(){
                    if ($(this).val() == d.id_penjualan) {
                        $(selectFaktur).val($(this).val()).trigger('change');
                    }
                });

                $(selectObat).find('option').each(function(){
                    if ($(this).val() == d.id_obat) {
                        passObat = false;
                        $(selectObat).val($(this).val()).trigger('change');
                    }
                });

                $('input[name="nama_obat_jual"]').val(d.nama_obat_jual);
                $('input[name="harga_beli_penjualan"]').val(d.harga_beli_penjualan);
                $('input[name="qty_jual"]').val(d.qty_jual);
                $('input[name="harga_jual_penjualan"]').val(d.harga_jual_penjualan);

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

$('#tablePenjualanDetail').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'penjualan-detail/delete/',
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

    if ($('select[name="id_penjualan"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih faktur terlebih dahulu.'
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

    if ($('select[name="id_obat"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih faktur terlebih dahulu.'
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
        url: baseurl + 'penjualan-detail/save/',
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
            url: baseurl + 'penjualan-detail/input-detail-obat/',
            data: {
                'id_obat': $(this).val()
            },
            dataType: 'json',
            success: function(response){
                if(response.result){
                    var d = response.data;
                    $('input[name="nama_obat_jual"]').val(d.nama_obat);
                    $('input[name="harga_beli_penjualan"]').val(parseInt(d.harga_pokok_obat));
                    $('input[name="qty_jual"]').val('1');
                    $('input[name="harga_jual_penjualan"]').val(parseInt(d.harga_jual_obat));
                }
            }
        });
    }

    passObat = true;
});
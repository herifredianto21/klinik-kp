var table = '';
var tablePenjualan = '';
var selectMedis = '';
var selectObat = '';
var totalBayar = 0;

$('#li-apotek').addClass('active');

$(document).ready(function(){
	table = $('#tableApotek').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'apotek/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_bayar" class="btn btn-success btn-sm" title="Bayar"><i class="fas fa-shopping-basket"></i> Bayar</button>';

                        if (response.data[x].status_antrian != 'Selesai') {
                            button = '';
						}
						
						if (response.data[x].status_antrian == 'Bayar') {
							var button = '<button id="'+ response.data[x].id +'" name="btn_cetak" class="btn btn-primary btn-sm" title="Cetak"><i class="fas fa-print"></i> Cetak</button> <div class="btn-group dropup"> <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cetak Detail</button> <div class="dropdown-menu"><a class="dropdown-item" href="'+ baseurl +'apotek/cetak_detail_pemeriksaan/'+ response.data[x].id +'" target="_blank">Detail Pemeriksaan</a><a class="dropdown-item" href="'+ baseurl +'apotek/cetak_detail/'+ response.data[x].id +'" target="_blank">Detail Obat</a></div></div>';
                        }

	            		row.push({
	            			'no'                : i,
                            'waktu'             : response.data[x].tanggal + ' ' + response.data[x].jam,
	            			'nama_pasien'       : response.data[x].nama_pasien + '<input type="hidden" id="nama_pasien_' + response.data[x].id + '" value="' + response.data[x].nama_pasien + '" />',
	            			'nama_pelayanan'    : response.data[x].nama_pelayanan + '<input type="hidden" id="nama_pelayanan_' + response.data[x].id + '" value="' + response.data[x].nama_pelayanan + '" />',
                            'status_antrian'    : response.data[x].status_antrian,
	            			'aksi'              : button
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
            { 'data' : 'waktu' },
            { 'data' : 'nama_pasien' },
        	{ 'data' : 'nama_pelayanan' },
            { 'data' : 'status_antrian' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 1, 'DESC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 5 ]
    		}
  		]
	});

	tablePenjualan = $('#tablePenjualan').DataTable({
		'processing'	: true,
		'serverSide'	: true,
		'searching'		: false,
		'lengthChange'	: false,

        'ajax' : {
        	'url'	: baseurl + 'apotek/datatable-penjualan/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_cetak" class="btn btn-primary btn-sm" title="Cetak"><i class="fas fa-print"></i> Cetak</button>';

	            		row.push({
	            			'no'		: i,
                            'waktu'		: response.data[x].tanggal + ' ' + response.data[x].jam,
	            			'list_obat'	: response.data[x].list_obat,
	            			'aksi'		: button
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
            { 'data' : 'waktu' },
            { 'data' : 'list_obat' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 1, 'DESC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 3 ]
    		}
  		]
	});

	$.ajax({
        type: 'GET',
        url: baseurl + 'biaya-medis/select/',
        dataType: 'json',
        success: function(response){
            if(response.result){
				$('select[name="biaya_pelayanan[]"]').append('<option value="0">- Pilih Biaya Medis -</option>');
                for(var x in response.data){
                    $('select[name="biaya_pelayanan[]"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_biaya_medis+'</option>');
                }
            }
        }
    });
    selectMedis = $('select[name="biaya_pelayanan[]"]').select2({
        'theme': 'bootstrap4'
	});
	
	$.ajax({
        type: 'GET',
        url: baseurl + 'obat/select/',
        dataType: 'json',
        success: function(response){
            if(response.result){
				$('select[name="biaya_obat[]"]').append('<option value="0">- Pilih Obat -</option>');
                for(var x in response.data){
                    $('select[name="biaya_obat[]"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_obat+'</option>');
                }
            }
        }
    });
    selectObat = $('select[name="biaya_obat[]"]').select2({
        'theme': 'bootstrap4'
	});

	$('select[name="jenis_diskon"]').select2({
		'theme': 'bootstrap4'
	});
});

$('.tablePelayanan tbody').on('click', '.btn-success', function(){
	var template = $('#biayaPelayanan').html();
	$('.tablePelayanan > tbody').append(template);
	$('select[name="biaya_pelayanan[]"]').select2({
		'theme': 'bootstrap4'
	});
});

$('.tableObat tbody').on('click', '.btn-success', function(){
	var template = $('#biayaObat').html();
	$('.tableObat > tbody').append(template);
	$('select[name="biaya_obat[]"]').select2({
		'theme': 'bootstrap4'
	});
});

function get_index(elm)
{
	return $(elm).closest("tr").index();
}

$('.tablePelayanan tbody, .tableObat tbody').on('click', '.btn-danger', function(){
	var idx = get_index(this);
        
	if (idx != 0) {
		var tr = $(this).closest("tr");
		$(tr).fadeOut(500, function(){
			$(this).remove();
		});
	}
});

$('#tableApotek tbody').on('click', 'button[name="btn_bayar"]', function(){
	$('.card-header').fadeOut();
	$('.card-body').fadeOut();
	$('#formData').fadeIn();

	var id = $(this).attr('id');
	$('button[name="btn_save"]').attr('id', id);

	// Menampilkan Nama Pasien dan Jenis Pelayanan di halaman Rincian Pembayaran dari pasien yang dipilih
	var nama_pasien = $('input[id="nama_pasien_' + id + '"]').val();
	$('div#nama_pasien').html(nama_pasien);
	
	var nama_pelayanan = $('input[id="nama_pelayanan_' + id + '"]').val();
	$('div#nama_pelayanan').html(nama_pelayanan);
});

$('button[name="btn_back"]').on('click', function(){
	$('button[name="btn_save"]').attr('id', 0);
	$('div#nama_pasien').html('');
	$('div#nama_pelayanan').html('');
	$('input[type="number"]').val('');
	$('input[name="total"]').val('');
	$('input[name="kembali"]').val('');
	$('.tablePelayanan .btn-danger').trigger('click');
	$('.tableObat .btn-danger').trigger('click');
	$(selectMedis).val('0').trigger('change');
	$(selectObat).val('0').trigger('change');
	$('select[name="jenis_diskon"]').val('0').trigger('change');

	$('#formData').fadeOut();
	$('.card-header').fadeIn();
	$('.card-body').fadeIn();
});

$('.tablePelayanan tbody').on('change', 'select', function(){
	var value = $(this).val();
	var idx = get_index(this);
	
	if (value != 0) {
		$.ajax({
			type: 'GET',
			url: baseurl + 'biaya-medis/select/'+value,
			dataType: 'json',
			success: function(response){
				if(response.result){
					var data = response.data;
					$('.tablePelayanan tbody tr:eq('+ idx +') input[type="number"]').val(data[0].biaya_medis);
					sumTotal();
				}
			}
		});
	} else{
		$('.tablePelayanan tbody tr:eq('+ idx +') input[type="number"]').val('');
		sumTotal();
	}
});

$('.tableObat tbody').on('change', 'select', function(){
	var value = $(this).val();
	var idx = get_index(this);
	
	if (value != 0) {
		$.ajax({
			type: 'GET',
			url: baseurl + 'obat/select/'+value,
			dataType: 'json',
			success: function(response){
				if(response.result){
					var data = response.data;
					var qty = $('.tableObat tbody tr:eq('+ idx +') input[name="qty_obat[]"]').val() ? $('.tableObat tbody tr:eq('+ idx +') input[name="qty_obat[]"]').val() : 0;
					$('.tableObat tbody tr:eq('+ idx +') input[name="biaya_obat_nominal[]"]').val(data[0].harga_jual_obat * qty);
					sumTotal();
				}
			}
		});
	} else{
		$('.tableObat tbody tr:eq('+ idx +') input[type="number"]').val('');
		sumTotal();
	}
});

$('.tableObat tbody').on('keyup', 'input[name="qty_obat[]"]', function(){
	var value = $(this).val() ? $(this).val() : 0;
	var idx = get_index(this);

	var idObat = $('.tableObat tbody tr:eq('+ idx +') select[name="biaya_obat[]"]').val();
	console.log(idObat);
	if (idObat != 0) {
		$('.tableObat tbody tr:eq('+ idx +') select[name="biaya_obat[]"]').val(idObat).trigger('change');
	}
});

$('input[name="biaya_diskon"]').on('keyup', function(){
	sumTotal();
});

$('select[name="jenis_diskon"]').on('change', function(){
	var id = $(this).val();

	if (id == 1) {
		$('input[name="biaya_diskon"]').val('600000');
		sumTotal();
	} else{
		$('input[name="biaya_diskon"]').val('0');
		sumTotal();
	}
});

function sumTotal()
{
	var total = 0;
	$('input[name="biaya_pelayanan_nominal[]"]').each(function(){
		var biaya = parseInt($(this).val()) ? parseInt($(this).val()) : 0;
		total = total + biaya;
	});
	$('input[name="biaya_obat_nominal[]"]').each(function(index){
		var biaya = parseInt($(this).val()) ? parseInt($(this).val()) : 0;
		total = total + biaya;
	});
	var diskon = parseInt($('input[name="biaya_diskon"]').val()) ? parseInt($('input[name="biaya_diskon"]').val()) : 0;
	total = total - diskon;
	total = total + 3000; // biaya admin
	totalBayar = total;

	$('input[name="total"]').val('Rp. ' + totalBayar);
}

$('input[name="bayar"]').on('keyup', function(){
	var bayar = parseInt($(this).val()) ? parseInt($(this).val()) : 0;
	var kembali = bayar - totalBayar;
	$('input[name="kembali"]').val(kembali);
});

$('button[name="btn_save"]').on('click', function(){
	$(this).attr('disabled', 'disabled');
	var id = $(this).attr('id');
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
	
	// $('#formData').find('select[name="biaya_obat[]"]').each(function(){
    //     if($(this).val() == 0){
    //         $.notify({
    //             icon: 'now-ui-icons ui-1_bell-53',
    //             message: 'Silakan pilih obat terlebih dahulu.'
    //         }, {
    //             type: 'warning',
    //             delay: 1000,
    //             timer: 500,
    //             placement: {
    //                 from: 'top',
    //                 align: 'center'
    //             }
    //         });
    //         $(this).focus();
    //         missing = true;
    //         return false;
    //     }
    // });

    $(this).removeAttr('disabled');
    if(missing){
        return;
	}
	
	$.ajax({
        type: 'POST',
        url: baseurl + 'apotek/save/',
        data: {
        	'id': id,
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
				window.open(baseurl+'apotek/cetak/'+id);
                table.ajax.reload(null, false);
                $('button[name="btn_save"]').attr('id', 0);
				$('input[type="number"]').val('');
				$('.tablePelayanan .btn-danger').trigger('click');
				$('.tableObat .btn-danger').trigger('click');

				$('#formData').fadeOut();
				$('.card-header').fadeIn();
				$('.card-body').fadeIn();
				setTimeout(location.reload.bind(location), 1000);
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

$('button[name="btn_langsung"]').on('click', function(){
	window.location.href = baseurl + 'apotek/penjualan/';
});

$('#tableApotek tbody').on('click', 'button[name="btn_cetak"]', function(){
	var id = $(this).attr('id');
	window.open(baseurl+'apotek/cetak/'+id);
});

$('#tableApotek tbody').on('click', 'button[name="btn_cetak_detail"]', function(){
	var id = $(this).attr('id');
	window.open(baseurl+'apotek/cetak_detail/'+id);
});

$('#tablePenjualan tbody').on('click', 'button[name="btn_cetak"]', function(){
	var id = $(this).attr('id');
	window.open(baseurl+'apotek/cetak_langsung/'+id);
});

$('button[name="btn_laporan"]').on('click', function(){
	window.location.href = baseurl+'apotek/laporan/';
});
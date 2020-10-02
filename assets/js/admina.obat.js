var table = '';
var selectSatuan = '';
var selectKategori = '';

$('a[href="#menuMaster"]').attr('aria-expanded', 'true');
$('#menuMaster').addClass('show');
$('#li-obat').addClass('active');
$('#menuMaster #li-obat').addClass('active');

$(document).ready(function(){
	table = $('#tableObat').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'obat/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'                : i,
                            'kode_obat'         : response.data[x].kode_obat,
                            'nama_obat'         : response.data[x].nama_obat,
                            'harga_pokok_obat'  : response.data[x].harga_pokok_obat,
                            'harga_jual_obat'   : response.data[x].harga_jual_obat,
                            'stok'              : response.data[x].stok,
                            'stok_minimal'      : response.data[x].stok_minimal,
                            'nama_satuan'       : response.data[x].nama_satuan,
                            'nama_kategori'     : response.data[x].nama_kategori,
	            			'aksi'		        : button
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
            { 'data' : 'kode_obat' },
            { 'data' : 'nama_obat' },
            { 'data' : 'harga_pokok_obat' },
            { 'data' : 'harga_jual_obat' },
            { 'data' : 'stok' },
            { 'data' : 'stok_minimal' },
            { 'data' : 'nama_satuan' },
            { 'data' : 'nama_kategori' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 1, 'ASC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 9 ]
    		}
  		]
	});

    $.ajax({
        type: 'GET',
        url: baseurl + 'obat/select-satuan/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_satuan"]').append('<option value="0">- Pilih Satuan -</option>');
                for(var x in response.data){
                    $('select[name="id_satuan"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_satuan+'</option>');
                }
            } else{
                $('select[name="id_satuan"]').append('<option value="0">- Pilih Satuan -</option>');
            }
        }
    });
    selectSatuan = $('select[name="id_satuan"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'obat/select-kategori/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_kategori"]').append('<option value="0">- Pilih Kategori -</option>');
                for(var x in response.data){
                    $('select[name="id_kategori"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_kategori+'</option>');
                }
            } else{
                $('select[name="id_kategori"]').append('<option value="0">- Pilih Kategori -</option>');
            }
        }
    });
    selectKategori = $('select[name="id_kategori"]').select2({
        'theme': 'bootstrap4'
    });
});

$('button[name="btn_add"]').click(function(){
	$('button[name="btn_save"]').attr('id', '0');
    $('input[name="kode_obat"]').val('');
    $('input[name="nama_obat"]').val('');
    $('input[name="harga_pokok_obat"]').val('0');
    $('input[name="harga_jual_obat"]').val('0');
    $('input[name="stok_minimal"]').val('0');
    $(selectSatuan).val('0').trigger('change');
    $(selectKategori).val('0').trigger('change');
    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tableObat').on('click', 'button[name="btn_edit"]', function(){
	var id = $(this).attr('id');
	var kode = '';
    var nama = '';
    var jual = '';
    var pokok = '';
    var stok = '';
    var satuan = '';
    var kategori = '';
	$('#tableObat tbody tr').each(function(){
		var selected = $(this).find(':button').attr('id');
		if (selected == id) {
			kode = $(this).find('td:eq(1)').text();
            nama = $(this).find('td:eq(2)').text();
            jual = $(this).find('td:eq(3)').text();
            pokok = $(this).find('td:eq(4)').text();
            stok = $(this).find('td:eq(5)').text();
            satuan = $(this).find('td:eq(6)').text();
            kategori = $(this).find('td:eq(7)').text();
		}
	});

	$('button[name="btn_save"]').attr('id', id);
	$('input[name="kode_obat"]').val(kode);
    $('input[name="nama_obat"]').val(nama);
    $('input[name="harga_jual_obat"]').val(jual);
    $('input[name="harga_pokok_obat"]').val(pokok);
    $('input[name="stok_minimal"]').val(stok);
    $(selectSatuan).find('option').each(function(){
        if ($(this).text() == satuan) {
            $(selectSatuan).val($(this).val()).trigger('change');
        }
    });
    $(selectKategori).find('option').each(function(){
        if ($(this).text() == kategori) {
            $(selectKategori).val($(this).val()).trigger('change');
        }
    });
    $('#formTitle').text('Edit Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tableObat').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'obat/delete/',
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
	$('input[name="kode_obat"]').val('');
    $('input[name="nama_obat"]').val('');
    $('input[name="harga_jual_obat"]').val('0');
    $('input[name="harga_pokok_obat"]').val('0');
    $('input[name="stok_minimal"]').val('0');
    $(selectSatuan).val('0').trigger('change');
    $(selectKategori).val('0').trigger('change');

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

    if ($('select[name="id_satuan"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih satuan terlebih dahulu.'
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

    if ($('select[name="id_kategori"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih kategori terlebih dahulu.'
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
        url: baseurl + 'obat/save/',
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

$('button[name="btn_cetak"]').on('click', function(){
    window.open(baseurl+'obat/cetak/');
})
var table = '';
var selectFaktur = '';
var selectJenisDiskon = '';
var selectStatusPembayaran = '';

$('#li-pembayaran').addClass('active');

$(document).ready(function(){
	table = $('#tablePembayaran').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'pembayaran/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'                : i,
                            'no_faktur'         : response.data[x].no_faktur,
                            'jenis_diskon'      : response.data[x].jenis_diskon,
                            'total_diskon'      : response.data[x].total_diskon,
                            'status_pembayaran' : response.data[x].status_pembayaran,
                            'total_bayar'       : response.data[x].total_bayar,
                            'cash'              : response.data[x].cash,
                            'tgl_bayar'         : response.data[x].tgl_bayar,
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
            { 'data' : 'jenis_diskon' },
            { 'data' : 'total_diskon' },
            { 'data' : 'status_pembayaran' },
            { 'data' : 'total_bayar' },
            { 'data' : 'cash' },
            { 'data' : 'tgl_bayar' },
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
        url: baseurl + 'pembayaran/select-no-faktur/',
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

    selectJenisDiskon = $('select[name="jenis_diskon"]').select2({
        'theme': 'bootstrap4'
    });

    selectStatusPembayaran = $('select[name="status_pembayaran"]').select2({
        'theme': 'bootstrap4'
    });
});

$('button[name="btn_add"]').click(function(){
	$('button[name="btn_save"]').attr('id', '0');
    $(selectFaktur).val('0').trigger('change');
    $(selectJenisDiskon).val('Tidak Ada').trigger('change');
    $(selectStatusPembayaran).val('Proses').trigger('change');
    $('input[name="total_diskon"]').val('0');
    $('input[name="total_bayar"]').val('0');
    $('input[name="cash"]').val('0');
    $('input[name="uang_kembali"]').val('0');

    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' + ((''+month).length<2 ? '0' : '') + month + '-' + ((''+day).length<2 ? '0' : '') + day;
    $('input[name="tgl_bayar"]').val(output);

    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tablePembayaran').on('click', 'button[name="btn_edit"]', function(){
	var id = $(this).attr('id');

    $.ajax({
        type: 'GET',
        url: baseurl + 'pembayaran/edit/'+ id +'/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data;

                $(selectFaktur).find('option').each(function(){
                    if ($(this).val() == d.id_penjualan) {
                        $(selectFaktur).val($(this).val()).trigger('change');
                    }
                });

                $(selectJenisDiskon).find('option').each(function(){
                    if ($(this).val() == d.jenis_diskon) {
                        $(selectJenisDiskon).val($(this).val()).trigger('change');
                    }
                });

                $(selectStatusPembayaran).find('option').each(function(){
                    if ($(this).val() == d.status_pembayaran) {
                        $(selectStatusPembayaran).val($(this).val()).trigger('change');
                    }
                });

                $('input[name="total_diskon"]').val(d.total_diskon);
                $('input[name="total_bayar"]').val(d.total_bayar);
                $('input[name="cash"]').val(d.cash);
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

$('#tablePembayaran').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'pembayaran/delete/',
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

    $.ajax({
        type: 'POST',
        url: baseurl + 'pembayaran/save/',
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

function calculateAll(){
    var totalDiskon = parseInt($('input[name="total_diskon"]').val());
    var totalBayar = parseInt($('input[name="total_bayar"]').val());
    var cash = parseInt($('input[name="cash"]').val());
    var total = cash - (totalBayar - totalDiskon);

    if (total > 0) {
        $('input[name="uang_kembali"]').val(total);
    } else{
        $('input[name="uang_kembali"]').val(0);
    }
}

$('select[name="id_penjualan"]').change(function(string){
    var id = $(this).val();
    $.ajax({
        type: 'GET',
        url: baseurl + 'pembayaran/select-no-faktur/' + id + '/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data;
                if (id != 0) {
                    for(var x in d){
                        $('input[name="total_bayar"]').val(parseInt(d[x].total_penjualan));
                        calculateAll();
                    }
                }
            }
        }
    });
});

$('input[name="total_diskon"], input[name="cash"]').change(function(string){
    calculateAll();
});

$('select[name="jenis_diskon"]').change(function(string){
    var val = $(this).val();
    if (val == 'Tidak Ada') {
        $('input[name="total_diskon"]').val('0');
        $('input[name="total_diskon"]').prop('readonly', true);
    } else{
        $('input[name="total_diskon"]').prop('readonly', false);
    }
});
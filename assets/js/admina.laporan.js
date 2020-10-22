var table = '';
var selectJenisLaporan = '';
var selectTahun = '';
var selectBulan = '';

$('#li-laporan').addClass('active');

function bulanLaporan(bulan)
{
    var namaBulan = '';
    switch(bulan)
    {
        case '01':
            namaBulan = 'Januari';
            break;
        case '02':
            namaBulan = 'Februari';
            break;
        case '03':
            namaBulan = 'Maret';
            break;
        case '04':
            namaBulan = 'April';
            break;
        case '05':
            namaBulan = 'Mei';
            break;
        case '06':
            namaBulan = 'Juni';
            break;
        case '07':
            namaBulan = 'Juli';
            break;
        case '08':
            namaBulan = 'Agustus';
            break;
        case '09':
            namaBulan = 'September';
            break;
        case '10':
            namaBulan = 'Oktober';
            break;
        case '11':
            namaBulan = 'November';
            break;
        case '12':
            namaBulan = 'Desember';
            break;
        default:
            break;
    }

    return namaBulan;
}

$(document).ready(function(){
	table = $('#tableLaporan').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'laporan/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_print" class="btn btn-info btn-sm" title="Cetak Laporan"><i class="fa fa-print"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'                : i,
                            'nama_laporan'      : response.data[x].nama_laporan,
                            'tahun_laporan'     : response.data[x].tahun_laporan,
                            'bulan_laporan'     : bulanLaporan(response.data[x].bulan_laporan),
                            'catatan'           : response.data[x].catatan,
                            'created_at'        : response.data[x].created_at,
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
            { 'data' : 'nama_laporan' },
            { 'data' : 'tahun_laporan' },
            { 'data' : 'bulan_laporan' },
            { 'data' : 'catatan' },
            { 'data' : 'created_at' },
        	{ 'data' : 'aksi' }
        ],

        // 'order' 	: [[ 1, 'DESC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 3, 6 ]
    		}
  		]
	});

    $.ajax({
        type: 'GET',
        url: baseurl + 'laporan/select-jenis-laporan/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('select[name="id_jenis_laporan"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_laporan+'</option>');
                }
            }
        }
    });
    selectJenisLaporan = $('select[name="id_jenis_laporan"]').select2({
        'theme': 'bootstrap4'
    });

    var date = new Date();
    var y = date.getFullYear();

    temp = y - 5;
    for (var i = 1; i < 6; i++) {
        $('select[name="tahun_laporan"]').append('<option value="'+ (temp+i) +'">'+(temp+i)+'</option>');
    }
    for (var i = 1; i < 5; i++) {
        $('select[name="tahun_laporan"]').append('<option value="'+ (y+i) +'">'+(y+i)+'</option>');
    }

    selectTahun = $('select[name="tahun_laporan"]').select2({
        'theme': 'bootstrap4'
    });

    selectBulan = $('select[name="bulan_laporan"]').select2({
        'theme': 'bootstrap4'
    });
});

$('button[name="btn_add"]').click(function(){
    var date = new Date();
    var y = date.getFullYear();
    var m = date.getMonth()+1;
    var d = date.getDate();

    $('#tableLaporanBulanan tbody input').val('');
    $('#tableLaporanBulanan tbody tr').each(function(){
        $(this).find('td:last').text('');
    });
    $('#tableLaporanBulanan tbody tr:last td').each(function(i){
        if (i > 0) {
            $(this).text('');
        }
    });

    $(selectJenisLaporan).val('1').trigger('change');
    $(selectTahun).val(y).trigger('change');
    $(selectBulan).val(((''+m).length<2 ? '0' : '') + m).trigger('change');
    $('input[name="catatan"]').val('');

    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tableLaporan').on('click', 'button[name="btn_view"]', function(){
	var id = $(this).attr('id');
    window.location.href = baseurl + 'laporan/detail/' + id + '/';
});

$('#tableLaporan').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'laporan/delete/',
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
        url: baseurl + 'laporan/save/',
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

$('#tableLaporan').on('click', 'button[name="btn_print"]', function(){
    var id = $(this).attr('id');
    window.open(baseurl + 'laporan/cetak/' + id + '/', '_blank');
});

// $('select[name="id_jenis_laporan"]').on('change', function(){
//     var id = $(this).val();
//     if (id == 1) {
//         $('.laporan-bulanan').show();
//     } else{
//         $('.laporan-bulanan').hide();
//     }
// });

$('#tableLaporanBulanan tbody td').on('change', 'input', function(){
    var jml = Array();
    jml.length = $('#tableLaporanBulanan tbody tr:last td').length - 2;
    $('#tableLaporanBulanan tbody tr').each(function(i){
        var sum = 0;
        $(this).find('input').each(function(j){
            var val = $(this).val();
            if (!isNaN(val) && val.length !== 0) {
                sum += parseFloat(val);
                if (jml[j] === undefined) {
                    jml[j] = 0;
                }
                jml[j] += parseFloat(val)
            }
        });
        $(this).find('td:last').text(sum);
    });

    var total = 0;
    $('#tableLaporanBulanan tbody tr:last td').each(function(i){
        if (i != 0) {
            $(this).text(jml[i-1]);
            if (!isNaN(jml[i-1]) && jml[i-1].length !== 0) {
                total += parseFloat(jml[i-1]);
            }
        }
    });
    $('#tableLaporanBulanan tbody tr:last td:last').text(total);
});
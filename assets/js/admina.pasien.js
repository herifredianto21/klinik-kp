var table = '';
var tableRM = '';
var selectJenisPasien = '';
var selectPendidikanPasien = '';
var selectPendidikanSuami = '';
var selectAgamaPasien = '';
var selectAgamaSuami = '';
var selectPekerjaanPasien = '';
var selectPekerjaanSuami = '';
var selectKota = '';
var selectDesa = '';
var selectDarah = '';
var selectCatatan = '';

$('#li-pasien').addClass('active');

$(document).ready(function(){
	table = $('#tablePasien').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'pasien/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_view" class="btn btn-default btn-sm" title="Lihat Detail"><i class="fa fa-search"></i></button> <button id="'+ response.data[x].id +'" name="btn_print" class="btn btn-success btn-sm" title="Cetak Data Pasien"><i class="fa fa-print"></i></button> <button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'                : i,
                            // 'jenis_pasien'      : response.data[x].jenis_pasien,
                            'no_registrasi'     : response.data[x].no_registrasi,
                            'nama_pasien'       : response.data[x].nama_pasien,
                            // 'tgl_lahir'         : response.data[x].tgl_lahir,
                            // 'nama_suami'        : response.data[x].nama_suami,
                            // 'tgl_lahir_suami'   : response.data[x].tgl_lahir_suami,
                            // 'nama_kota_suami'   : response.data[x].nama_kota,
                            // 'hpht'              : response.data[x].hpht,
                            // 'taksiran_partus'   : response.data[x].taksiran_partus,
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
            // { 'data' : 'jenis_pasien' },
            { 'data' : 'no_registrasi' },
            { 'data' : 'nama_pasien' },
            // { 'data' : 'tgl_lahir' },
            // { 'data' : 'nama_suami' },
            // { 'data' : 'tgl_lahir_suami' },
            // { 'data' : 'nama_kota_suami' },
            // { 'data' : 'hpht' },
            // { 'data' : 'taksiran_partus' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 1, 'ASC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 3 ]
    		}
  		]
	});

    tableRM = $('#tableRM').DataTable({
        'searching' : false,
        'paging'    : false,
        'info'      : false,
        'sorting'   : false
    });

    // selectJenisPasien = $('select[name="jenis_pasien"]').select2({
    //     'theme': 'bootstrap4'
    // });

    selectPendidikanPasien = $('select[name="pendidikan_istri"]').select2({
        'theme': 'bootstrap4'
    });

    selectAgamaPasien = $('select[name="agama_istri"]').select2({
        'theme': 'bootstrap4'
    });

    selectPendidikanSuami = $('select[name="pendidikan_suami"]').select2({
        'theme': 'bootstrap4'
    });

    selectAgamaSuami = $('select[name="agama_suami"]').select2({
        'theme': 'bootstrap4'
    });

    selectDarah = $('select[name="gol_darah"]').select2({
        'theme': 'bootstrap4'
    });

    selectCatatan = $('select[name="catatan_bidan"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'pasien/select-pekerjaan/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="pekerjaan_istri"]').append('<option value="0">- Pilih Pekerjaan -</option>');
                for(var x in response.data){
                    $('select[name="pekerjaan_istri"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_pekerjaan+'</option>');
                }
            } else{
                $('select[name="pekerjaan_istri"]').append('<option value="0">- Pilih Pekerjaan -</option>');
            }
        }
    });
    selectPekerjaanPasien = $('select[name="pekerjaan_istri"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'pasien/select-pekerjaan/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="pekerjaan_suami"]').append('<option value="0">- Pilih Pekerjaan -</option>');
                for(var x in response.data){
                    $('select[name="pekerjaan_suami"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_pekerjaan+'</option>');
                }
            } else{
                $('select[name="pekerjaan_suami"]').append('<option value="0">- Pilih Pekerjaan -</option>');
            }
        }
    });
    selectPekerjaanSuami = $('select[name="pekerjaan_suami"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'pasien/select-kota/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('select[name="id_kota"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_kota+'</option>');
                }
            } else{
                $('select[name="id_kota"]').append('<option value="164">Kabupaten Bandung Barat</option>');
            }
        }
    });
    selectKota = $('select[name="id_kota"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'pasien/select-desa/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('select[name="id_desa"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_desa+'</option>');
                }
            } else{
                $('select[name="id_desa"]').append('<option value="8">Tidak Ada</option>');
            }
        }
    });
    selectDesa = $('select[name="id_desa"]').select2({
        'theme': 'bootstrap4'
    });
});

$('button[name="btn_add"]').click(function(){
    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' + ((''+month).length<2 ? '0' : '') + month + '-' + ((''+day).length<2 ? '0' : '') + day;

	$('button[name="btn_save"]').attr('id', '0');
    // $(selectJenisPasien).val('Bersalin').trigger('change');
    $.ajax({
        type: 'GET',
        url: baseurl + 'pasien/input-no-registrasi/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('input[name="no_registrasi"]').val(response.value);
            } else{
                $('input[name="no_registrasi"]').val('');
            }
        }
    });
    $('input[name="nik"]').val('');
    $('input[name="nama_pasien"]').val('');
    $('input[name="tgl_lahir"]').val(output);
    $(selectPendidikanPasien).val('Tidak Tamat').trigger('change');
    $(selectAgamaPasien).val('Islam').trigger('change');
    $(selectPekerjaanPasien).val('0').trigger('change');
    $('input[name="alamat_ktp_istri"]').val('');
    $('input[name="alamat_istri"]').val('');
    $('input[name="nama_ayah_kandung"]').val('');
    $('input[name="nama_suami"]').val('');
    $('input[name="tgl_lahir_suami"]').val(output);
    $(selectPendidikanSuami).val('Tidak Tamat').trigger('change');
    $(selectAgamaSuami).val('Islam').trigger('change');
    $(selectPekerjaanSuami).val('0').trigger('change');
    $('input[name="alamat_ktp_suami"]').val('');
    $('input[name="alamat_suami"]').val('');
    $(selectKota).val('164').trigger('change');
    $(selectDesa).val('8').trigger('change');
    $(selectDarah).val('-').trigger('change');
    $('input[name="no_telp_pasien"]').val('');
    $('input[name="email"]').val('');
    $('input[name="medsos"]').val('');
    // $('input[name="gravida"]').val('1');
    // $('input[name="para"]').val('0');
    // $('input[name="abortus"]').val('0');
    // $('input[name="hpht"]').val(output);
    // $('input[name="siklus"]').val('5');
    // $('input[name="durasi_haid"]').val('5');
    // $('input[name="taksiran_partus"]').val(output);
    $(selectCatatan).val('');
    $('#formTitle').text('Tambah Data');

	$('#table').hide();
    $('.table-detail').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('input[name="alamat_istri"]').on('change', function(){
    $('input[name="alamat_suami"]').val($(this).val());
});

$('#tablePasien').on('click', 'button[name="btn_edit"]', function(){
	var id = $(this).attr('id');

    $.ajax({
        type: 'GET',
        url: baseurl + 'pasien/edit/'+ id +'/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data;

                // $(selectJenisPasien).find('option').each(function(){
                //     if ($(this).val() == d.jenis_pasien) {
                //         $(selectJenisPasien).val($(this).val()).trigger('change');
                //     }
                // });

                $('input[name="no_registrasi"]').val(d.no_registrasi);
                $('input[name="nik"]').val(d.nik);
                $('input[name="nama_pasien"]').val(d.nama_pasien);
                $('input[name="tgl_lahir"]').val(d.tgl_lahir);

                $(selectPendidikanPasien).find('option').each(function(){
                    if ($(this).val() == d.pendidikan_istri) {
                        $(selectPendidikanPasien).val($(this).val()).trigger('change');
                    }
                });

                $(selectAgamaPasien).find('option').each(function(){
                    if ($(this).val() == d.agama_istri) {
                        $(selectAgamaPasien).val($(this).val()).trigger('change');
                    }
                });

                $(selectPekerjaanPasien).find('option').each(function(){
                    if ($(this).val() == d.pekerjaan_istri) {
                        $(selectPekerjaanPasien).val($(this).val()).trigger('change');
                    }
                });

                $('input[name="alamat_ktp_istri"]').val(d.alamat_ktp_istri);
                $('input[name="alamat_istri"]').val(d.alamat_istri);
                $('input[name="nama_ayah_kandung"]').val(d.nama_ayah_kandung);
                $('input[name="nama_suami"]').val(d.nama_suami);
                $('input[name="tgl_lahir_suami"]').val(d.tgl_lahir_suami);

                $(selectPendidikanSuami).find('option').each(function(){
                    if ($(this).val() == d.pendidikan_suami) {
                        $(selectPendidikanSuami).val($(this).val()).trigger('change');
                    }
                });

                $(selectAgamaSuami).find('option').each(function(){
                    if ($(this).val() == d.agama_suami) {
                        $(selectAgamaSuami).val($(this).val()).trigger('change');
                    }
                });

                $(selectPekerjaanSuami).find('option').each(function(){
                    if ($(this).val() == d.pekerjaan_suami) {
                        $(selectPekerjaanSuami).val($(this).val()).trigger('change');
                    }
                });

                $('input[name="alamat_ktp_suami"]').val(d.alamat_ktp_suami);
                $('input[name="alamat_suami"]').val(d.alamat_suami);

                $(selectKota).find('option').each(function(){
                    if ($(this).val() == d.id_kota) {
                        $(selectKota).val($(this).val()).trigger('change');
                    }
                });

                $(selectDesa).find('option').each(function(){
                    if ($(this).val() == d.id_desa) {
                        $(selectDesa).val($(this).val()).trigger('change');
                    }
                });

                $(selectDarah).find('option').each(function(){
                    if ($(this).val() == d.gol_darah) {
                        $(selectDarah).val($(this).val()).trigger('change');
                    }
                });

                $('input[name="no_telp_pasien"]').val(d.no_telp_pasien);
                $('input[name="email"]').val(d.email);
                $('input[name="medsos"]').val(d.medsos);
                $('input[name="gravida"]').val(d.gravida);
                $('input[name="para"]').val(d.para);
                $('input[name="abortus"]').val(d.abortus);
                $('input[name="hpht"]').val(d.hpht);
                $('input[name="siklus"]').val(d.siklus);
                $('input[name="durasi_haid"]').val(d.durasi_haid);
                $('input[name="taksiran_partus"]').val(d.taksiran_partus);
                
                var catat = new Array();
                $(selectCatatan).find('option').each(function(){
                    if (d.catatan_bidan.indexOf($(this).val()) != -1) {
                        catat.push($(this).val());
                    }
                });
                $(selectCatatan).val(catat).trigger('change');

                $('button[name="btn_save"]').attr('id', id);
                $('#formTitle').text('Edit Data');

                $('#table').hide();
                $('.table-detail').hide();
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

$('#tablePasien').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'pasien/delete/',
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
        $('.table-detail').fadeIn();
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

    if ($('select[name="pekerjaan_istri"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih pekerjaan pasien terlebih dahulu.'
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

    if ($('select[name="pekerjaan_suami"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih pekerjaan penanggung jawab terlebih dahulu.'
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
        url: baseurl + 'pasien/save/',
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
                $('.table-detail').hide();
				setTimeout(function(){
					$('#table').fadeIn();
                    $('.table-detail').fadeIn();
				}, 100);

                if (response.redirect_id != 0) {
                    window.open(baseurl + 'pasien/cetak/' + response.redirect_id + '/', '_blank');
                }
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

// $('#formData').on('change', 'select[name="jenis_pasien"]', function(){
//     var jenis = $(this).val();
    
//     if (jenis == 'Hamil' || jenis == 'Melahirkan') {
//         $('.formTambahan').show();
//     } else{
//         $('.formTambahan').hide();
//     }
// });

$('#tablePasien').on('click', 'button[name="btn_print"]', function(){
    var id = $(this).attr('id');
    window.open(baseurl + 'pasien/cetak/' + id + '/', '_blank');
});

$('#tablePasien').on('click', 'button[name="btn_view"]', function(){
    var id = $(this).attr('id');
    $.ajax({
        type: 'POST',
        url: baseurl + 'pasien/detail/',
        data: {
            'id': id
        },
        dataType: 'json',
        success: function(response){
            if(response.result){
                var detail = response.detail;
                var rm = response.rm;
                
                $('#tableDetail tbody tr:eq(0) td:last').text(detail.no_registrasi);
                $('#tableDetail tbody tr:eq(1) td:last').text(detail.nik);
                $('#tableDetail tbody tr:eq(2) td:last').text(detail.nama_pasien);
                $('#tableDetail tbody tr:eq(3) td:last').text(formatTglLahir(detail.tgl_lahir));
                $('#tableDetail tbody tr:eq(4) td:last').text(detail.pendidikan_istri);
                $('#tableDetail tbody tr:eq(5) td:last').text(detail.agama_istri);
                $('#tableDetail tbody tr:eq(6) td:last').text(detail.nama_pekerjaan_istri);
                $('#tableDetail tbody tr:eq(7) td:last').text(detail.alamat_ktp_istri);
                $('#tableDetail tbody tr:eq(8) td:last').text(detail.alamat_istri);
                $('#tableDetail tbody tr:eq(9) td:last').text(detail.nama_ayah_kandung);
                $('#tableDetail tbody tr:eq(10) td:last').text(detail.nama_suami);
                $('#tableDetail tbody tr:eq(11) td:last').text(formatTglLahir(detail.tgl_lahir_suami));
                $('#tableDetail tbody tr:eq(12) td:last').text(detail.pendidikan_suami);
                $('#tableDetail tbody tr:eq(13) td:last').text(detail.agama_suami);
                $('#tableDetail tbody tr:eq(14) td:last').text(detail.nama_pekerjaan_suami);
                $('#tableDetail tbody tr:eq(15) td:last').text(detail.alamat_ktp_suami);
                $('#tableDetail tbody tr:eq(16) td:last').text(detail.alamat_suami);
                $('#tableDetail tbody tr:eq(17) td:last').text(detail.no_telp_pasien);
                $('#tableDetail tbody tr:eq(18) td:last').text(detail.email);
                $('#tableDetail tbody tr:eq(19) td:last').text(detail.medsos);

                $('#tableRM tbody tr').remove();
                for (var i = 0; i < rm.length; i++) {
                    var tr = $('<tr>');
                    tr.append('<td>'+ formatWaktu(rm[i].tgl_antrian) +'</td>');
                    tr.append('<td>'+ rm[i].nama_pelayanan +'</td>');
                    $('#tableRM tbody').append(tr);
                }
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

function getMonth(i)
{
    var month = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    return month[i - 1];
}

function formatWaktu(waktu)
{
    var format = '';

    var y = waktu.substring(0, 4);
    var m = waktu.substring(5, 7);
    m = parseInt(m);
    var d = waktu.substring(8, 10);
    d = parseInt(d);
    var t = waktu.substring(11, 16);

    format = d + '-' + getMonth(m) + '-' + y + ' ' + t;

    return format;
}

function formatTglLahir(waktu)
{
    var format = '';

    var y = waktu.substring(0, 4);
    var m = waktu.substring(5, 7);
    m = parseInt(m);
    var d = waktu.substring(8, 10);
    d = parseInt(d);

    format = d + '-' + getMonth(m) + '-' + y;

    return format;
}
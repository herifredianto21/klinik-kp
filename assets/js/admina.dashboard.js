var tableDilayani = '';
var tableProses = '';
var tableTerlayani = '';

var selectJenisPelayanan = '';
var selectPasien = '';
var selectDokter = '';
var selectPenyakit = '';
var selectRentangUmur = '';
var selectSatuanUsia = '';
var selectAlatKontrasepsi = '';
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
var selectTindakanImunisasi = '';
var selectTindakanImunisasiPemeriksaanUmum = '';

$('#li-dashboard').addClass('active');

$(document).ready(function(){
	tableDilayani = $('#tableDilayani').DataTable({
		'processing'	: false,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'dashboard/datatable-dilayani/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_layani" class="btn btn-info btn-sm" title="Layani"><i class="fa fa-check"></i> Layani</button>';

	            		row.push({
                            'no_antrian'    : response.data[x].no_antrian,
                            'nama_pasien'   : response.data[x].nama_pasien,
                            'nama_pelayanan': response.data[x].nama_pelayanan,
                            'nama_dokter'	: response.data[x].nama_dokter,
                            'status_antrian': response.data[x].status_antrian,
                            'tgl_antrian'   : response.data[x].tgl_antrian,
	            			'aksi'	        : button
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
            { 'data' : 'no_antrian' },
            { 'data' : 'nama_pasien' },
            { 'data' : 'nama_pelayanan' },
            { 'data' : 'nama_dokter' },
            { 'data' : 'status_antrian' },
            { 'data' : 'tgl_antrian' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 5, 'ASC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 6 ]
    		}
  		]
	});

	tableProses = $('#tableProses').DataTable({
		'processing'	: false,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'dashboard/datatable-proses/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_selesai" class="btn btn-success btn-sm" title="Selesai"><i class="fa fa-check"></i> Selesai</button>';

	            		row.push({
                            'no_antrian'    : response.data[x].no_antrian,
                            'nama_pasien'   : response.data[x].nama_pasien,
                            'nama_pelayanan': response.data[x].nama_pelayanan,
                            'nama_dokter'	: response.data[x].nama_dokter,
                            'status_antrian': response.data[x].status_antrian,
                            'tgl_antrian'   : response.data[x].tgl_antrian,
	            			'aksi'	        : button
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
            { 'data' : 'no_antrian' },
            { 'data' : 'nama_pasien' },
            { 'data' : 'nama_pelayanan' },
            { 'data' : 'nama_dokter' },
            { 'data' : 'status_antrian' },
            { 'data' : 'tgl_antrian' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 5, 'ASC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 6 ]
    		}
  		]
	});

	tableTerlayani = $('#tableTerlayani').DataTable({
		'processing'	: false,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'dashboard/datatable-terlayani/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
	            		row.push({
                            'no_antrian'    : response.data[x].no_antrian,
                            'nama_pasien'   : response.data[x].nama_pasien,
                            'nama_pelayanan': response.data[x].nama_pelayanan,
                            'nama_dokter'	: response.data[x].nama_dokter,
                            'status_antrian': response.data[x].status_antrian,
                            'tgl_antrian'   : response.data[x].tgl_antrian
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
            { 'data' : 'no_antrian' },
            { 'data' : 'nama_pasien' },
            { 'data' : 'nama_pelayanan' },
            { 'data' : 'nama_dokter' },
            { 'data' : 'status_antrian' },
            { 'data' : 'tgl_antrian' }
        ],

        'order' 	: [[ 5, 'DESC' ]]
	});

    $.ajax({
        type: 'GET',
        url: baseurl + 'antrian/select-jenis-pelayanan/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('select[name="id_jenis_pelayanan"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_pelayanan+'</option>');
                }
            }
        }
    });
    selectJenisPelayanan = $('select[name="id_jenis_pelayanan"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'antrian/select-pasien/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('select[name="id_pasien"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].no_registrasi+' | '+response.data[x].nama_pasien+'</option>');
                }
            }
        }
    });
    selectPasien = $('select[name="id_pasien"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'antrian/select-dokter/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('select[name="id_dokter"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_dokter+'</option>');
                }
            }
        }
    });
    selectDokter = $('select[name="id_dokter"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'dashboard/select-penyakit/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('#formDataPemeriksaanUmum select[name="id_penyakit"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_penyakit+'</option>');
                }
            }
        }
    });
    selectPenyakit = $('#formDataPemeriksaanUmum select[name="id_penyakit"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'dashboard/select-rentang-umur/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('#formDataPemeriksaanUmum select[name="id_rentang_umur"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].rentang_umur+'</option>');
                }
            }
        }
    });
    selectRentangUmur = $('#formDataPemeriksaanUmum select[name="id_rentang_umur"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataPemeriksaanUmum select[name="jenis_kelamin"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataProgramIspa select[name="jenis_kelamin"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataImunisasi select[name="hb0"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="bcg"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="pentabio1"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="pentabio2"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="pentabio3"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="campak"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="polio1"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="polio2"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="polio3"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="polio4"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="tt"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="campak_ulang"]').select2({
        'theme': 'bootstrap4'
    });
    $('#formDataImunisasi select[name="pentabio_ulang"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataPersalinan select[name="jenis_kelamin"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataPersalinan select[name="imd"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataPemeriksaanKehamilan select[name="k1"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataPemeriksaanKehamilan select[name="k4"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataPemeriksaanKehamilan select[name="buku_kia"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'dashboard/select-satuan-usia/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('#formDataKB select[name="id_satuan_usia"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_satuan+'</option>');
                }
            }
        }
    });
    selectSatuanUsia = $('#formDataKB select[name="id_satuan_usia"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'dashboard/select-alat-kontrasepsi/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                for(var x in response.data){
                    $('#formDataKB select[name="id_alat_kontrasepsi"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_alat+'</option>');
                }
            }
        }
    });
    selectAlatKontrasepsi = $('#formDataKB select[name="id_alat_kontrasepsi"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataKB select[name="pasang_baru"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataKB select[name="pasang_cabut"]').select2({
        'theme': 'bootstrap4'
    });

    $('#formDataKB select[name="t_4"]').select2({
        'theme': 'bootstrap4'
    });

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

    $.ajax({
        type: 'GET',
        url: baseurl + 'macam-tindakan-imunisasi/select/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_macam_tindakan_imunisasi"]').append('<option value="0">Tidak Ada</option>');
                for(var x in response.data){
                    $('select[name="id_macam_tindakan_imunisasi"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_tindakan+'</option>');
                }
            } else{
                $('select[name="id_macam_tindakan_imunisasi"]').append('<option value="0">Tidak Ada</option>');
            }
        }
    });
    selectTindakanImunisasi = $('select[name="id_macam_tindakan_imunisasi"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'macam-tindakan-imunisasi/select/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_macam_tindakan_imunisasi_pemeriksaan_umum"]').append('<option value="0">Tidak Ada</option>');
                for(var x in response.data){
                    $('select[name="id_macam_tindakan_imunisasi_pemeriksaan_umum"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_tindakan+'</option>');
                }
            } else{
                $('select[name="id_macam_tindakan_imunisasi_pemeriksaan_umum"]').append('<option value="0">Tidak Ada</option>');
            }
        }
    });
    selectTindakanImunisasiPemeriksaanUmum = $('select[name="id_macam_tindakan_imunisasi_pemeriksaan_umum"]').select2({
        'theme': 'bootstrap4'
    });

	setInterval('autoRefreshData()', 3000);
});

$('a[href="#tambahKunjungan"]').on('click', function(){
    $(selectJenisPelayanan).val('9').trigger('change');
    $(selectPasien).val('1').trigger('change');
    $(selectDokter).val('1').trigger('change');
    $('input[name="no_antrian"]').val('0');
    $.ajax({
        type: 'GET',
        url: baseurl + 'antrian/input-tgl-antrian/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('input[name="tgl_antrian"]').val(response.value);
            }
        }
    });
    $.ajax({
        type: 'GET',
        url: baseurl + 'antrian/input-kode-antrian/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('input[name="kode_antrian"]').val(response.value);
            }
        }
    });

    $('#tambahKunjungan').modal('show');
});

$('select[name="id_dokter"], select[name="id_jenis_pelayanan"]').change(function(){
    $.ajax({
        type: 'POST',
        url: baseurl + 'antrian/input-no-antrian/',
        data: {
            'id_dokter': $('select[name="id_dokter"]').val(),
            'id_jenis_pelayanan': $('select[name="id_jenis_pelayanan"]').val(),
        },
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('input[name="no_antrian"]').val(response.value);
            }
        }
    });
});

$('button[name="btn_tambah_kunjungan"]').on('click', function(){
    $(this).attr('disabled', 'disabled');
    var missing = false;
    $('#formDataTambahKunjungan').find('input').each(function(){
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
        url: baseurl + 'antrian/save/',
        data: {
            'id': $(this).attr('id'),
            'form': $('#formDataTambahKunjungan').serialize()
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
                autoRefreshData();
                $('#tambahKunjungan').modal('hide');
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

$('a[href="#tambahPasien"]').on('click', function(){
    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' + ((''+month).length<2 ? '0' : '') + month + '-' + ((''+day).length<2 ? '0' : '') + day;

    // $('button[name="btn_save"]').attr('id', '0');
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

    $('#tambahPasien').modal('show');
});

$('input[name="alamat_istri"]').on('change', function(){
    $('input[name="alamat_suami"]').val($(this).val());
});

$('button[name="btn_tambah_Pasien"]').on('click', function(){
    $(this).attr('disabled', 'disabled');
    var missing = false;
    $('#formDataTambahPasien').find('input').each(function(){
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
            'form': $('#formDataTambahPasien').serialize()
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
                $('#tambahPasien').modal('hide');
                
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

$('#tableDilayani').on('click', 'button[name="btn_layani"]', function(){
	var id = $(this).attr('id');

    $.ajax({
        type: 'POST',
        url: baseurl + 'dashboard/layani/',
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
                tableDilayani.ajax.reload(null, false);
                tableProses.ajax.reload(null, false);
                tableTerlayani.ajax.reload(null, false);
                getInfo();
                $(this).removeAttr('disabled');
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
                $(this).removeAttr('disabled');
            }
        }
    });
});

$('#tableProses').on('click', 'button[name="btn_selesai"]', function(){
	var id = $(this).attr('id');

    $.ajax({
        type: 'GET',
        url: baseurl + 'dashboard/pre-selesai/'+ id +'/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data;
                // console.log(d);

                switch(d.id_jenis_pelayanan){
                    case '9': // pemeriksaan umum
                        $('#formDataPemeriksaanUmum input[name="id_jenis_pelayanan"]').val(d.id_jenis_pelayanan);
                        $('#formDataPemeriksaanUmum input[name="no_antrian"]').val(d.no_antrian);
                        $('#formDataPemeriksaanUmum input[name="nama_pasien"]').val(d.nama_pasien);
                        $('#formDataPemeriksaanUmum input[name="nama_pelayanan"]').val(d.nama_pelayanan);
                        $('#formDataPemeriksaanUmum select[name="jenis_kelamin"]').val('L');
                        $(selectPenyakit).val('20').trigger('change');
                        $(selectRentangUmur).val('1').trigger('change');
                        $('button[name="btn_selesai_pemeriksaan_umum"]').attr('id', d.id);

                        $('#pemeriksaanUmum').modal('show');
                        break;
                    case '34': // program ispa
                        $('#formDataProgramIspa input[name="id_jenis_pelayanan"]').val(d.id_jenis_pelayanan);
                        $('#formDataProgramIspa input[name="no_antrian"]').val(d.no_antrian);
                        $('#formDataProgramIspa input[name="nama_pasien"]').val(d.nama_pasien);
                        $('#formDataProgramIspa input[name="nama_pelayanan"]').val(d.nama_pelayanan);
                        $('#formDataProgramIspa input[name="nama_anak"]').val('');
                        $('#formDataProgramIspa select[name="jenis_kelamin"]').val('L').trigger('change');
                        $('#formDataProgramIspa input[name="umur_tahun"]').val('');
                        $('#formDataProgramIspa input[name="umur_bulan"]').val('');
                        $('#formDataProgramIspa input[name="tb_pb"]').val('');
                        $('#formDataProgramIspa input[name="bb"]').val('');
                        $('#formDataProgramIspa textarea[name="catatan"]').val('');
                        $('button[name="btn_selesai_program_ispa"]').attr('id', d.id);

                        $('#programIspa').modal('show');
                        break;
                    case '8': // imunisasi
                        $('#formDataImunisasi input[name="id_jenis_pelayanan"]').val(d.id_jenis_pelayanan);
                        $('#formDataImunisasi input[name="no_antrian"]').val(d.no_antrian);
                        $('#formDataImunisasi input[name="nama_pasien"]').val(d.nama_pasien);
                        $('#formDataImunisasi input[name="nama_pelayanan"]').val(d.nama_pelayanan);
                        $('#formDataImunisasi input[name="nama_anak"]').val('');
                        $('#formDataImunisasi input[name="no_kk"]').val('');
                        $('#formDataImunisasi input[name="alamat"]').val('');
                        $('#formDataImunisasi input[name="tgl_lahir"]').val(getToday());
                        $('#formDataImunisasi input[name="bb_lahir"]').val('');
                        $('#formDataImunisasi input[name="bb"]').val('');
                        $('#formDataImunisasi input[name="pb"]').val('');
                        $('#formDataImunisasi select[name="hb0"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="bcg"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="pentabio1"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="pentabio2"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="pentabio3"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="campak"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="polio1"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="polio2"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="polio3"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="polio4"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="tt"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="campak_ulang"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="pentabio_ulang"]').val('0').trigger('change');
                        $('#formDataImunisasi select[name="id_macam_tindakan_imunisasi"]').val('0').trigger('change');
                        $('#formDataImunisasi textarea[name="catatan"]').val('');
                        $('button[name="btn_selesai_imunisasi"]').attr('id', d.id);

                        $('#imunisasi').modal('show');
                        break;
                    case '3': // persalinan
                        $('#formDataPersalinan input[name="id_jenis_pelayanan"]').val(d.id_jenis_pelayanan);
                        $('#formDataPersalinan input[name="no_antrian"]').val(d.no_antrian);
                        $('#formDataPersalinan input[name="id_pasien"]').val(d.id_pasien);
                        $('#formDataPersalinan input[name="nama_pasien"]').val(d.nama_pasien);
                        $('#formDataPersalinan input[name="nama_pelayanan"]').val(d.nama_pelayanan);
                        $('#formDataPersalinan input[name="umur"]').val('');
                        $('#formDataPersalinan textarea[name="alamat"]').val(d.alamat_istri);
                        $('#formDataPersalinan input[name="anak_ke"]').val('');
                        $('#formDataPersalinan input[name="bb"]').val('');
                        $('#formDataPersalinan input[name="pb"]').val('');
                        $('#formDataPersalinan input[name="tgl_lahir"]').val(getToday());
                        $('#formDataPersalinan input[name="jam_lahir"]').val('');
                        $('#formDataPersalinan select[name="jenis_kelamin"]').val('L').trigger('change');
                        $('#formDataPersalinan select[name="imd"]').val('1').trigger('change');
                        $('#formDataPersalinan input[name="lingkar_kepala"]').val('');
                        $('#formDataPersalinan textarea[name="resiko"]').val('');
                        $('#formDataPersalinan textarea[name="keterangan"]').val('');
                        $('#formDataPersalinan textarea[name="catatan"]').val('');
                        $('button[name="btn_selesai_persalinan"]').attr('id', d.id);

                        $('#persalinan').modal('show');
                        break;
                    case '1': // pemeriksaan kehamilan
                        $('#formDataPemeriksaanKehamilan input[name="id_jenis_pelayanan"]').val(d.id_jenis_pelayanan);
                        $('#formDataPemeriksaanKehamilan input[name="no_antrian"]').val(d.no_antrian);
                        $('#formDataPemeriksaanKehamilan input[name="id_pasien"]').val(d.id_pasien);
                        $('#formDataPemeriksaanKehamilan input[name="nama_pasien"]').val(d.nama_pasien);
                        $('#formDataPemeriksaanKehamilan input[name="nama_pelayanan"]').val(d.nama_pelayanan);
                        $('#formDataPemeriksaanKehamilan input[name="tgl_lahir"]').val(d.tgl_lahir);
                        $('#formDataPemeriksaanKehamilan input[name="nik"]').val(d.nik);
                        $('#formDataPemeriksaanKehamilan input[name="umur"]').val('');
                        $('#formDataPemeriksaanKehamilan input[name="nama_suami"]').val(d.nama_suami);
                        $('#formDataPemeriksaanKehamilan input[name="no_kk"]').val(d.no_kk);
                        $('#formDataPemeriksaanKehamilan input[name="buku_kia"]').val('baru');
                        $('#formDataPemeriksaanKehamilan textarea[name="alamat"]').val(d.alamat_istri);
                        $('#formDataPemeriksaanKehamilan input[name="hpht"]').val(getToday());
                        $('#formDataPemeriksaanKehamilan input[name="tp"]').val(getToday());
                        $('#formDataPemeriksaanKehamilan input[name="bb"]').val('');
                        $('#formDataPemeriksaanKehamilan input[name="tb"]').val('');
                        $('#formDataPemeriksaanKehamilan input[name="usia_kehamilan"]').val('');
                        $('#formDataPemeriksaanKehamilan input[name="gpa"]').val('');
                        $('#formDataPemeriksaanKehamilan select[name="k1"]').val('1').trigger('change');
                        $('#formDataPemeriksaanKehamilan select[name="k4"]').val('1').trigger('change');
                        $('#formDataPemeriksaanKehamilan input[name="tt"]').val('');
                        $('#formDataPemeriksaanKehamilan input[name="lila"]').val('');
                        $('#formDataPemeriksaanKehamilan input[name="hb"]').val('');
                        $('#formDataPemeriksaanKehamilan textarea[name="resiko"]').val('');
                        $('#formDataPemeriksaanKehamilan textarea[name="keterangan"]').val('');
                        $('#formDataPemeriksaanKehamilan input[name="vct"]').val('');
                        $('#formDataPemeriksaanKehamilan textarea[name="catatan"]').val('');
                        $('button[name="btn_selesai_pemeriksaan_kehamilan"]').attr('id', d.id);

                        $('#pemeriksaanKehamilan').modal('show');
                        break;
                    case '37': // KB
                        $('#formDataKB input[name="id_jenis_pelayanan"]').val(d.id_jenis_pelayanan);
                        $('#formDataKB input[name="no_antrian"]').val(d.no_antrian);
                        $('#formDataKB input[name="id_pasien"]').val(d.id_pasien);
                        $('#formDataKB input[name="nama_pasien"]').val(d.nama_pasien);
                        $('#formDataKB input[name="nama_pelayanan"]').val(d.nama_pelayanan);
                        $('#formDataKB input[name="umur"]').val('');
                        $('#formDataKB input[name="nama_suami"]').val(d.nama_suami);
                        $('#formDataKB textarea[name="alamat"]').val(d.alamat_istri);
                        $('#formDataKB input[name="jml_anak_laki"]').val('0');
                        $('#formDataKB input[name="jml_anak_perempuan"]').val('0');
                        $('#formDataKB input[name="jml_anak"]').val('0');
                        $('#formDataKB input[name="usia_anak_terkecil"]').val('');
                        $(selectSatuanUsia).val('1').trigger('change');
                        $('#formDataKB select[name="pasang_baru"]').val('1').trigger('change');
                        $('#formDataKB select[name="pasang_cabut"]').val('PEMASANGAN').trigger('change');
                        $(selectAlatKontrasepsi).val('1').trigger('change');
                        $('#formDataKB input[name="akli"]').val('');
                        $('#formDataKB select[name="t_4"]').val('1').trigger('change');
                        $('#formDataKB input[name="ganti_cara"]').val('');
                        $('#formDataKB textarea[name="catatan"]').val('');
                        $('button[name="btn_selesai_kb"]').attr('id', d.id);

                        $('#pemeriksaanKB').modal('show');
                        break;
                    default:
                        break;
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

function getInfo()
{
	$.ajax({
        type: 'GET',
        url: baseurl + 'dashboard/info/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data;

                $('.card-antrian .card-category').text(d.antrian);
                $('.card-pembayaran .card-category').text(d.pembayaran);
            }
        }
    });
}

function autoRefreshData()
{
    tableDilayani.ajax.reload(null, false);
    tableProses.ajax.reload(null, false);
    tableTerlayani.ajax.reload(null, false);
    getInfo();
}

function getToday()
{
    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var output = d.getFullYear() + '-' + ((''+month).length<2 ? '0' : '') + month + '-' + ((''+day).length<2 ? '0' : '') + day;

    return output
}

$('button[name="btn_selesai_pemeriksaan_umum"]').click(function(){
    $(this).attr('disabled', 'disabled');

    $.ajax({
        type: 'POST',
        url: baseurl + 'dashboard/selesai/',
        data: {
            'id': $(this).attr('id'),
            'form': $('#formDataPemeriksaanUmum').serialize()
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

                $('#pemeriksaanUmum').modal('hide');
                autoRefreshData();
                $(this).removeAttr('disabled');
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
                $(this).removeAttr('disabled');
            }
        }
    });
});

$('button[name="btn_selesai_program_ispa"]').click(function(){
    $(this).attr('disabled', 'disabled');

    var missing = false;
    $('#formDataProgramIspa').find('input').each(function(){
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
        url: baseurl + 'dashboard/selesai/',
        data: {
            'id': $(this).attr('id'),
            'form': $('#formDataProgramIspa').serialize()
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

                $('#programIspa').modal('hide');
                autoRefreshData();
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

$('button[name="btn_selesai_imunisasi"]').click(function(){
    $(this).attr('disabled', 'disabled');

    var missing = false;
    $('#formDataImunisasi').find('input').each(function(){
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
        url: baseurl + 'dashboard/selesai/',
        data: {
            'id': $(this).attr('id'),
            'form': $('#formDataImunisasi').serialize()
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

                $('#imunisasi').modal('hide');
                autoRefreshData();
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

$('button[name="btn_selesai_persalinan"]').click(function(){
    $(this).attr('disabled', 'disabled');

    var missing = false;
    $('#formDataPersalinan').find('input').each(function(){
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
        url: baseurl + 'dashboard/selesai/',
        data: {
            'id': $(this).attr('id'),
            'form': $('#formDataPersalinan').serialize()
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

                $('#persalinan').modal('hide');
                autoRefreshData();
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

$('button[name="btn_selesai_pemeriksaan_kehamilan"]').click(function(){
    $(this).attr('disabled', 'disabled');

    var missing = false;
    $('#formDataPemeriksaanKehamilan').find('input').each(function(){
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
        url: baseurl + 'dashboard/selesai/',
        data: {
            'id': $(this).attr('id'),
            'form': $('#formDataPemeriksaanKehamilan').serialize()
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

                $('#pemeriksaanKehamilan').modal('hide');
                autoRefreshData();
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

$('button[name="btn_selesai_kb"]').click(function(){
    $(this).attr('disabled', 'disabled');

    var missing = false;
    $('#formDataKB').find('input').each(function(){
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
        url: baseurl + 'dashboard/selesai/',
        data: {
            'id': $(this).attr('id'),
            'form': $('#formDataKB').serialize()
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

                $('#pemeriksaanKB').modal('hide');
                autoRefreshData();
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

$('input[name="filterDate"]').on('change', function(){
    tableTerlayani.search($(this).val()).draw();
});
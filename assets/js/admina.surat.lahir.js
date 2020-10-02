var table = '';
var selectPasien = '';
var selectDokter = '';
var selectHariLahir = '';
var selectJenisKelaminBayi = '';

$('a[href="#menuSurat"]').attr('aria-expanded', 'true');
$('#menuSurat').addClass('show');
$('#li-surat-lahir').addClass('active');

$(document).ready(function(){
	table = $('#tableSuratLahir').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'surat-lahir/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_print" class="btn btn-success btn-sm" title="Cetak Surat"><i class="fa fa-print"></i></button> <button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'            : i,
                            'no_surat'      : response.data[x].no_surat,
                            'nama_pasien'   : response.data[x].nama_pasien,
                            'nama_suami'    : response.data[x].nama_suami,
                            'nama_bayi'     : response.data[x].nama_bayi,
                            'hari_lahir'    : response.data[x].hari_lahir,
                            'tanggal_lahir' : response.data[x].tanggal_lahir,
                            'nama_dokter'   : response.data[x].nama_dokter,
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
        	{ 'data' : 'no' },
            { 'data' : 'no_surat' },
            { 'data' : 'nama_pasien' },
            { 'data' : 'nama_suami' },
            { 'data' : 'nama_bayi' },
            { 'data' : 'hari_lahir' },
            { 'data' : 'tanggal_lahir' },
            { 'data' : 'nama_dokter' },
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
        url: baseurl + 'surat-lahir/select-pasien/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_pasien"]').append('<option value="0">- Pilih Pasien -</option>');
                for(var x in response.data){
                    $('select[name="id_pasien"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_pasien+'</option>');
                }
            } else{
                $('select[name="id_pasien"]').append('<option value="0">- Pilih Pasien -</option>');
            }
        }
    });
    selectPasien = $('select[name="id_pasien"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'surat-lahir/select-dokter/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_dokter"]').append('<option value="0">- Pilih Dokter -</option>');
                for(var x in response.data){
                    $('select[name="id_dokter"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_dokter+'</option>');
                }
            } else{
                $('select[name="id_dokter"]').append('<option value="0">- Pilih Dokter -</option>');
            }
        }
    });
    selectDokter = $('select[name="id_dokter"]').select2({
        'theme': 'bootstrap4'
    });

    selectHariLahir = $('select[name="hari_lahir"]').select2({
        'theme': 'bootstrap4'
    });

    selectJenisKelaminBayi = $('select[name="jenis_kelamin_bayi"]').select2({
        'theme': 'bootstrap4'
    });
});

$('button[name="btn_add"]').click(function(){
    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var output = d.getFullYear() + '-' + ((''+month).length<2 ? '0' : '') + month + '-' + ((''+day).length<2 ? '0' : '') + day;

	$('button[name="btn_save"]').attr('id', '0');
    $.ajax({
        type: 'GET',
        url: baseurl + 'surat-lahir/input-no-surat/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('input[name="no_surat"]').val(response.value);
            }
        }
    });
    $(selectPasien).val('0').trigger('change');
    $('input[name="umur_istri"]').val('');
    $('input[name="pekerjaan_istri"]').val('');
    $('input[name="alamat_istri"]').val('');
    $('input[name="nama_suami"]').val('');
    $('input[name="umur_suami"]').val('');
    $('input[name="pekerjaan_suami"]').val('');
    $('input[name="alamat_suami"]').val('');
    $('input[name="pekerjaan_suami"]').val('');
    $('input[name="anak_ke"]').val('1');
    $('input[name="anak_dari"]').val('1');
    $(selectHariLahir).val('Minggu').trigger('change');
    $('input[name="tanggal_lahir"]').val(output);
    $('input[name="jam_lahir"]').val('00:00:00');
    $(selectJenisKelaminBayi).val('Laki-laki').trigger('change');
    $('input[name="berat_bayi"]').val('');
    $('input[name="panjang_bayi"]').val('');
    $('input[name="nama_bayi"]').val('');
    $(selectDokter).val('0').trigger('change');
    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tableSuratLahir').on('click', 'button[name="btn_edit"]', function(){
	var id = $(this).attr('id');

    $.ajax({
        type: 'GET',
        url: baseurl + 'surat-lahir/edit/'+ id +'/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                var d = response.data;

                $('input[name="no_surat"]').val(d.no_surat);

                $(selectPasien).find('option').each(function(){
                    if ($(this).val() == d.id_pasien) {
                        $(selectPasien).val($(this).val()).trigger('change');
                    }
                });

                $('input[name="umur_istri"]').val(d.umur_istri);
                $('input[name="pekerjaan_istri"]').val(d.pekerjaan_istri);
                $('input[name="alamat_istri"]').val(d.alamat_istri);
                $('input[name="nama_suami"]').val(d.nama_suami);
                $('input[name="umur_suami"]').val(d.umur_suami);
                $('input[name="pekerjaan_suami"]').val(d.pekerjaan_suami);
                $('input[name="alamat_suami"]').val(d.alamat_suami);
                $('input[name="anak_ke"]').val(d.anak_ke);
                $('input[name="anak_dari"]').val(d.anak_dari);

                $(selectHariLahir).find('option').each(function(){
                    if ($(this).val() == d.hari_lahir) {
                        $(selectHariLahir).val($(this).val()).trigger('change');
                    }
                });

                $('input[name="tanggal_lahir"]').val(d.tanggal_lahir);
                $('input[name="jam_lahir"]').val(d.jam_lahir);

                $(selectJenisKelaminBayi).find('option').each(function(){
                    if ($(this).val() == d.jenis_kelamin_bayi) {
                        $(selectJenisKelaminBayi).val($(this).val()).trigger('change');
                    }
                });

                $('input[name="berat_bayi"]').val(d.berat_bayi);
                $('input[name="panjang_bayi"]').val(d.panjang_bayi);
                $('input[name="nama_bayi"]').val(d.nama_bayi);

                $(selectDokter).find('option').each(function(){
                    if ($(this).val() == d.id_dokter) {
                        $(selectDokter).val($(this).val()).trigger('change');
                    }
                });

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

$('#tableSuratLahir').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'surat-lahir/delete/',
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

    if ($('select[name="id_pasien"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih pasien terlebih dahulu.'
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

    if ($('select[name="id_dokter"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih dokter terlebih dahulu.'
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
        url: baseurl + 'surat-lahir/save/',
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

$('select[name="id_pasien"]').change(function(){
    var id = $(this).val();

    $.ajax({
        type: 'GET',
        url: baseurl + 'surat-lahir/select-pasien/'+ id +'/',
        dataType: 'json',
        success: function(response){
            if(response.result && id != 0){
                for(var x in response.data){
                    $('input[name="alamat_istri"]').val(response.data[x].alamat_istri);
                    $('input[name="nama_suami"]').val(response.data[x].nama_suami);
                    $('input[name="alamat_suami"]').val(response.data[x].alamat_suami);
                }
            }
        }
    });
});

$('#tableSuratLahir').on('click', 'button[name="btn_print"]', function(){
    var id = $(this).attr('id');
    window.open(baseurl + 'surat-lahir/cetak/' + id + '/', '_blank');
});
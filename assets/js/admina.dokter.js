var table = '';
var selectKota = '';

$('a[href="#menuMaster"]').attr('aria-expanded', 'true');
$('#menuMaster').addClass('show');
$('#li-dokter').addClass('active');

$(document).ready(function(){
	table = $('#tableDokter').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'dokter/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'            : i,
	            			'nik'           : response.data[x].nik,
                            'nama_dokter'   : response.data[x].nama_dokter,
                            'spesialisasi'  : response.data[x].spesialisasi,
                            'alamat_dokter' : response.data[x].alamat_dokter,
                            'no_hp_dokter'  : response.data[x].no_hp_dokter,
                            'email_dokter'  : response.data[x].email_dokter,
                            'nama_kota'     : response.data[x].nama_kota,
	            			'aksi'		    : button
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
            { 'data' : 'nik' },
            { 'data' : 'nama_dokter' },
            { 'data' : 'spesialisasi' },
            { 'data' : 'alamat_dokter' },
            { 'data' : 'no_hp_dokter' },
            { 'data' : 'email_dokter' },
        	{ 'data' : 'nama_kota' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 2, 'ASC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 8 ]
    		}
  		]
	});

    $.ajax({
        type: 'GET',
        url: baseurl + 'dokter/select-kota/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="id_kota"]').append('<option value="0">- Pilih Kota -</option>');
                for(var x in response.data){
                    $('select[name="id_kota"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_kota+'</option>');
                }
            } else{
                $('select[name="id_kota"]').append('<option value="0">- Pilih Kota -</option>');
            }
        }
    });
    selectKota = $('select[name="id_kota"]').select2({
        'theme': 'bootstrap4'
    });
});

$('button[name="btn_add"]').click(function(){
	$('button[name="btn_save"]').attr('id', '0');
	$('input[name="nik"]').val('');
    $('input[name="nama_dokter"]').val('');
    $('input[name="spesialisasi"]').val('');
    $('input[name="alamat_dokter"]').val('');
    $('input[name="no_hp_dokter"]').val('');
    $('input[name="email_dokter"]').val('');
    $(selectKota).val('0').trigger('change');
    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tableDokter').on('click', 'button[name="btn_edit"]', function(){
	var id = $(this).attr('id');
    var nik = '';
	var nama = '';
    var spesialisasi = '';
    var alamat = '';
    var hp = '';
    var email = '';
    var kota = '';
	$('#tableDokter tbody tr').each(function(){
		var selected = $(this).find(':button').attr('id');
		if (selected == id) {
			nik = $(this).find('td:eq(1)').text();
            nama = $(this).find('td:eq(2)').text();
            spesialisasi = $(this).find('td:eq(3)').text();
            alamat = $(this).find('td:eq(4)').text();
            hp = $(this).find('td:eq(5)').text();
            email = $(this).find('td:eq(6)').text();
            kota = $(this).find('td:eq(7)').text();
		}
	});

	$('button[name="btn_save"]').attr('id', id);
	$('input[name="nik"]').val(nik);
    $('input[name="nama_dokter"]').val(nama);
    $('input[name="spesialisasi"]').val(spesialisasi);
    $('input[name="alamat"]').val(alamat);
    $('input[name="no_hp_dokter"]').val(hp);
    $('input[name="email_dokter"]').val(email);
    $(selectKota).find('option').each(function(){
        if ($(this).text() == kota) {
            $(selectKota).val($(this).val()).trigger('change');
        }
    });
    $('#formTitle').text('Edit Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tableDokter').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'dokter/delete/',
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
	$('input[name="nik"]').val('');
    $('input[name="nama_dokter"]').val('');
    $('input[name="spesialisasi"]').val('');
    $('input[name="alamat_dokter"]').val('');
    $('input[name="no_hp_dokter"]').val('');
    $('input[name="email_dokter"]').val('');
    $(selectKota).val('0').trigger('change');

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

    if ($('select[name="id_kota"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih kota terlebih dahulu.'
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
        url: baseurl + 'dokter/save/',
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
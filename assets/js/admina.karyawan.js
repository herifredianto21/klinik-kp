var table = '';
var selectJenisKaryawan = '';
var selectJenisKelamin = '';
var selectKota = '';
var selectDepartment = '';
var selectRole = '';

$('a[href="#menuTim"]').attr('aria-expanded', 'true');
$('a[href="#menuMaster"]').attr('aria-expanded', 'true');
$('#menuTim').addClass('show');
$('#menuMaster').addClass('show');
$('#menuTim #li-karyawan').addClass('active');
$('#menuMaster #li-karyawan').addClass('active');

$(document).ready(function(){
	table = $('#tableKaryawan').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'karyawan/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
            			var button = '<button id="'+ response.data[x].id +'" name="btn_edit" class="btn btn-info btn-sm" title="Edit Data"><i class="fa fa-edit"></i></button> <button id="'+ response.data[x].id +'" name="btn_delete" class="btn btn-danger btn-sm" title="Hapus Data"><i class="fa fa-trash"></i></button>';

	            		row.push({
	            			'no'                : i,
                            'jenis_karyawan'    : response.data[x].jenis_karyawan,
                            'nik'               : response.data[x].nik,
                            'name'              : response.data[x].name,
                            'spesialisasi'      : response.data[x].spesialisasi,
                            'gender'            : response.data[x].gender,
                            'email'             : response.data[x].email,
                            'mobile'            : response.data[x].mobile,
                            'address'           : response.data[x].address,
                            'nama_kota'         : response.data[x].nama_kota,
                            'department_name'   : response.data[x].department_name,
                            'date_birth'        : response.data[x].date_birth,
                            'role_name'         : response.data[x].role_name,
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
            { 'data' : 'jenis_karyawan' },
            { 'data' : 'nik' },
            { 'data' : 'name' },
            { 'data' : 'spesialisasi' },
            { 'data' : 'gender' },
            { 'data' : 'email' },
            { 'data' : 'mobile' },
            { 'data' : 'address' },
            { 'data' : 'nama_kota' },
            { 'data' : 'department_name' },
            { 'data' : 'date_birth' },
            { 'data' : 'role_name' },
        	{ 'data' : 'aksi' }
        ],

        'order' 	: [[ 3, 'ASC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0, 13 ]
    		}
  		]
	});

    $('select[name="jenis_karyawan"]').prepend('<option value="0">- Pilih Jenis Karyawan -</option>');
    selectJenisKaryawan = $('select[name="jenis_karyawan"]').select2({
        'theme': 'bootstrap4'
    });

    $('select[name="jenis_kelamin"]').prepend('<option value="0">- Pilih Jenis Kelamin -</option>');
    selectJenisKelamin = $('select[name="jenis_kelamin"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'karyawan/select-kota/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="city"]').append('<option value="0">- Pilih Kota -</option>');
                for(var x in response.data){
                    $('select[name="city"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].nama_kota+'</option>');
                }
            } else{
                $('select[name="city"]').append('<option value="0">- Pilih Kota -</option>');
            }
        }
    });
    selectKota = $('select[name="city"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'karyawan/select-department/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="dept"]').append('<option value="0">- Pilih Department -</option>');
                for(var x in response.data){
                    $('select[name="dept"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].name+'</option>');
                }
            } else{
                $('select[name="dept"]').append('<option value="0">- Pilih Department -</option>');
            }
        }
    });
    selectDepartment = $('select[name="dept"]').select2({
        'theme': 'bootstrap4'
    });

    $.ajax({
        type: 'GET',
        url: baseurl + 'karyawan/select-role/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('select[name="role"]').append('<option value="0">- Pilih Role -</option>');
                for(var x in response.data){
                    $('select[name="role"]').append('<option value="'+ response.data[x].id +'">'+response.data[x].name+'</option>');
                }
            } else{
                $('select[name="role"]').append('<option value="0">- Pilih Role -</option>');
            }
        }
    });
    selectRole = $('select[name="role"]').select2({
        'theme': 'bootstrap4'
    });
});

$('button[name="btn_add"]').click(function(){
	$('button[name="btn_save"]').attr('id', '0');
    $(selectJenisKaryawan).val('0').trigger('change');
    $.ajax({
        type: 'GET',
        url: baseurl + 'karyawan/input-nik/',
        dataType: 'json',
        success: function(response){
            if(response.result){
                $('input[name="nik"]').val(response.value);
            } else{
                $('input[name="nik"]').val('');
            }
        }
    });
    $('input[name="name"]').val('');
    $('input[name="spesialisasi"]').val('');
    $(selectJenisKelamin).val('0').trigger('change');
    $('input[name="email"]').val('');
    $('input[name="mobile"]').val('');
    $('input[name="address"]').val('');
    $(selectKota).val('0').trigger('change');
    $(selectDepartment).val('0').trigger('change');
    
    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' + ((''+month).length<2 ? '0' : '') + month + '-' + ((''+day).length<2 ? '0' : '') + day;
    $('input[name="date_birth"]').val(output);
    
    $(selectRole).val('0').trigger('change');
    $('#formTitle').text('Tambah Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tableKaryawan').on('click', 'button[name="btn_edit"]', function(){
	var id = $(this).attr('id');
    var jenis_karyawan = '';
	var nik = '';
    var name = '';
    var spesialisasi = '';
    var jenis_kelamin = '';
    var email = '';
    var mobile = '';
    var address = '';
    var city = '';
    var dept = '';
    var date_birth = '';
    var role = '';
	$('#tableKaryawan tbody tr').each(function(){
		var selected = $(this).find(':button').attr('id');
		if (selected == id) {
            jenis_karyawan = $(this).find('td:eq(1)').text();
			nik = $(this).find('td:eq(2)').text();
            name = $(this).find('td:eq(3)').text();
            spesialisasi = $(this).find('td:eq(4)').text();
            jenis_kelamin = $(this).find('td:eq(5)').text();
            email = $(this).find('td:eq(6)').text();
            mobile = $(this).find('td:eq(7)').text();
            address = $(this).find('td:eq(8)').text();
            city = $(this).find('td:eq(9)').text();
            dept = $(this).find('td:eq(10)').text();
            date_birth = $(this).find('td:eq(11)').text();
            role = $(this).find('td:eq(12)').text();
		}
	});

	$('button[name="btn_save"]').attr('id', id);
    $(selectJenisKaryawan).find('option').each(function(){
        if ($(this).text() == jenis_karyawan) {
            $(selectJenisKaryawan).val($(this).val()).trigger('change');
        }
    });
	$('input[name="nik"]').val(nik);
    $('input[name="name"]').val(name);
    $('input[name="spesialisasi"]').val(spesialisasi);
    $(selectJenisKelamin).find('option').each(function(){
        if ($(this).text() == jenis_kelamin) {
            $(selectJenisKelamin).val($(this).val()).trigger('change');
        }
    });
    $('input[name="email"]').val(email);
    $('input[name="mobile"]').val(mobile);
    $('input[name="address"]').val(address);
    $(selectKota).find('option').each(function(){
        if ($(this).text() == city) {
            $(selectKota).val($(this).val()).trigger('change');
        }
    });
    $(selectDepartment).find('option').each(function(){
        if ($(this).text() == dept) {
            $(selectDepartment).val($(this).val()).trigger('change');
        }
    });
    $('input[name="date_birth"]').val(date_birth);
    $(selectRole).find('option').each(function(){
        if ($(this).text() == role) {
            $(selectRole).val($(this).val()).trigger('change');
        }
    });
    $('#formTitle').text('Edit Data');

	$('#table').hide();
	setTimeout(function(){
		$('#form').fadeIn()
	}, 100);
});

$('#tableKaryawan').on('click', 'button[name="btn_delete"]', function(){
	if (!confirm('Apakah anda yakin?')) {
		return;
	}

	var id = $(this).attr('id');

	$.ajax({
        type: 'POST',
        url: baseurl + 'karyawan/delete/',
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
    $(selectJenisKaryawan).val('0').trigger('change');
    $('input[name="nik"]').val('');
    $('input[name="name"]').val('');
    $('input[name="spesialisasi"]').val('');
    $(selectJenisKelamin).val('0').trigger('change');
    $('input[name="email"]').val('');
    $('input[name="mobile"]').val('');
    $('input[name="address"]').val('');
    $(selectKota).val('0').trigger('change');
    $(selectDepartment).val('0').trigger('change');
    $('input[name="date_birth"]').val('');
    $(selectRole).val('0').trigger('change');

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

    if ($('select[name="jenis_karyawan"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih jenis karyawan terlebih dahulu.'
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

    if ($('select[name="jenis_kelamin"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih jenis kelamin terlebih dahulu.'
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

    if ($('select[name="dept"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih department terlebih dahulu.'
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

    if ($('select[name="role"]').val() == 0) {
        $.notify({
            icon: 'now-ui-icons ui-1_bell-53',
            message: 'Silakan pilih role terlebih dahulu.'
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
        url: baseurl + 'karyawan/save/',
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
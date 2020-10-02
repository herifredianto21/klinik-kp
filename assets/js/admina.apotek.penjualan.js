var selectObat = '';
var totalBayar = 0;

$('#li-apotek').addClass('active');

$(document).ready(function(){	
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

$('.tableObat tbody').on('click', '.btn-danger', function(){
	var idx = get_index(this);
        
	if (idx != 0) {
		var tr = $(this).closest("tr");
		$(tr).fadeOut(500, function(){
			$(this).remove();
		});
	}
});

$('button[name="btn_back"]').on('click', function(){
    window.location.href = baseurl + 'apotek/';
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
	$('input[name="biaya_obat_nominal[]"]').each(function(index){
		var biaya = parseInt($(this).val()) ? parseInt($(this).val()) : 0;
		total = total + biaya;
	});
	var diskon = parseInt($('input[name="biaya_diskon"]').val()) ? parseInt($('input[name="biaya_diskon"]').val()) : 0;
	total = total - diskon;
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

    $('#formData').find('select[name="biaya_obat[]"]').each(function(){
        if($(this).val() == 0){
            $.notify({
                icon: 'now-ui-icons ui-1_bell-53',
                message: 'Silakan pilih obat terlebih dahulu.'
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
    });

    $(this).removeAttr('disabled');
    if(missing){
        return;
	}
	
	$.ajax({
        type: 'POST',
        url: baseurl + 'apotek/save-penjualan/',
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
                
                setTimeout(function(){
                    window.open(baseurl+'apotek/cetak_langsung/'+response.id_penjualan);
                    window.location.href = baseurl + 'apotek/';
                }, 1000);
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
var table = '';
var tableObat = '';

$('#li-rekam-medis').addClass('active');

$(document).ready(function(){
    table = $('#tableRiwayat').DataTable({
        'processing'    : true,
        'serverSide'    : true,

        'ajax' : {
            'url'   : baseurl + 'rekam-medis/datatable/',
            'type'  : 'GET',
            'dataSrc' : function(response){
                var i = response.start;
                var row = new Array();
                if (response.result) {
                    for(var x in response.data){
                        row.push({
                            'no'                : i,
                            'no_registrasi'     : response.data[x].no_registrasi,
                            'nama_pasien'       : response.data[x].nama_pasien,
                            'nama_pelayanan'    : response.data[x].nama_pelayanan,
                            'id_antrian'        : '<button id="'+ response.data[x].id +'" class="btn btn-info btn-sm"><i class="fa fa-search"></i> Detail</button>'
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
            { 'data' : 'no_registrasi' },
            { 'data' : 'nama_pasien' },
            { 'data' : 'nama_pelayanan' },
            { 'data' : 'id_antrian' }
        ],

        'columnDefs': [
            {
                'orderable' : false,
                'targets'   : [ 0 ]
            }
        ]
    });

    tableObat = $('#tableObat').DataTable({
        'searching' : false,
        'paging'    : false,
        'info'      : false,
        'sorting'   : false
    });

    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var year = d.getFullYear();
    month = ((''+month).length<2 ? '0' : '') + month;
    day = ((''+day).length<2 ? '0' : '') + day;

    if (year > 2019) {
        var rentang = year - 2019 + 1;
        for (var i = 1; i < rentang; i++) {
            $('select[name="filter-tahun"]').prepend('<option value="'+ (2019+i) +'">'+ (2019+i) +'</option>');
        }
    }

    $('select[name="filter-tanggal"]').val(day).trigger('change');
    $('select[name="filter-bulan"]').val(month).trigger('change');
    $('select[name="filter-tahun"]').val(year).trigger('change');

	$('select[name="filter-tanggal"], select[name="filter-bulan"], select[name="filter-tahun"]').select2({
        'theme': 'bootstrap4'
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

$('#tableRiwayat tbody').on('click', 'button', function(){
    var id = $(this).attr('id');
   $.ajax({
        type: 'POST',
        url: baseurl + 'rekam-medis/detail/',
        data: {
            'id': id
        },
        dataType: 'json',
        success: function(response){
            if(response.result){
                var detail = response.detail;
                var obat = response.obat;

                $('.tanggal-kunjungan').html('Waktu Kunjungan: <b class="pull-right"><u>'+ formatWaktu(detail.tgl_antrian) +'</u></b>');
                $('.no-rekam-medis').html('No. Rekam Medis: <b class="pull-right"><u>'+ detail.no_registrasi +'</u></b>');
                $('.nama-pasien').html('Nama Pasien: <b class="pull-right"><u>'+ detail.nama_pasien +'</u></b>');
                $('.jenis-pelayanan').html('Jenis Pelayanan: <b class="pull-right"><u>'+ detail.nama_pelayanan +'</u></b>');
                $('.hasil-diagnoasa').html('Hasil Diagnosa: <br>'+ detail.catatan);

                $('#tableObat tbody tr').remove();
                for (var i = 0; i < obat.length; i++) {
                    var tr = $('<tr>');
                    tr.append('<td>'+ obat[i].nama_obat +'</td>');
                    tr.append('<td>'+ obat[i].qty_jual +'</td>');
                    tr.append('<td>'+ obat[i].nama_satuan +'</td>');
                    $('#tableObat tbody').append(tr);
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

$('select[name="filter-tahun"], select[name="filter-bulan"], select[name="filter-tanggal"]').on('change', function(){
    var filter = $('select[name="filter-tahun"]').val() + '-' + $('select[name="filter-bulan"]').val() + '-' + $('select[name="filter-tanggal"]').val();
    table.search(filter).draw();
});
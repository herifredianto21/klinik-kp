$('#li-apotek').addClass('active');

$('button[name="btn_kembali"]').on('click', function(){
    window.location.href = baseurl+'apotek/';
});

$('button[name="btn_cetak_harian"]').on('click', function(){
    var y = $('select[name="harian_tahun"]').val();
    var m = $('select[name="harian_bulan"]').val();
    var d = $('select[name="harian_tanggal"]').val();
    var tanggal = y + '-' + m + '-' + d;
    window.open(baseurl + 'apotek/cetak-laporan-harian?tanggal=' + tanggal);
});

$('button[name="btn_cetak_bulanan"]').on('click', function(){
    var y = $('select[name="harian_tahun"]').val();
    var m = $('select[name="harian_bulan"]').val();
    var bulan = y + '-' + m;
    window.open(baseurl + 'apotek/cetak-laporan-bulanan?bulan=' + bulan);
});
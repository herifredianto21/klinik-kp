$('#li-tindakan-medis').addClass('active');

var active = 'btn-primary';
var inactive = 'btn-light';

var id_antrian,
    id_dokter,
    diagnosa,
    tindak_lanjut,
    keterangan_tindak_lanjut,
    newUrl;

$(document).ready(function() {
    updateUrlForButtonSimpan();
    updateUrlForInsertTindakan();
    updateUrlForUpdateTindakan();
    updateUrlForInsertResep();

    // DataTables
    var dataTables = $('table').dataTable();

    $('form').submit(function() {
        $(dataTables.fnGetHiddenNodes()).find('input:checked').appendTo(this);
        alert('function kirim() 1');
        console.log(dataTables);
        // return true;
    });

    var kirim = function() {
        $(dataTables.fnGetHiddenNodes()).find('input').appendTo(this);
        alert('function kirim() 2');
        return false;
    }

    // Navigation
    $('#btnDiagnosa').click(function() {
        deactivateAllBtn();
        activateBtn(this);
        
        changeUrlParameter('langkah', 'diagnosa');
    });
    $('#btnResep').click(function() {
        deactivateAllBtn();
        activateBtn(this);
        
        changeUrlParameter('langkah', 'resep');
    });
    $('#btnTindakan').click(function() {
        deactivateAllBtn();
        activateBtn(this);

        changeUrlParameter('langkah', 'tindakan');
    });
    $('#btnTindakLanjut').click(function() {
        deactivateAllBtn();
        activateBtn(this);
        
        changeUrlParameter('langkah', 'tindak_lanjut');
    });

    // Toggle Show Form
    // Diagnosa
    $('#langkahDiagnosa #btnShowForm').click(function() {
        $('#langkahDiagnosa #table').fadeOut();
        $('#langkahDiagnosa #form').fadeIn();
    });
    $('#langkahDiagnosa #btnCancel').click(function() {
        $('#langkahDiagnosa #form').fadeOut();
        $('#langkahDiagnosa #table').fadeIn();
    });
    
    // Resep
    $('#langkahResep #btnShowForm').click(function() {
        $('#langkahResep #table').fadeOut();
        $('#langkahResep #form').fadeIn();
    });
    $('#langkahResep #btnCancel').click(function() {
        $('#langkahResep #form').fadeOut();
        $('#langkahResep #table').fadeIn();
    });
    
    // Tindakan
    $('#langkahTindakan #btnShowForm').click(function() {
        $('#langkahTindakan #table').fadeOut();
        $('#langkahTindakan #form').fadeIn();
    });
    $('#langkahTindakan #btnCancel').click(function() {
        $('#langkahTindakan #form').fadeOut();
        $('#langkahTindakan #table').fadeIn();
    });
    
    // Event Listener untuk mengambil value
    $('#textareaDiagnosa').on('keyup change', function() {
        changeUrlParameter('diagnosa', $('#textareaDiagnosa').val());
        
        updateUrlForButtonSimpan();
        updateUrlForInsertTindakan();
        updateUrlForUpdateTindakan();
        updateUrlForInsertResep();
    });
    $('#selectTindakLanjut').on('change', function() {
        changeUrlParameter('tindak_lanjut', $('#selectTindakLanjut').val());
        
        updateUrlForButtonSimpan();
        updateUrlForInsertTindakan();
        updateUrlForUpdateTindakan();
        updateUrlForInsertResep();
    });
    $('#textareaKeteranganTindakLanjut').on('keyup change', function() {
        changeUrlParameter('keterangan_tindak_lanjut', $('#textareaKeteranganTindakLanjut').val());
        
        updateUrlForButtonSimpan();
        updateUrlForInsertTindakan();
        updateUrlForUpdateTindakan();
        updateUrlForInsertResep();
    });
    $('#aSimpanTindakanMedis').on('click', function() {
        updateUrlForButtonSimpan();
        updateUrlForInsertTindakan();
        updateUrlForUpdateTindakan();
        updateUrlForInsertResep();
    });
    $('#formInsertTindakan').on('submit', function() {
        updateUrlForButtonSimpan();
        updateUrlForInsertTindakan();
        updateUrlForUpdateTindakan();
        updateUrlForInsertResep();
    });
    $('#formUpdateTindakan').on('submit', function() {
        updateUrlForButtonSimpan();
        updateUrlForInsertTindakan();
        updateUrlForUpdateTindakan();
        updateUrlForInsertResep();
    });
});


var deactivateAllBtn = function() {
    $('#btnDiagnosa').removeClass(active);
    $('#btnDiagnosa').addClass(inactive);

    $('#btnResep').removeClass(active);
    $('#btnResep').addClass(inactive);

    $('#btnTindakan').removeClass(active);
    $('#btnTindakan').addClass(inactive);

    $('#btnTindakLanjut').removeClass(active);
    $('#btnTindakLanjut').addClass(inactive);
}

var activateBtn = function(btn) {
    $(btn).removeClass(inactive);
    $(btn).addClass(active)
}

var changeUrlParameter = function(parameter, parameterValue) {
    var url = new URLSearchParams(window.location.search);
    url.set(parameter, parameterValue);

    window.history.pushState("", "", baseurl + "tindakan_medis?" + url);
}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

var updateUrlForInsertTindakan = function() {
    id_antrian = getUrlParameter('id_antrian') !== undefined ? getUrlParameter('id_antrian') : '';
    id_dokter = getUrlParameter('id_dokter') !== undefined ? getUrlParameter('id_dokter') : '';
    nama_pasien = getUrlParameter('nama_pasien') !== undefined ? getUrlParameter('nama_pasien') : '';
    nama_dokter = getUrlParameter('nama_dokter') !== undefined ? getUrlParameter('nama_dokter') : '';
    diagnosa = getUrlParameter('diagnosa') !== undefined ? getUrlParameter('diagnosa') : '';
    tindak_lanjut = getUrlParameter('tindak_lanjut') !== undefined ? getUrlParameter('tindak_lanjut') : '';
    keterangan_tindak_lanjut = getUrlParameter('keterangan_tindak_lanjut') !== undefined ? getUrlParameter('keterangan_tindak_lanjut') : '';
    
    newUrl = baseurl + 'tindakan-medis/addTindakan?langkah=tindakan&id_antrian=' + id_antrian + '&id_dokter=' + id_dokter + '&nama_pasien=' + nama_pasien + '&nama_dokter=' + nama_dokter + '&diagnosa=' + diagnosa + '&tindak_lanjut=' + tindak_lanjut + '&keterangan_tindak_lanjut=' + keterangan_tindak_lanjut;

    $('#formInsertTindakan').attr('action', newUrl);
}

var updateUrlForUpdateTindakan = function() {
    id_antrian = getUrlParameter('id_antrian') !== undefined ? getUrlParameter('id_antrian') : '';
    id_dokter = getUrlParameter('id_dokter') !== undefined ? getUrlParameter('id_dokter') : '';
    nama_pasien = getUrlParameter('nama_pasien') !== undefined ? getUrlParameter('nama_pasien') : '';
    nama_dokter = getUrlParameter('nama_dokter') !== undefined ? getUrlParameter('nama_dokter') : '';
    diagnosa = getUrlParameter('diagnosa') !== undefined ? getUrlParameter('diagnosa') : '';
    tindak_lanjut = getUrlParameter('tindak_lanjut') !== undefined ? getUrlParameter('tindak_lanjut') : '';
    keterangan_tindak_lanjut = getUrlParameter('keterangan_tindak_lanjut') !== undefined ? getUrlParameter('keterangan_tindak_lanjut') : '';
    
    newUrl = baseurl + 'tindakan-medis/editAddedTindakan?langkah=tindakan&id_antrian=' + id_antrian + '&id_dokter=' + id_dokter + '&nama_pasien=' + nama_pasien + '&nama_dokter=' + nama_dokter + '&diagnosa=' + diagnosa + '&tindak_lanjut=' + tindak_lanjut + '&keterangan_tindak_lanjut=' + keterangan_tindak_lanjut;

    $('#formUpdateTindakan').attr('action', newUrl);
}

var updateUrlForInsertResep = function() {
    id_antrian = getUrlParameter('id_antrian') !== undefined ? getUrlParameter('id_antrian') : '';
    id_dokter = getUrlParameter('id_dokter') !== undefined ? getUrlParameter('id_dokter') : '';
    nama_pasien = getUrlParameter('nama_pasien') !== undefined ? getUrlParameter('nama_pasien') : '';
    nama_dokter = getUrlParameter('nama_dokter') !== undefined ? getUrlParameter('nama_dokter') : '';
    diagnosa = getUrlParameter('diagnosa') !== undefined ? getUrlParameter('diagnosa') : '';
    tindak_lanjut = getUrlParameter('tindak_lanjut') !== undefined ? getUrlParameter('tindak_lanjut') : '';
    keterangan_tindak_lanjut = getUrlParameter('keterangan_tindak_lanjut') !== undefined ? getUrlParameter('keterangan_tindak_lanjut') : '';
    
    newUrl = baseurl + 'tindakan-medis/addResep?langkah=resep&id_antrian=' + id_antrian + '&id_dokter=' + id_dokter + '&nama_pasien=' + nama_pasien + '&nama_dokter=' + nama_dokter + '&diagnosa=' + diagnosa + '&tindak_lanjut=' + tindak_lanjut + '&keterangan_tindak_lanjut=' + keterangan_tindak_lanjut;

    $('#formInsertResep').attr('action', newUrl);
}

var updateUrlForButtonSimpan = function() {
    id_antrian = getUrlParameter('id_antrian') !== undefined ? getUrlParameter('id_antrian') : '';
    diagnosa = getUrlParameter('diagnosa') !== undefined ? getUrlParameter('diagnosa') : '';
    tindak_lanjut = getUrlParameter('tindak_lanjut') !== undefined ? getUrlParameter('tindak_lanjut') : '';
    keterangan_tindak_lanjut = getUrlParameter('keterangan_tindak_lanjut') !== undefined ? getUrlParameter('keterangan_tindak_lanjut') : '';
    
    newUrl = baseurl + 'tindakan_medis/simpanTindakanMedis?id_antrian=' + id_antrian + '&id_dokter=' + id_dokter + '&diagnosa=' + diagnosa + '&tindak_lanjut=' + tindak_lanjut + '&keterangan_tindak_lanjut=' + keterangan_tindak_lanjut;

    $('#aSimpanTindakanMedis').attr('href', newUrl);
}

var doInBackground = function(url) {
    if (confirm('Apakah Anda yakin ingin menghapus?')) {
        $.ajax({url: url, success: function(result) {
            location.reload();
        }});
    }
}

var selectDataToEditTindakan = function(id_tindakan_pasien_detail, nama_biaya_medis, keterangan_tindakan_pasien) {
    $('#formUpdateTindakan input[name=id_tindakan_pasien_detail]').val(id_tindakan_pasien_detail);
    $('#formUpdateTindakan input[name=nama_biaya_medis]').val(nama_biaya_medis);
    $('#formUpdateTindakan textarea[name=keterangan_tindakan_pasien]').val(keterangan_tindakan_pasien);
}
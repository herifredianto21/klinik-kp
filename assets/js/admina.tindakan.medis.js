$('#li-tindakan-medis').addClass('active');

var active = 'btn-primary';
var inactive = 'btn-light';

var id_antrian,
    diagnosa,
    tindak_lanjut,
    keterangan_tindak_lanjut,
    newUrl;

newUrl = baseurl + 'tindakan_medis/simpanTindakanMedis?id_antrian=' + id_antrian + '&diagnosa=' + diagnosa + '&tindak_lanjut=' + tindak_lanjut + '&keterangan_tindak_lanjut=' + keterangan_tindak_lanjut;

$(document).ready(function() {
    
    updateUrlForButtonSimpan();
    updateUrlForInsertTindakan();
    // updateUrlForDeleteTindakan();

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
        updateUrlForDeleteTindakan();
    });
    $('#selectTindakLanjut').on('change', function() {
        changeUrlParameter('tindak_lanjut', $('#selectTindakLanjut').val());
        
        updateUrlForButtonSimpan();
        updateUrlForInsertTindakan();
        updateUrlForDeleteTindakan();
    });
    $('#textareaKeteranganTindakLanjut').on('keyup change', function() {
        changeUrlParameter('keterangan_tindak_lanjut', $('#textareaKeteranganTindakLanjut').val());
        
        updateUrlForButtonSimpan();
        updateUrlForInsertTindakan();
        updateUrlForDeleteTindakan();
    });
    $('#aSimpanTindakanMedis').on('click', function() {
        updateUrlForButtonSimpan();
        updateUrlForInsertTindakan();
        updateUrlForDeleteTindakan();
    });
    $('#formInsertTindakan').on('submit', function() {
        updateUrlForButtonSimpan();
        updateUrlForInsertTindakan();
        updateUrlForDeleteTindakan();
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

var updateUrlForButtonSimpan = function() {
    id_antrian = getUrlParameter('id_antrian') !== undefined ? getUrlParameter('id_antrian') : '';
    diagnosa = getUrlParameter('diagnosa') !== undefined ? getUrlParameter('diagnosa') : '';
    tindak_lanjut = getUrlParameter('tindak_lanjut') !== undefined ? getUrlParameter('tindak_lanjut') : '';
    keterangan_tindak_lanjut = getUrlParameter('keterangan_tindak_lanjut') !== undefined ? getUrlParameter('keterangan_tindak_lanjut') : '';
    
    newUrl = baseurl + 'tindakan_medis/simpanTindakanMedis?id_antrian=' + id_antrian + '&diagnosa=' + diagnosa + '&tindak_lanjut=' + tindak_lanjut + '&keterangan_tindak_lanjut=' + keterangan_tindak_lanjut;

    $('#aSimpanTindakanMedis').attr('href', newUrl);
}

var updateUrlForInsertTindakan = function() {
    id_antrian = getUrlParameter('id_antrian') !== undefined ? getUrlParameter('id_antrian') : '';
    nama_pasien = getUrlParameter('nama_pasien') !== undefined ? getUrlParameter('nama_pasien') : '';
    nama_dokter = getUrlParameter('nama_dokter') !== undefined ? getUrlParameter('nama_dokter') : '';
    diagnosa = getUrlParameter('diagnosa') !== undefined ? getUrlParameter('diagnosa') : '';
    tindak_lanjut = getUrlParameter('tindak_lanjut') !== undefined ? getUrlParameter('tindak_lanjut') : '';
    keterangan_tindak_lanjut = getUrlParameter('keterangan_tindak_lanjut') !== undefined ? getUrlParameter('keterangan_tindak_lanjut') : '';
    
    newUrl = baseurl + 'tindakan-medis/addTindakan?langkah=tindakan&id_antrian=' + id_antrian + '&nama_pasien=' + nama_pasien + '&nama_dokter=' + nama_dokter + '&diagnosa=' + diagnosa + '&tindak_lanjut=' + tindak_lanjut + '&keterangan_tindak_lanjut=' + keterangan_tindak_lanjut;

    $('#formInsertTindakan').attr('action', newUrl);
}

var updateUrlForDeleteTindakan = function(id_tindakan_pasien_detail) {
    id_antrian = getUrlParameter('id_antrian');
    nama_pasien = getUrlParameter('nama_pasien');
    nama_dokter = getUrlParameter('nama_dokter');
    diagnosa = getUrlParameter('diagnosa');
    tindak_lanjut = getUrlParameter('tindak_lanjut');
    keterangan_tindak_lanjut = getUrlParameter('keterangan_tindak_lanjut');
    
    newUrl = baseurl + 'tindakan-medis/hapusTindakan?langkah=tindakan&id_antrian=' + id_antrian + '&id_tindakan_pasien_detail=' + id_tindakan_pasien_detail + '&nama_pasien=' + nama_pasien + '&nama_dokter=' + nama_dokter + '&diagnosa=' + diagnosa + '&tindak_lanjut=' + tindak_lanjut + '&keterangan_tindak_lanjut=' + keterangan_tindak_lanjut + '&id_tindakan_pasien_detail=' + id_tindakan_pasien_detail;
    // newUrl = baseurl + 'tindakan-medis/hapusTindakan?;

    $('#aDeleteTindakan').attr('href', newUrl);
    // alert('updateUrlForDeleteTindakan(' + id_tindakan_pasien_detail + ')');
}


/* const delete = async (id) => {
    const response = await fetch();
    const data = await response.json();

    return data;
} */

/* var hapus = function(id) {
    delete(id)
        .then(data => console.log('resolved:', data));
}

const request = new XMLHttpRequest();

request.open('GET') */





const getTodos = (url, callback) => {
    console.log(callback);
    const request = new XMLHttpRequest();

    request.addEventListener('readystatechange', () => {
        if (request.readyState === 4 && request.status === 200) {
            const data = JSON.parse(request.responseText);
            callback(undefined, data);
            console.log(request.responseText);
            // location.reload();
        } else if (request.readyState === 4) {
            callback('could not fetch data', undefined);
        }
    })

    request.open('GET', url);
    request.send();

    // alert('finished');

}



var hapus = function(url) {
    // alert(url);

    if (confirm('Apakah Anda yakin ingin menghapus?')) {
        getTodos(url, (err, data) => {
            console.log('callback fired');
            if (err) {
                console.log('err:', err);
            } else {
                console.log('data:', data);
            }
        });
    }
}
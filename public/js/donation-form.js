var rupiah = document.getElementById("rupiah");
rupiah.addEventListener("keyup", function(e) {
  rupiah.value = formatRupiah(this.value);
});

function formatRupiah(angka, prefix) {
  var number_string = angka.replace(/[^,\d]/g, "").toString(),
    split = number_string.split(","),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);
  
  if (ribuan) {
    separator = sisa ? "." : "";
    rupiah += separator + ribuan.join(".");
  }
  rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
  return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}

const amountInputs = document.querySelectorAll('.amount-input');
const customInput = document.getElementById('rupiah');


customInput.addEventListener('input', () => {
    amountInputs.forEach(radio => radio.checked = false);
});


amountInputs.forEach(radio => {
    radio.addEventListener('change', () => {
        customInput.value = '';
    });
});

// Submit handler with modal popup
function handleDonationSubmit(e) {
    e.preventDefault();
    
    const submitBtn = document.querySelector('.donate-btn');
    submitBtn.innerHTML = 'Memproses...';
    submitBtn.disabled = true;
    
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `
        <div class="modal-content">
            <div class="modal-spinner"></div>
            <p>Memproses donasi...</p>
        </div>
    `;
    document.body.appendChild(modal);
    
    setTimeout(() => {
        modal.innerHTML = `
            <div class="modal-content success">
                <div class="success-icon">✓</div>
                <h2>Donasi Berhasil!</h2>
                <p>Terima kasih atas donasi Anda.</p>
                <p class="success-detail">Donasi Anda akan diproses dalam 1x24 jam.</p>
                <a href="home.html" class="back-home-btn">Kembali ke Beranda</a>
            </div>
        `;
    }, 1500);
}

const form = document.querySelector('.donation-form');
if (form) {
    form.addEventListener('submit', handleDonationSubmit);
}
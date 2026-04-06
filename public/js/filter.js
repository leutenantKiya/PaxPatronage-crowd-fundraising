// province
const provinceData = {
    "aceh": ["Banda Aceh", "Langsa", "Lhokseumawe", "Meulaboh", "Sabang", "Subulussalam", "Bireuen", "Aceh Besar", "Aceh Utara", "Aceh Timur"],
    "sumatera-utara": ["Medan", "Binjai", "Pematang Siantar", "Tebing Tinggi", "Tanjung Balai", "Sibolga", "Padang Sidempuan", "Gunungsitoli", "Deli Serdang", "Simalungun"],
    "sumatera-barat": ["Padang", "Bukittinggi", "Payakumbuh", "Padang Panjang", "Solok", "Sawahlunto", "Pariaman", "Agam", "Tanah Datar", "Pesisir Selatan"],
    "riau": ["Pekanbaru", "Dumai", "Bengkalis", "Kampar", "Siak", "Indragiri Hulu", "Indragiri Hilir", "Rokan Hulu", "Rokan Hilir", "Pelalawan"],
    "jambi": ["Jambi", "Sungai Penuh", "Muaro Jambi", "Batanghari", "Bungo", "Tebo", "Merangin", "Sarolangun", "Tanjung Jabung Barat", "Tanjung Jabung Timur"],
    "sumatera-selatan": ["Palembang", "Prabumulih", "Pagar Alam", "Lubuklinggau", "Ogan Komering Ilir", "Muara Enim", "Banyuasin", "Ogan Ilir", "Lahat", "Musi Rawas"],
    "bengkulu": ["Bengkulu", "Rejang Lebong", "Lebong", "Kepahiang", "Seluma", "Bengkulu Selatan", "Kaur", "Bengkulu Utara", "Bengkulu Tengah", "Mukomuko"],
    "lampung": ["Bandar Lampung", "Metro", "Lampung Selatan", "Lampung Tengah", "Lampung Utara", "Lampung Barat", "Lampung Timur", "Tanggamus", "Way Kanan", "Pringsewu"],
    "kep-bangka-belitung": ["Pangkal Pinang", "Bangka", "Belitung", "Bangka Barat", "Bangka Tengah", "Bangka Selatan", "Belitung Timur"],
    "kep-riau": ["Tanjung Pinang", "Batam", "Bintan", "Karimun", "Natuna", "Lingga", "Anambas"],
    "dki-jakarta": ["Jakarta Pusat", "Jakarta Utara", "Jakarta Barat", "Jakarta Selatan", "Jakarta Timur", "Kepulauan Seribu"],
    "jawa-barat": ["Bandung", "Bogor", "Depok", "Bekasi", "Cimahi", "Tasikmalaya", "Banjar", "Sukabumi", "Cirebon", "Garut", "Karawang", "Subang", "Purwakarta", "Cianjur", "Sumedang"],
    "jawa-tengah": ["Semarang", "Surakarta", "Salatiga", "Pekalongan", "Tegal", "Magelang", "Kudus", "Demak", "Jepara", "Klaten", "Purwokerto", "Cilacap", "Brebes", "Boyolali", "Wonosobo"],
    "di-yogyakarta": ["Yogyakarta", "Sleman", "Bantul", "Gunungkidul", "Kulon Progo"],
    "jawa-timur": ["Surabaya", "Malang", "Kediri", "Blitar", "Madiun", "Mojokerto", "Pasuruan", "Probolinggo", "Batu", "Jember", "Sidoarjo", "Gresik", "Lamongan", "Tuban", "Bojonegoro"],
    "banten": ["Serang", "Tangerang", "Tangerang Selatan", "Cilegon", "Pandeglang", "Lebak"],
    "bali": ["Denpasar", "Badung", "Gianyar", "Tabanan", "Klungkung", "Bangli", "Karangasem", "Buleleng", "Jembrana"],
    "nusa-tenggara-barat": ["Mataram", "Bima", "Lombok Barat", "Lombok Tengah", "Lombok Timur", "Lombok Utara", "Sumbawa", "Sumbawa Barat", "Dompu"],
    "nusa-tenggara-timur": ["Kupang", "Ende", "Flores Timur", "Manggarai", "Manggarai Barat", "Sikka", "Sumba Timur", "Sumba Barat", "Timor Tengah Selatan", "Belu"],
    "kalimantan-barat": ["Pontianak", "Singkawang", "Sambas", "Ketapang", "Sintang", "Kapuas Hulu", "Sanggau", "Landak", "Bengkayang", "Mempawah"],
    "kalimantan-tengah": ["Palangka Raya", "Kotawaringin Barat", "Kotawaringin Timur", "Kapuas", "Barito Selatan", "Barito Utara", "Lamandau", "Seruyan", "Katingan", "Pulang Pisau"],
    "kalimantan-selatan": ["Banjarmasin", "Banjarbaru", "Banjar", "Tanah Laut", "Tapin", "Hulu Sungai Selatan", "Hulu Sungai Tengah", "Hulu Sungai Utara", "Barito Kuala", "Tanah Bumbu"],
    "kalimantan-timur": ["Samarinda", "Balikpapan", "Bontang", "Kutai Kartanegara", "Kutai Barat", "Kutai Timur", "Berau", "Paser", "Penajam Paser Utara", "Mahakam Ulu"],
    "kalimantan-utara": ["Tanjung Selor", "Tarakan", "Bulungan", "Malinau", "Nunukan", "Tana Tidung"],
    "sulawesi-utara": ["Manado", "Bitung", "Tomohon", "Kotamobagu", "Minahasa", "Minahasa Utara", "Minahasa Selatan", "Bolaang Mongondow", "Sangihe", "Talaud"],
    "sulawesi-tengah": ["Palu", "Donggala", "Parigi Moutong", "Poso", "Tojo Una-Una", "Sigi", "Banggai", "Banggai Laut", "Morowali", "Morowali Utara"],
    "sulawesi-selatan": ["Makassar", "Parepare", "Palopo", "Maros", "Gowa", "Takalar", "Bone", "Wajo", "Soppeng", "Bulukumba", "Toraja Utara", "Tana Toraja", "Luwu", "Pangkep", "Pinrang"],
    "sulawesi-tenggara": ["Kendari", "Bau-Bau", "Konawe", "Kolaka", "Muna", "Buton", "Buton Utara", "Wakatobi", "Bombana", "Konawe Selatan"],
    "gorontalo": ["Gorontalo", "Gorontalo Utara", "Pohuwato", "Bone Bolango", "Boalemo"],
    "sulawesi-barat": ["Mamuju", "Majene", "Polewali Mandar", "Mamasa", "Pasangkayu", "Mamuju Tengah"],
    "maluku": ["Ambon", "Tual", "Maluku Tengah", "Seram Bagian Barat", "Seram Bagian Timur", "Buru", "Kepulauan Aru", "Maluku Barat Daya", "Maluku Tenggara", "Maluku Tenggara Barat"],
    "maluku-utara": ["Ternate", "Tidore Kepulauan", "Halmahera Utara", "Halmahera Selatan", "Halmahera Barat", "Halmahera Timur", "Halmahera Tengah", "Kepulauan Sula", "Pulau Morotai", "Pulau Taliabu"],
    "papua": ["Jayapura", "Keerom", "Sarmi", "Mamberamo Raya", "Jayapura Kab", "Yalimo", "Waropen", "Supiori", "Biak Numfor", "Kepulauan Yapen"],
    "papua-barat": ["Manokwari", "Sorong", "Fakfak", "Kaimana", "Teluk Bintuni", "Teluk Wondama", "Manokwari Selatan", "Pegunungan Arfak"],
    "papua-selatan": ["Merauke", "Boven Digoel", "Mappi", "Asmat"],
    "papua-tengah": ["Nabire", "Paniai", "Deiyai", "Dogiyai", "Intan Jaya", "Mimika", "Puncak", "Puncak Jaya"],
    "papua-pegunungan": ["Wamena", "Jayawijaya", "Lanny Jaya", "Mamberamo Tengah", "Nduga", "Tolikara", "Yahukimo", "Yalimo", "Pegunungan Bintang"],
    "papua-barat-daya": ["Sorong Selatan", "Maybrat", "Raja Ampat", "Tambrauw"]
};

// select cities based on province
function updateCities() {
    const provinsiSelect = document.getElementById('filter-provinsi');
    const kotaSelect = document.getElementById('filter-kota');
    const selectedProvince = provinsiSelect.value;

    // Clear current city options
    kotaSelect.innerHTML = '<option value="">-- Pilih Kota --</option>';

    if (selectedProvince && provinceData[selectedProvince]) {
        // activate
        kotaSelect.disabled = false;
        const cities = provinceData[selectedProvince];
        cities.forEach(city => {
            const option = document.createElement('option');
            option.value = city.toLowerCase().replace(/\s+/g, '-');
            option.textContent = city;
            kotaSelect.appendChild(option);
        });

        // Animate the city dropdown to draw attention
        kotaSelect.style.borderColor = '#38bdf8';
        kotaSelect.style.boxShadow = '0 0 0 3px rgba(56, 189, 248, 0.15)';
        setTimeout(() => {
            kotaSelect.style.borderColor = '';
            kotaSelect.style.boxShadow = '';
        }, 800);
    } else {
        kotaSelect.disabled = true;
    }
}

function resetFilter() {
    document.getElementById('filter-search').value = '';

    document.querySelectorAll('#filter-kategori-group input[type="checkbox"]').forEach(cb => {
        cb.checked = false;
    });

    document.getElementById('filter-provinsi').value = '';
    const kotaSelect = document.getElementById('filter-kota');
    kotaSelect.value = '';
    kotaSelect.innerHTML = '<option value="">-- Pilih Kota --</option>';
    kotaSelect.disabled = true;

    document.getElementById('filter-target-dana').value = '';

    const fundingContent = document.getElementById('funding-content');
    if (fundingContent) {
        const cards = fundingContent.querySelectorAll('.funding-card');
        cards.forEach(card => {
            card.style.display = '';
        });
        const noResults = document.getElementById('no-results');
        if (noResults) {
            noResults.style.display = 'none';
        }
    }

    const btn = document.getElementById('btn-reset-filter');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span>✓ Direset</span>';
    btn.style.borderColor = '#86efac';
    btn.style.color = '#059669';
    btn.style.background = '#f0fdf4';
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.style.borderColor = '';
        btn.style.color = '';
        btn.style.background = '';
    }, 1000);
}

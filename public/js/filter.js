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
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.value = '';
    }

    document.querySelectorAll('#filter-kategori-group input[type="checkbox"]').forEach(cb => {
        cb.checked = false;
    });

    const provinsiSelect = document.getElementById('filter-provinsi');
    if (provinsiSelect) {
        provinsiSelect.value = '';
    }

    const kotaSelect = document.getElementById('filter-kota');
    if (kotaSelect) {
        kotaSelect.value = '';
        kotaSelect.innerHTML = '<option value="">-- Pilih Kota --</option>';
        kotaSelect.disabled = true;
    }

    const targetDana = document.getElementById('filter-target-dana');
    if (targetDana) {
        targetDana.value = '';
    }

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
    if (btn) {
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
}

function applyFilter() {
    console.log("Menerapkan filter...");
    
    const selectedCategories = Array.from(document.querySelectorAll('#filter-kategori-group input[type="checkbox"]:checked')).map(cb => cb.value);
    const selectedProvince = document.getElementById('filter-provinsi').value;
    const selectedCity = document.getElementById('filter-kota').value;
    const selectedTarget = document.getElementById('filter-target-dana').value.split('-');
    const minTarget = parseInt(selectedTarget[0]);
    const maxTarget = parseInt(selectedTarget) || Infinity;
    console.log(selectedCategories);
    console.log(selectedProvince);
    console.log(selectedCity);
    console.log(selectedTarget);
    
    const cards = document.querySelectorAll('.funding-card');
    
    cards.forEach(card => {
        let isVisible = true;
        
        // Range filter
        if(selectedTarget){
            const cardTarget = card.querySelector('.amount-target');
            const amount = parseFloat(cardTarget.getAttribute('amount-target'));
            if (amount < minTarget || amount > maxTarget) {
                isVisible = false;
            }
        }

        // Category filter
        if (selectedCategories.length > 0) {
            const cardCategory = card.getAttribute('data-category');
            if (!selectedCategories.includes(cardCategory)) {
                isVisible = false;
            }
        }
        
        // Province filter
        if (selectedProvince && isVisible) {
            const cardProvince = card.getAttribute('data-province');
            if (cardProvince !== selectedProvince) {
                isVisible = false;
            }
        }
        
        // City filter
        if (selectedCity && isVisible) {
            const cardCity = card.getAttribute('data-city');
            if (cardCity !== selectedCity) {
                isVisible = false;
            }
        }
        
        card.style.display = isVisible ? '' : 'none';
    });
}


// autocomplete search + card filtering
(function () {
    const searchInput = document.getElementById('search-input');
    const suggestionsEl = document.getElementById('search-suggestions');
    if (!searchInput || !suggestionsEl) return;

    let debounceTimer = null;

    // Cek apakah query cocok dengan salah satu field kampanye
    function matchKampanye(k, val) {
        if (k.nama_kampanye.toLowerCase().includes(val)) return 'nama';
        if (k.jenis_kampanye.toLowerCase().includes(val)) return 'kategori';
        if (k.provinsi.toLowerCase().includes(val)) return 'provinsi';
        if (k.kota.toLowerCase().includes(val)) return 'kota';
        return null;
    }

    // Highlight bagian teks yang cocok
    function highlightMatch(text, query) {
        if (!query) return escapeHtml(text);
        const escaped = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const regex = new RegExp(`(${escaped})`, 'gi');
        return escapeHtml(text).replace(regex, '<mark>$1</mark>');
    }

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // Label match type untuk ditampilkan di suggestion
    function matchLabel(type, item, query) {
        switch (type) {
            case 'kategori':  return `Kategori: ${highlightMatch(item.jenis_kampanye, query)}`;
            case 'provinsi':  return `Lokasi: ${highlightMatch(item.provinsi, query)}`;
            case 'kota':      return `Lokasi: ${highlightMatch(item.kota, query)}`;
            default:          return escapeHtml(item.jenis_kampanye);
        }
    }

    // Render daftar suggestion
    function renderSuggestions(items, query) {
        suggestionsEl.innerHTML = '';
        if (items.length === 0) {
            suggestionsEl.classList.remove('open');
            return;
        }

        items.forEach(({ item, matchType }) => {
            const li = document.createElement('li');
            li.className = 'suggestion-item';
            li.dataset.id = item.id;
            li.innerHTML = `
                <img src="${escapeHtml(item.path_gambar)}" alt="" class="suggestion-img"
                     onerror="this.src='upload/example-detail.png'">
                <div class="suggestion-text">
                    <span class="suggestion-name">${highlightMatch(item.nama_kampanye, matchType === 'nama' ? query : '')}</span>
                    <span class="suggestion-category">${matchLabel(matchType, item, query)}</span>
                </div>
            `;
            li.addEventListener('click', () => {
                window.location.href = `detail.html?id=${item.id}`;
            });
            suggestionsEl.appendChild(li);
        });

        suggestionsEl.classList.add('open');
    }

    // Filter data berdasarkan input (untuk suggestion dropdown)
    function doSearch() {
        const val = searchInput.value.trim().toLowerCase();
        if (val === '' || val.length < 2) {
            suggestionsEl.classList.remove('open');
            suggestionsEl.innerHTML = '';
            return;
        }

        const data = typeof datakampanye !== 'undefined' ? datakampanye : [];
        const filtered = [];
        for (const k of data) {
            const matchType = matchKampanye(k, val);
            if (matchType) {
                filtered.push({ item: k, matchType });
                if (filtered.length >= 8) break;
            }
        }

        renderSuggestions(filtered, val);
    }

    // Filter cards di halaman home (dipanggil saat Enter / klik tombol cari)
    function executeSearch() {
        const val = searchInput.value.trim().toLowerCase();
        suggestionsEl.classList.remove('open');
        suggestionsEl.innerHTML = '';

        const cards = document.querySelectorAll('.funding-card');
        const fundingContent = document.getElementById('funding-content');
        let visibleCount = 0;

        cards.forEach(card => {
            if (val === '') {
                // Kosong = tampilkan semua
                card.style.display = '';
                visibleCount++;
                return;
            }

            const title    = (card.querySelector('.card-title')?.textContent || '').toLowerCase();
            const category = (card.getAttribute('data-category') || '').replace(/-/g, ' ');
            const badge    = (card.querySelector('.category-badge')?.textContent || '').toLowerCase();
            const province = (card.getAttribute('data-province') || '').replace(/-/g, ' ');
            const city     = (card.getAttribute('data-city') || '').replace(/-/g, ' ');

            const isMatch = title.includes(val)
                         || category.includes(val)
                         || badge.includes(val)
                         || province.includes(val)
                         || city.includes(val);

            card.style.display = isMatch ? '' : 'none';
            if (isMatch) visibleCount++;
        });

        // Tampilkan / sembunyikan pesan "tidak ditemukan"
        let noResults = document.getElementById('no-results');
        if (visibleCount === 0 && val !== '') {
            if (!noResults && fundingContent) {
                noResults = document.createElement('p');
                noResults.id = 'no-results';
                noResults.className = 'empty-state';
                noResults.textContent = 'Tidak ada kampanye yang cocok dengan pencarian.';
                fundingContent.appendChild(noResults);
            }
            if (noResults) noResults.style.display = '';
        } else if (noResults) {
            noResults.style.display = 'none';
        }

        // Scroll ke area cards
        if (fundingContent && val !== '') {
            fundingContent.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    // Debounced input listener (250ms) — untuk suggestion dropdown
    searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(doSearch, 250);
    });

    // Tutup suggestions kalau klik di luar
    document.addEventListener('click', (e) => {
        if (!suggestionsEl.contains(e.target) && e.target !== searchInput) {
            suggestionsEl.classList.remove('open');
        }
    });

    // Keyboard navigation
    searchInput.addEventListener('keydown', (e) => {
        const items = suggestionsEl.querySelectorAll('.suggestion-item');
        const active = suggestionsEl.querySelector('.suggestion-item.active');
        let idx = Array.from(items).indexOf(active);

        if (e.key === 'ArrowDown' && items.length > 0) {
            e.preventDefault();
            if (active) active.classList.remove('active');
            idx = (idx + 1) % items.length;
            items[idx].classList.add('active');
            items[idx].scrollIntoView({ block: 'nearest' });
        } else if (e.key === 'ArrowUp' && items.length > 0) {
            e.preventDefault();
            if (active) active.classList.remove('active');
            idx = (idx - 1 + items.length) % items.length;
            items[idx].classList.add('active');
            items[idx].scrollIntoView({ block: 'nearest' });
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (active) {
                // Kalau ada suggestion yang di-highlight, langsung ke detail
                active.click();
            } else {
                // Kalau tidak, filter cards di halaman
                executeSearch();
            }
        } else if (e.key === 'Escape') {
            suggestionsEl.classList.remove('open');
        }
    });

    // Expose executeSearch untuk dipanggil dari tombol cari (kalau ada)
    window.executeSearch = executeSearch;
})();

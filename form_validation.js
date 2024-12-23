function validateName() {
    const nameInput = document.getElementById('name');
    const nameValue = nameInput.value;
    const nameError = document.getElementById('nameError');
    if (!/^[a-zA-Z\s]+$/.test(nameValue)) {
        nameError.textContent = "Nama hanya boleh berisi huruf!";
        return false;
    } else {
        nameError.textContent = "";
        return true;
    }
}

function validatePhone() {
    const phoneInput = document.getElementById('phone');
    const phoneValue = phoneInput.value;
    const phoneError = document.getElementById('phoneError');
    if (!/^\d{10,15}$/.test(phoneValue)) {
        phoneError.textContent = "Nomor HP harus terdiri dari 10-15 angka!";
        return false;
    } else {
        phoneError.textContent = "";
        return true;
    }

}

function validateForm(event) {
    const isNameValid = validateName();
    const isPhoneValid = validatePhone();
    if (!isNameValid || !isPhoneValid) {
        event.preventDefault(); // Mencegah pengiriman form jika ada kesalahan
    }
}

// Mengambil status tabel dari localStorage saat halaman dimuat
window.onload = function() {
    const storedStatus = localStorage.getItem('tabel_status');
    if (storedStatus) {
        document.cookie = 'tabel_status=' + storedStatus + '; path=/';
    }
};
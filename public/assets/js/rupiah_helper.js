// Fungsi menambahkan titik pada input angka (lanjutan dari fungsi numberonly)
function tandaPemisahTitik(b) {
  var _minus = false;
  if (b < 0) _minus = true;
  b = b.toString();
  b = b.replace(".", "");
  b = b.replace("-", "");
  c = "";
  panjang = b.length;
  j = 0;
  for (i = panjang; i > 0; i--) {
    j = j + 1;
    if (j % 3 == 1 && j != 1) {
      c = b.substr(i - 1, 1) + "." + c;
    } else {
      c = b.substr(i - 1, 1) + c;
    }
  }
  if (_minus) c = "-" + c;
  return c;
}

// Fungsi input data hanya angka
function numbersonly(ini, e) {
  if (e.keyCode >= 49) {
    if (e.keyCode <= 57) {
      a = ini.value.toString().replace(".", "");
      b = a.replace(/[^\d]/g, "");
      b =
        b == "0"
          ? String.fromCharCode(e.keyCode)
          : b + String.fromCharCode(e.keyCode);
      ini.value = tandaPemisahTitik(b);
      return false;
    } else if (e.keyCode <= 105) {
      if (e.keyCode >= 96) {
        //e.keycode = e.keycode - 47;
        a = ini.value.toString().replace(".", "");
        b = a.replace(/[^\d]/g, "");
        b =
          b == "0"
            ? String.fromCharCode(e.keyCode - 48)
            : b + String.fromCharCode(e.keyCode - 48);
        ini.value = tandaPemisahTitik(b);
        //alert(e.keycode);
        return false;
      } else {
        return false;
      }
    } else {
      return false;
    }
  } else if (e.keyCode == 48) {
    a = ini.value.replace(".", "") + String.fromCharCode(e.keyCode);
    b = a.replace(/[^\d]/g, "");
    if (parseFloat(b) != 0) {
      ini.value = tandaPemisahTitik(b);
      return false;
    } else {
      return false;
    }
  } else if (e.keyCode == 95) {
    a = ini.value.replace(".", "") + String.fromCharCode(e.keyCode - 48);
    b = a.replace(/[^\d]/g, "");
    if (parseFloat(b) != 0) {
      ini.value = tandaPemisahTitik(b);
      return false;
    } else {
      return false;
    }
  } else if (e.keyCode == 8 || e.keycode == 46) {
    a = ini.value.replace(".", "");
    b = a.replace(/[^\d]/g, "");
    b = b.substr(0, b.length - 1);
    if (tandaPemisahTitik(b) != "") {
      ini.value = tandaPemisahTitik(b);
    } else {
      ini.value = "";
    }
    return false;
  } else if (e.keyCode == 9) {
    return true;
  } else if (e.keyCode == 17) {
    return true;
  } else {
    alert(e.keyCode);
    return false;
  }
}

// Versi 2
function formatRupiah(input) {
  // Hapus semua karakter non-digit
  let number = input.replace(/\D/g, "");

  // Jika kosong, kembalikan string kosong
  if (number === "") {
    return "";
  }

  // Ubah ke number untuk memastikan leading zero dihapus
  number = parseInt(number, 10);

  // Format number dengan pemisah titik
  return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

const toIDR = document.getElementById("toIDR");

toIDR.addEventListener("input", function (e) {
  let cursorPosition = this.selectionStart;
  let originalLength = this.value.length;
  let formattedValue = formatRupiah(this.value);

  this.value = formattedValue;

  // Sesuaikan posisi kursor
  let newLength = formattedValue.length;
  cursorPosition += newLength - originalLength;
  this.setSelectionRange(cursorPosition, cursorPosition);
});

toIDR.addEventListener("keypress", function (e) {
  // Cek apakah karakter yang dimasukkan adalah angka
  if (!/^\d$/.test(e.key)) {
    e.preventDefault();
  }
});

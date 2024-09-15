Parsley.options.successClass = "is-valid";
Parsley.options.errorClass = "is-invalid text-danger";
Parsley.options.errorsWrapper =
  '<div class="mt-2 text-danger text-capitalize d-flex flex-column gap-1"></div>';
Parsley.options.errorTemplate = "<span></span>";
Parsley.options.trigger = "change";

window.Parsley.addValidator("maxFileSize", {
  validateString: function (_value, maxSize, parsleyInstance) {
    if (!window.FormData) {
      alert(
        "You are making all developpers in the world cringe. Upgrade your browser!"
      );
      return true;
    }
    var files = parsleyInstance.$element[0].files;
    return files.length != 1 || files[0].size <= maxSize * 1024;
  },
  requirementType: "integer",
  messages: {
    id: "File ini tidak boleh lebih besar dari %s Kb",
    en: "This file should not be larger than %s Kb",
    fr: "Ce fichier est plus grand que %s Kb.",
  },
});

// Custom Parsley Validator for MIME Type
window.Parsley.addValidator("mimeType", {
  requirementType: "string",
  validateString: function (value, requirement, parsleyInstance) {
    // Get the uploaded file
    var file = parsleyInstance.$element[0].files[0];
    if (!file) {
      return false; // No file selected, validation fails
    }

    // Get the file's MIME type
    var fileType = file.type;

    // Split requirement into an array (comma-separated)
    var allowedTypes = requirement.split(",");

    // Check if the file's MIME type is allowed
    return allowedTypes.includes(fileType);
  },
  messages: {
    en: "Invalid format file",
    id: "Format file tidak didukung.",
  },
});

window.Parsley.addValidator("imageDimensions", {
  requirementType: "string",
  validateString: function (value, requirement, parsleyInstance) {
    let file = parsleyInstance.$element[0].files[0];
    let [width, height] = requirement.split("x");

    let image = new Image();

    image.src = window.URL.createObjectURL(file);
    image.onchange = function () {
      return image.width >= width && image.height >= height;
    };
  },
  messages: {
    id: "Dimensi gambar tidak valid",
    en: "Image dimensions have to be at least  %s px",
  },
});

//has uppercase
window.Parsley.addValidator("uppercase", {
  requirementType: "number",
  validateString: function (value, requirement) {
    var uppercases = value.match(/[A-Z]/g) || [];
    return uppercases.length >= requirement;
  },
  messages: {
    id: "Kata sandi Anda harus mengandung setidaknya (%s) huruf besar.",
    en: "Your password must contain at least (%s) uppercase letter.",
  },
});

//has lowercase
window.Parsley.addValidator("lowercase", {
  requirementType: "number",
  validateString: function (value, requirement) {
    var lowecases = value.match(/[a-z]/g) || [];
    return lowecases.length >= requirement;
  },
  messages: {
    id: "",
    en: "Kata sandi Anda harus mengandung setidaknya (%s) huruf kecil.",
  },
});

//has number
window.Parsley.addValidator("number", {
  requirementType: "number",
  validateString: function (value, requirement) {
    var numbers = value.match(/[0-9]/g) || [];
    return numbers.length >= requirement;
  },
  messages: {
    id: "Kata sandi Anda harus mengandung setidaknya (%s) angka.",
    en: "Your password must contain at least (%s) number.",
  },
});

//has special char
window.Parsley.addValidator("special", {
  requirementType: "number",
  validateString: function (value, requirement) {
    var specials = value.match(/[^a-zA-Z0-9]/g) || [];
    return specials.length >= requirement;
  },
  messages: {
    id: "Kata sandi Anda harus mengandung setidaknya (%s) karakter khusus.",
    en: "Your password must contain at least (%s) special characters.",
  },
});

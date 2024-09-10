let watchID = null;

function getLocation() {
  if (navigator.geolocation) {
    let options = {
      enableHighAccuracy: true,
      // timeout: 5000,
      // maximumAge: 0,
      distanceFilter: 1,
      // desiredAccuracy: 0,
      // frequency: 1,
    };
    watchID = navigator.geolocation.watchPosition(
      showPosition,
      showError,
      options
    );
  } else {
    console.error("Geolocation is not supported by this browser.");
  }
}

function showError(error) {
  switch (error.code) {
    case error.PERMISSION_DENIED:
      console.error(
        "Lokasi tidak dizinkan oleh pengguna, geolokasi tidak akan berfungsi. Klik OK untuk melanjutkan"
      );
      break;
    case error.POSITION_UNAVAILABLE:
      console.error("Location information is unavailable.");
      break;
    case error.TIMEOUT:
      console.error("The request to get user location timed out.");
      break;
    case error.UNKNOWN_ERROR:
      console.error("An unknown error occurred.");
      break;
  }
}

function showPosition(position) {
  let lat = position?.coords?.latitude;
  let long = position?.coords?.longitude;

  if (lat !== undefined) {
    const data = {
      lat,
      long,
      timestamp: position?.timestamp,
    };
    return localStorage.setItem("location", JSON.stringify(data));
  }
}

// clear the watch that was started earlier
function clearWatch() {
  if (watchID != null) {
    navigator.geolocation.clearWatch(watchID);
    watchID = null;
  }
}

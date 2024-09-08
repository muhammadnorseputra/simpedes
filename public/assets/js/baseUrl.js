// Uri Segement
var $host = window.location.origin == "http://localhost";
if ($host || window.location.origin == "https://bkpsdm.balangankab.go.id") {
  var origin = `${window.location.origin}/simpedes`;
} else {
  var origin = `${window.location.origin}`;
}
var segment = window.location.pathname.split("/");
// Params
var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);

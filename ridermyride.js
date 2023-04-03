$(function () {
  var data;
  var ride;
  var geocoder = new google.maps.Geocoder();

  getRides();

  function getRides() {
    $.ajax({
      url: "getRiderMyRides.php",
      success: function (data2) {
        $("#ridelist").html(data2);
        $("#ridelist").hide();
        $("#ridelist").fadeIn();
        setEvtListeners();
      },
      error: function () {
        $("#ridelist").html(
          "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
        );
        $("#ridelist").hide();
        $("#ridelist").fadeIn();
      },
    });
  }

  function setEvtListeners() {
    let editId = null;
    $("[id*='cancelride']").click(function (evt) {
      $.ajax({
        url: "riderCancelRide.php",
        method: "POST",
        data: { ride_id: evt.target.getAttribute("data-ride_id") },
        success: function () {
          location.reload();
        },
        error: function () {
          $("#ridelist").html(
            "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
          );
          $("#ridelist").hide();
          $("#ridelist").fadeIn();
        },
      });
    });
  }
});

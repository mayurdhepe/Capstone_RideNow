$(function () {
  var data;
  var ride;

  getRides();

  $("#formAddRide").submit(function (event) {
    $("#result").hide();
    event.preventDefault();
    data = $("#formAddRide").serializeArray();
    submitAddTripRequest();
  });

  $('input[name="date"]').datepicker({
    showAnim: "fadeIn",
    numberOfMonths: 1,
    dateFormat: "D d M, yy",
    minDate: +1,
    maxDate: "+12M",
    showWeek: true,
  });

  function submitAddTripRequest() {
    console.log(data);
    $.ajax({
      url: "addRide.php",
      data: data,
      type: "POST",
      success: function (data2) {
        console.log(data);
        if (data2) {
          $("#result").html(data2);
          $("#result").slideDown();
        } else {
          getRides();
          $("#result").hide();
          $("#rideAddModal").modal("hide");
          //empty form
          $("#formAddRide")[0].reset();
        }
      },
      error: function () {
        $("#result").html(
          "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
        );
        $("#result").fadeIn();
      },
    });
  }

  function getRides() {
    $.ajax({
      url: "getRides.php",
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
    $("[id*='deletetrip']").click(function (evt) {
      $.ajax({
        url: "deleteRide.php",
        method: "POST",
        data: { ride_id: evt.target.getAttribute("data-ride_id") },
        success: function () {
          location.reload();
        },
        error: function () {
          $("#result2").html(
            "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
          );
          $("#result2").hide();
          $("#result2").fadeIn();
        },
      });
    });
  }

  function formatModal() {
    $("#departure2").val(ride["departure"]);
    $("#destination2").val(ride["destination"]);
    $("#price2").val(ride["price"]);
    $("#seatsavailable2").val(ride["seatsavailable"]);
    if (ride["regular"] == "Y") {
      $("#yes2").prop("checked", true);
      $('input[name="time2"]').val(ride["time"]);
      $(".oneoff2").hide();
      $(".regular2").show();
    } else {
      $("#no2").prop("checked", true);
      $('input[name="date2"]').val(ride["date"]);
      $('input[name="time2"]').val(ride["time"]);
      $(".regular2").hide();
      $(".oneoff2").show();
    }
  }
});

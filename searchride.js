$(function () {
  var data;
  var ride;
  var geocoder = new google.maps.Geocoder();

  var input1 = document.getElementById("departure");
  var input2 = document.getElementById("destination");
  var input3 = document.getElementById("dropwdownsort");
  var autocomplete1 = new google.maps.places.Autocomplete(input1);
  var autocomplete2 = new google.maps.places.Autocomplete(input2);

  // getRides();

  document.getElementById("sortsearchrides").style.display = "none";

  function getFilteredRides() {
    $.ajax({
      url: "getSearchRide.php",
      method: "POST",
      data: data,
      success: function (data) {
        document.getElementById("sortsearchrides").style.display = "block";
        $("#ridelist").html(data);
        $("#ridelist").hide();
        $("#ridelist").fadeIn();
        setEvtListeners();
      },
      error: function (data) {
        $("#ridelist").html(
          "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
        );
        $("#ridelist").hide();
        $("#ridelist").fadeIn();
      },
    });
  }

  $("[id*='searchRide']").click(function (evt) {
    data = $("#formsearchrides").serializeArray();
    data.push({ name: "filtered_search", value: 1 });
    data.push({ name: "departure", value: input1.value });
    data.push({ name: "destination", value: input2.value });
    getAddTripDepartureCoordinates();
  });

  $("[id='sortRides']").click(function (evt) {
    data = $("#formsearchrides").serializeArray();
    data.push({ name: "filtered_search", value: 1 });
    data.push({ name: "departure", value: input1.value });
    data.push({ name: "destination", value: input2.value });
    data.push({ name: "sort", value: input3.value });
    getAddTripDepartureCoordinates();
  });

  function getRides() {
    $.ajax({
      url: "getSearchRide.php",
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
    $("[id*='joinride']").click(function (evt) {
      $.ajax({
        url: "joinRide.php",
        method: "POST",
        data: { ride_id: evt.target.getAttribute("data-ride_id") },
        success: function () {
          //location.reload();
          window.location = "riderMyRides.php";
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

    $("[id*='viewDriverButton']").click(function (evt) {
      rateId = evt.target.getAttribute("data-ride_id");
      $("#driverView").html("");
      $.ajax({
        url: "getdriverforviewing.php",
        method: "POST",
        data: { ride_id: evt.target.getAttribute("data-ride_id") },
        success: function (data2) {
          $("#driverView").html(data2);
          $("#driverView").hide();
          $("#driverView").fadeIn();
        },
        error: function () {
          $("#driverView").html(
            "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
          );
          $("#driverView").hide();
          $("#driverView").fadeIn();
        },
      });
    });
  }

  function getAddTripDepartureCoordinates() {
    geocoder.geocode(
      {
        address: document.getElementById("departure").value,
      },
      function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          departureLongitude = results[0].geometry.location.lng();
          departureLatitude = results[0].geometry.location.lat();
          data.push({ name: "departureLongitude", value: departureLongitude });
          data.push({ name: "departureLatitude", value: departureLatitude });
          getAddTripDestinationCoordinates();
        } else {
          getAddTripDestinationCoordinates();
        }
      }
    );
  }

  function getAddTripDestinationCoordinates() {
    geocoder.geocode(
      {
        address: document.getElementById("destination").value,
      },
      function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          destinationLongitude = results[0].geometry.location.lng();
          destinationLatitude = results[0].geometry.location.lat();
          data.push({
            name: "destinationLongitude",
            value: destinationLongitude,
          });
          data.push({
            name: "destinationLatitude",
            value: destinationLatitude,
          });
          getFilteredRides();
        } else {
          getFilteredRides();
        }
      }
    );
  }
});

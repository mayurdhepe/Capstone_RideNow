$(function () {
  var data;
  var ride;
  var geocoder = new google.maps.Geocoder();

  let rideDistance = 0;

  var myLatLng = { lat: 37.229, lng: -80.4139 };
  var mapOptions = {
    center: myLatLng,
    zoom: 15,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
  };
  var input3 = document.getElementById("departure2");
  var input4 = document.getElementById("destination2");
  var options = {
    // types: ["(cities)"],
  };
  var autocomplete3 = new google.maps.places.Autocomplete(input3, options);
  var autocomplete4 = new google.maps.places.Autocomplete(input4, options);

  var directionsService = new google.maps.DirectionsService();

  google.maps.event.addDomListener(window, "load", initialize);

  function initialize() {
    directionsDisplay2 = new google.maps.DirectionsRenderer();
    map2 = new google.maps.Map(
      document.getElementById("googleMap2"),
      mapOptions
    );
    directionsDisplay2.setMap(map2);
  }

  google.maps.event.addListener(autocomplete3, "place_changed", calcRoute2);
  google.maps.event.addListener(autocomplete4, "place_changed", calcRoute2);

  function calcRoute2() {
    console.log("calcRoute2");
    var start = $("#departure2").val();
    var end = $("#destination2").val();
    var request = {
      origin: start,
      destination: end,
      travelMode: google.maps.DirectionsTravelMode.DRIVING,
      unitSystem: google.maps.UnitSystem.IMPERIAL,
      durationInTraffic: false,
      avoidHighways: false,
      avoidTolls: false,
    };
    if (start && end) {
      directionsService.route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
          directionsDisplay2.setDirections(response);
          let dist = parseInt(
            response["routes"][0]["legs"][0]["distance"]["text"].split(" ")[0]
          );
          rideDistance = dist;
          console.log(rideDistance);
          let recommendedprice = parseInt(dist * 0.25);
          if (recommendedprice < 5) recommendedprice = 5;
          document.getElementById("recommendedprice2").innerText =
            "Recommended Price : $" + recommendedprice;
        } else {
          initialize();
        }
      });
    }
  }

  getRides();

  $("#formAddRide").submit(function (event) {
    $("#result").hide();
    event.preventDefault();
    data = $("#formAddRide").serializeArray();
    // submitAddTripRequest();
    getAddTripDepartureCoordinates();
  });

  $('input[name="date"]').datepicker({
    showAnim: "fadeIn",
    numberOfMonths: 1,
    dateFormat: "D d M, yy",
    minDate: +1,
    maxDate: "+12M",
    showWeek: true,
  });

  $('input[name="date2"]').datepicker({
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

  function editRide() {
    console.log("inside editride()" + data);
    $.ajax({
      url: "editRide.php",
      data: data,
      type: "POST",
      success: function (data2) {
        console.log(data2);
        if (data2) {
          $("#result2").html(data2);
          $("#result2").slideDown();
          $("#editrideform")[0].reset();
        } else {
          getRides();
          $("#result2").hide();
          $("#editrideModal").modal("hide");
          //empty form
          $("#editrideform")[0].reset();
        }
      },
      error: function () {
        $("#result2").html(
          "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
        );
        $("#result2").fadeIn();
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

  let editId = null;
  function setEvtListeners() {
    $("[id*='edittrip']").click(function (evt) {
      editId = evt.target.getAttribute("data-ride_id");
      $("#result2").html("");
      $.ajax({
        url: "getridedetails.php",
        method: "POST",
        data: {
          ride_id: evt.target.getAttribute("data-ride_id"),
        },
        success: function (data2) {
          ride = JSON.parse(data2);
          //fill edit trip form inputs using AJAX returned JSON data
          formatModal();
          calcRoute2();
        },
        error: function () {
          $("#result2").html(
            "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
          );
          $("#result2").hide();
          $("#result2").fadeIn();
        },
      });

      // Click on Edit Trip Button
    });

    $("#editrideform").submit(function (event) {
      $("#result2").hide();
      event.preventDefault();
      data = null;
      data = $("#editrideform").serializeArray();
      data.push({
        name: "ride_id",
        value: editId,
      });
      data.push({ name: "distance", value: rideDistance });

      console.log("edit clicked - " + editId);
      editId = null;
      editRide();
    });

    $("[id*='deletetrip']").click(function (evt) {
      $.ajax({
        url: "deleteRide.php",
        method: "POST",
        data: { ride_id: evt.target.getAttribute("data-ride_id") },
        success: function (data2) {
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

    $("[id*='starttrip']").click(function (evt) {
      $.ajax({
        url: "startride.php",
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

    $("[id*='endtrip']").click(function (evt) {
      $.ajax({
        url: "endride.php",
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

    $("[id*='rateButton']").click(function (evt) {
      rateId = evt.target.getAttribute("data-ride_id");
      $("#ridersListRating").html("");
      $.ajax({
        url: "getriderforrating.php",
        method: "POST",
        data: { ride_id: evt.target.getAttribute("data-ride_id") },
        success: function (data2) {
          $("#ridersListRating").html(data2);
          $("#ridersListRating").hide();
          $("#ridersListRating").fadeIn();

          const ratingStars = [
            ...document.getElementsByClassName("rating__star"),
          ];

          function executeRating(stars) {
            const starClassActive = "rating__star fas fa-star fa-xl";
            const starClassInactive = "rating__star far fa-star fa-xl";
            const starsLength = stars.length;
            let i;
            stars.map((star) => {
              star.onclick = (currEvt) => {
                i = stars.indexOf(star);
                console.log(i);
                let clickedIdx = i;

                if (star.className === starClassInactive) {
                  for (i; i >= Math.floor(clickedIdx / 5) * 5; --i)
                    stars[i].className = starClassActive;
                } else {
                  for (i = i + 1; i < Math.floor(clickedIdx / 5) * 5 + 5; ++i)
                    stars[i].className = starClassInactive;
                }

                $.ajax({
                  url: "rateRider.php",
                  method: "POST",
                  data: {
                    ride_id: currEvt.target.getAttribute("ride-id"),
                    rider_id: currEvt.target.getAttribute("rider-id"),
                    rating: (clickedIdx % 5) + 1,
                  },
                  success: function (data2) {
                    // alert(data2);
                  },
                  error: function () {
                    // $("#result2").html(
                    //   "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
                    // );
                    // $("#result2").hide();
                    // $("#result2").fadeIn();
                  },
                });
              };
            });
          }
          executeRating(ratingStars);
        },
        error: function () {
          $("#ridersListRating").html(
            "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
          );
          $("#ridersListRating").hide();
          $("#ridersListRating").fadeIn();
        },
      });
    });

    $("[id*='viewRidersButton']").click(function (evt) {
      rateId = evt.target.getAttribute("data-ride_id");
      $("#ridersList").html("");
      $.ajax({
        url: "getriderforviewing.php",
        method: "POST",
        data: { ride_id: evt.target.getAttribute("data-ride_id") },
        success: function (data2) {
          $("#ridersList").html(data2);
          $("#ridersList").hide();
          $("#ridersList").fadeIn();
        },
        error: function () {
          $("#ridersList").html(
            "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
          );
          $("#ridersList").hide();
          $("#ridersList").fadeIn();
        },
      });
    });
  }

 


  function formatModal() {
    $("#departure2").val(ride["departure"]);
    $("#destination2").val(ride["destination"]);
    $("#price2").val(ride["price"]);
    $("#seatsavailable2").val(ride["capacity"]);
    $('input[name="date2"]').val(ride["date"]);
    $('input[name="time2"]').val(ride["time"]);
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
          data.push({
            name: "distance",
            value: parseInt(document.getElementById("dist").innerText),
          });
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
          submitAddTripRequest();
        } else {
          submitAddTripRequest();
        }
      }
    );
  }
});

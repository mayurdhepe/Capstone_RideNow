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
        success: function (data2) {
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

    $("[id*='rateButton']").click(function (evt) {
      rateId = evt.target.getAttribute("data-ride_id");
      $("#driverRating").html("");
      $.ajax({
        url: "getdriverforrating.php",
        method: "POST",
        data: { ride_id: evt.target.getAttribute("data-ride_id") },
        success: function (data2) {
          $("#driverRating").html(data2);
          $("#driverRating").hide();
          $("#driverRating").fadeIn();

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
                  url: "rateDriver.php",
                  method: "POST",
                  data: {
                    ride_id: currEvt.target.getAttribute("ride-id"),
                    rider_id: currEvt.target.getAttribute("rider-id"),
                    rating: (clickedIdx % 5) + 1,
                  },
                  success: function (data2) {},
                  error: function () {},
                });
              };
            });
          }
          executeRating(ratingStars);
        },
        error: function () {
          $("#driverRating").html(
            "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
          );
          $("#driverRating").hide();
          $("#driverRating").fadeIn();
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
});

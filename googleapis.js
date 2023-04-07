$(function () {
  //set map options
  var myLatLng = { lat: 37.229, lng: -80.4139 };
  var mapOptions = {
    center: myLatLng,
    zoom: 15,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
  };

  //create autocomplete objects
  var input1 = document.getElementById("departure");
  var input2 = document.getElementById("destination");
  // var input3 = document.getElementById("departure2");
  // var input4 = document.getElementById("destination2");
  var options = {
    // types: ["(cities)"],
  };
  var autocomplete1 = new google.maps.places.Autocomplete(input1, options);
  var autocomplete2 = new google.maps.places.Autocomplete(input2, options);
  // var autocomplete3 = new google.maps.places.Autocomplete(input3, options);
  // var autocomplete4 = new google.maps.places.Autocomplete(input4, options);

  //create a DirectionsService object to use the route method and get a result for our request
  var directionsService = new google.maps.DirectionsService();

  //onload:
  google.maps.event.addDomListener(window, "load", initialize);

  //initialize: draw map in the #googleMap div
  function initialize() {
    console.log("init");
    //create a DirectionsRenderer object which we will use to display the route
    directionsDisplay = new google.maps.DirectionsRenderer();
    // directionsDisplay2 = new google.maps.DirectionsRenderer();
    //create map
    map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);
    // map2 = new google.maps.Map(
    //   document.getElementById("googleMap2"),
    //   mapOptions
    // );
    //bind the DirectionsRenderer to the map
    directionsDisplay.setMap(map);
    directionsDisplay2.setMap(map2);
  } //end of initialize

  //Calculate route when selecting autocomplete:
  google.maps.event.addListener(autocomplete1, "place_changed", calcRoute);
  google.maps.event.addListener(autocomplete2, "place_changed", calcRoute);
  // google.maps.event.addListener(autocomplete3, "place_changed", calcRoute2);
  // google.maps.event.addListener(autocomplete4, "place_changed", calcRoute2);

  // Calculate Route:
  function calcRoute() {
    console.log("change");
    var start = $("#departure").val();
    var end = $("#destination").val();
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
          directionsDisplay.setDirections(response);
          let dist = parseInt(
            response["routes"][0]["legs"][0]["distance"]["text"].split(" ")[0]
          );
          let recommendedprice = parseInt(dist * 0.25);
          if (recommendedprice < 5) recommendedprice = 5;
          document.getElementById("recommendedprice1").innerText =
            "Recommended Price : $" + recommendedprice;
        } else {
          initialize();
        }
      });
    }
  }

  // function calcRoute2() {
  //   console.log("change");
  //   var start = $("#departure2").val();
  //   var end = $("#destination2").val();
  //   var request = {
  //     origin: start,
  //     destination: end,
  //     travelMode: google.maps.DirectionsTravelMode.DRIVING,
  //     unitSystem: google.maps.UnitSystem.IMPERIAL,
  //     durationInTraffic: false,
  //     avoidHighways: false,
  //     avoidTolls: false,
  //   };
  //   if (start && end) {
  //     directionsService.route(request, function (response, status) {
  //       if (status == google.maps.DirectionsStatus.OK) {
  //         directionsDisplay2.setDirections(response);
  //         let dist = parseInt(
  //           response["routes"][0]["legs"][0]["distance"]["text"].split(" ")[0]
  //         );
  //         let recommendedprice = parseInt(dist * 0.25);
  //         if (recommendedprice < 5) recommendedprice = 5;
  //         document.getElementById("recommendedprice2").innerText =
  //           "Recommended Price : $" + recommendedprice;
  //       } else {
  //         initialize();
  //       }
  //     });
  //   }
  // }
});

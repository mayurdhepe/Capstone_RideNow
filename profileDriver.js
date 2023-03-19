$("#updateusernameform").submit(function (event) {
  event.preventDefault();
  var datatopost = $(this).serializeArray();
  $.ajax({
    url: "update_driver_username.php",
    type: "POST",
    data: datatopost,
    success: function (data) {
      if (data) {
        $("#updateusernamemessage").html(data);
      } else {
        location.reload();
      }
    },
    error: function () {
      $("#updateusernamemessage").html(
        "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
      );
    },
  });
});

$("#updatepasswordform").submit(function (event) {
  event.preventDefault();
  var datatopost = $(this).serializeArray();
  $.ajax({
    url: "update_driver_password.php",
    type: "POST",
    data: datatopost,
    success: function (data) {
      if (data) {
        $("#updatepasswordmessage").html(data);
      }
    },
    error: function () {
      $("#updatepasswordmessage").html(
        "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
      );
    },
  });
});

$("#updateemailform").submit(function (event) {
  event.preventDefault();
  var datatopost = $(this).serializeArray();
  $.ajax({
    url: "update_driver_email.php",
    type: "POST",
    data: datatopost,
    success: function (data) {
      if (data) {
        $("#updateemailmessage").html(data);
      }
    },
    error: function () {
      $("#updateemailmessage").html(
        "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
      );
    },
  });
});

$("#updateCarMakeForm").submit(function (event) {
  event.preventDefault();
  var datatopost = $(this).serializeArray();
  $.ajax({
    url: "update_driver_carMake.php",
    type: "POST",
    data: datatopost,
    success: function (data) {
      if (data) {
        $("#updatecarMakemessage").html(data);
      } else {
        location.reload();
      }
    },
    error: function () {
      $("#updatecarMakemessage").html(
        "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
      );
    },
  });
});

$("#updatecarModelForm").submit(function (event) {
  event.preventDefault();
  var datatopost = $(this).serializeArray();
  $.ajax({
    url: "update_driver_carModel.php",
    type: "POST",
    data: datatopost,
    success: function (data) {
      if (data) {
        $("#updatecarModelmessage").html(data);
      } else {
        location.reload();
      }
    },
    error: function () {
      $("#updatecarModelmessage").html(
        "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
      );
    },
  });
});

$("#updateSeatsForm").submit(function (event) {
  event.preventDefault();
  var datatopost = $(this).serializeArray();
  $.ajax({
    url: "update_driver_seats.php",
    type: "POST",
    data: datatopost,
    success: function (data) {
      if (data) {
        $("#updateSeatsmessage").html(data);
      } else {
        location.reload();
      }
    },
    error: function () {
      $("#updateSeatsmessage").html(
        "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
      );
    },
  });
});

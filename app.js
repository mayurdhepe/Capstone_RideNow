$("#signupform").submit(function (event) {
  event.preventDefault();

  var datatopost = $(this).serializeArray();

  $.ajax({
    url: "signup.php",
    type: "POST",
    data: datatopost,
    success: function (data) {
      if (data) {
        $("#signupmessage").html(data);
      }
    },
    error: function (data) {
      $("#signupmessage").html(
        "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
      );
    },
  });
});

$("#signupformDriver").submit(function (event) {
  event.preventDefault();
  var datatopost = $(this).serializeArray();
  $.ajax({
    url: "signupDriver.php",
    type: "POST",
    data: datatopost,
    success: function (data) {
      if (data) {
        $("#signupmessagedriver").html(data);
      }
    },
    error: function (data) {
      $("#signupmessagedriver").html(
        "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
      );
    },
  });
});

$("#loginform").submit(function (event) {
  event.preventDefault();
  var datatopost = $(this).serializeArray();
  $.ajax({
    url: "login.php",
    type: "POST",
    data: datatopost,
    success: function (data) {
      if (data == "success") {
        window.location = "loggedIn.php";
      } else {
        $("#loginmessage").html(data);
      }
    },
    error: function () {
      $("#loginmessage").html(
        "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
      );
    },
  });
});

$("#loginformDriver").submit(function (event) {
  event.preventDefault();
  var datatopost = $(this).serializeArray();

  $.ajax({
    url: "loginDriver.php",
    type: "POST",
    data: datatopost,
    success: function (data) {
      if (data == "success") {
        window.location = "loggedInDriver.php";
      } else {
        $("#loginmessagedriver").html(data);
      }
    },
    error: function () {
      $("#loginmessagedriver").html(
        "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
      );
    },
  });
});

$("#forgotpasswordform").submit(function (event) {
  event.preventDefault();
  var datatopost = $(this).serializeArray();
  $.ajax({
    url: "forgotpass.php",
    type: "POST",
    data: datatopost,
    success: function (data) {
      $("#forgotpasswordmessage").html(data);
    },
    error: function () {
      $("#forgotpasswordmessage").html(
        "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
      );
    },
  });
});

$("#forgotpasswordformdriver").submit(function (event) {
  event.preventDefault();
  var datatopost = $(this).serializeArray();
  $.ajax({
    url: "forgotpassDriver.php",
    type: "POST",
    data: datatopost,
    success: function (data) {
      $("#forgotpasswordmessagedriver").html(data);
    },
    error: function () {
      $("#forgotpasswordmessagedriver").html(
        "<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>"
      );
    },
  });
});

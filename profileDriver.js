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


// Function to preview image after validation
$(function() {
  $("#picture").change(function() {
  $("#updatepicturemessage").empty();
  file = this.files[0];
  var imagefile = file.type;
  var match= ["image/jpeg","image/png","image/jpg"];
      if($.inArray(imagefile, match) == -1){
          $("#updatepicturemessage").html("<div class='alert alert-danger'>Wrong file format!</div>");
          return false;
      }
      else{
          var reader = new FileReader();
          reader.onload = imageIsLoaded;
          reader.readAsDataURL(this.files[0]);
      }
  });
});

function imageIsLoaded(event) {
    $('#preview2').attr('src', event.target.result);
};


//Update picture
var file;

$("#updatepictureform").submit(function(event) {
    //hide message
    $("#updatepicturemessage").hide();
    //show spinner
    $("#spinner").css("display", "block");
    event.preventDefault();
    if(!file){
        $("#spinner").css("display", "none");
        $("#updatepicturemessage").html('<div class="alert alert-danger">Please upload a picture!</div>');
            $("#updatepicturemessage").slideDown();
        return false;
    }
    var imagefile = file.type;
    var match= ["image/jpeg","image/png","image/jpg"];
        if($.inArray(imagefile, match) == -1){
            $("#updatepicturemessage").html('<div class="alert alert-danger">Wrong File Format</div>');
            $("#updatepicturemessage").slideDown();
            $("#spinner").css("display", "none");
            return false;
        }else{
            $.ajax({
                url: "update_driver_picture.php", 
                type: "POST",             
                data: new FormData(this), 
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,        // To send DOMDocument or non processed data file it is set to false
                success: function(data){
                    if(data){
                        $("#updatepicturemessage").html(data);
                        //hide spinner
                        $("#spinner").css("display", "none");
                        //show message
                        $("#updatepicturemessage").slideDown();
                        //update picture in the settings
                    }else{
                        location.reload();
                    }

                },
                error: function(){
                    $("#updatepicturemessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
                    //hide spinner
                    $("#spinner").css("display", "none");
                    //show message
                    $("#signupmessage").slideDown();

                }
            });
        }

});

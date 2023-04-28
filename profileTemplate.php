<?php

?>

<form method="post" id="updatepictureform" enctype="multipart/form-data">
    <div class="modal" id="updatepicture" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 id="myModalLabel">
                        Upload Picture:
                    </h4>
                </div>
                <div class="modal-body">
                    <div id="updatepicturemessage"></div>

                    <div>
                        <?php
                        if (empty($picture)) {
                            echo "<div class='preview2'><img id='preview2' width='400px' height='400px' src='profilepictures/noimage.jpg' /></div>";
                        } else {
                            echo "<div class='preview2'><img id='preview2' width='400px' height='400px' src='$picture' /></div>";
                        }

                        ?>
                    </div>

                    <div class="form-group">
                        <label for="picture">Select a picture:</label>
                        <input type="file" name="picture" id="picture">
                    </div>

                </div>
                <div class="modal-footer">
                    <input class="btn btn-primary" name="updateusername" type="submit" value="Submit">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
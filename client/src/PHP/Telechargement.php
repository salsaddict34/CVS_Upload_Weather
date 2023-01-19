<!DOCTYPE html>
<html lang="fr">

<?php include "../assets/html/head.html" ?>

<!--JQuery et Ajax pour fonction PHP-->
<script>
    function callPhpFunction() {
        //alert($('.sectionForm').serialize());
        if ($('#formFile').val() != "") {
            $.ajax({
                type: 'post',
                url: './functions/uploadImageFile.php',
                data: $('.sectionForm').serialize(),
                dataType: 'json',
                success: function(data) {
                    alert(data);
                }
            });
        } else {
            alert('Aucun fichier choisi !!');
        }
        event.preventDefault();
    }
</script>

<script>
    function deleteImage(target) {
        //alert(target);
        if (confirm('Etes vous sur de vouloir effacer cette image ?')) {
            $.ajax({
                type: 'post',
                url: './functions/deleteImageFile.php',
                data: ({
                    file: target
                }),
                dataType: 'json',
                success: function(data) {
                    alert(data);
                }
            });
        } else {
            //nothing
        }
        event.preventDefault();
        location.reload();
    }
</script>

<script>
    function popUpload() {
        //alert("coucou");
        upload = $('.upload');
        btn = $('.btnUpload');
        if (btn.text() === 'Uploading') {
            upload.show();
            btn.text('Fermer');
        } else {
            upload.hide();
            btn.text('Uploading');
            location.reload();
        }
    }
</script>

<body>
    <div class="container">
        <!-- Nav -->
        <?php include "../assets/html/nav.html" ?>
        <!-- Upload -->
        <button class="btn btn-primary mt-5 btnUpload" onclick="$( document ).ready( popUpload )">Uploading</button>
        <dialog class="upload mt-5">
            <form action="functions/uploadImageFile.php" class="sectionForm form-control dropzone" method="POST" enctype="multipart/form-data">
                <fieldset class="sectionFormEntry">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">
                            <h4>Choisissez un fichier dans l'explorateur ou déposez dans la zone de téléchargement automatique</h4>
                        </label>
                        <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                        <input class="form-control" name="file" type="file" id="fileToUpload">
                        <input class="btn btn-success btn-lg mt-3" type="submit" value="Upload Image" name="submit">
                    </div>
                </fieldset>
            </form>
        </dialog>
        <div class="message mt-5">
            <p>
                <?php
                if (isset($_GET['message'])) {
                    echo $_GET['message'];
                }
                ?>
            </p>
        </div>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php
            $results = glob("{../assets/uploads/*.png,../assets/uploads/*.jpg,../assets/uploads/*.jpeg,../assets/uploads/*.gif}", GLOB_BRACE);
            foreach ($results as $data) {
                $data = htmlspecialchars($data);
                $file = explode('/', $data);
                $file = json_encode($file);
                echo ("
                    <div class='col'>
                    <div class='card ' style='width: 6rem;'>
                    <img src=$data class='card-img-top' alt='...' onclick='deleteImage($file)'>
                    </div>
                    </div>
                    ");
            }
            ?>
        </div>
    </div>

    <div class="container mt-5">
        <p>
            Cliquez sur une image pour la supprimer.
        </p>
    </div>
</body>

</html>
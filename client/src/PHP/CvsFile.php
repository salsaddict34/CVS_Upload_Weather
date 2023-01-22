<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include "../assets/html/head.html" ?>
    <script type="module" src="../../../dist/bundle.js"></script>
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
</head>

<!--JQuery et Ajax pour fonction PHP-->
<script type="text/javascript">
    function callAddFunction() {
        //alert($('.sectionForm').serialize());
        if ($('.lastName').val() != "" && $('.firstName').val() != "" && $('.age').val() != "" && $('.formation').val() != "") {
            $.ajax({
                type: 'post',
                url: './functions/addContentToFile.php',
                data: $('.sectionForm').serialize(),
                dataType: 'json',
                success: function(data) {
                    alert(data);
                }
            });
        } else {
            alert('Les champs de saisi ne peuvent pas être vide');
        }
        event.preventDefault();
        location.reload();
    }
</script>

<script type="text/javascript">
    function callDeleteFunction(i) {
        //alert(i);
        //alert($('#tabFile').val());
        //alert($('#headerFile').val());
        $.ajax({
            type: 'post',
            url: './functions/deleteContentFromFile.php',
            data: ({
                indice: i,
                tabFile: $('#tabFile').val(),
                headerFile: $('#headerFile').val()
            }),
            dataType: 'json',
            success: function(data) {
                alert(data);
            }
        });
        event.preventDefault();
        location.reload();
    }
</script>

<!-- Blibliothèque de fonctions -->
<script type="text/javascript">
    function clearForm_jquery() {
        $('.lastName').val("");
        $('.firstName').val("");
        $('.age').val(0);
        $('.formation').val("");
    }
</script>

<script>
    $(document).ready(function() {
        $('#table_id').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>

<body>
    <div class="container">
        <!-- Nav -->
        <?php include "../assets/html/nav.html" ?>
        <!-- Tableau -->
        <div class="sectionFormText mt-5">
            <table id="table_id" class="display">
                <?php
                $url = "/var/www/private/AFPA-CDA/PHP_XDEBUG/client/src/assets/files/data.csv";
                $persons = array();
                if (file_exists($url)) {
                    $file = fopen($url, 'rb');
                }
                while (feof($file) != true) {
                    $buffer = fgets($file);
                    $header = explode("/", $buffer);
                    $temp = explode(";", $header[1]);
                }
                fclose($file);
                $param = explode(",", $header[0]);
                ?>
                <thead>
                    <tr class="table-primary">
                        <?php
                        foreach ($param as $value) {
                            echo ("<th>$value</th>");
                        }
                        ?>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < count($temp); $i++) {
                        $persons[$i] = explode(",", $temp[$i]);
                    ?>
                        <tr>
                            <?php
                            foreach ($persons[$i] as $data) {
                                $data = htmlspecialchars($data);
                                echo ("<td name=$i>$data</td>");
                            }
                            ?>
                            <td><input type="button" onclick="callDeleteFunction(<?= $i ?>)" value="X" class="btn btn-danger delete" <?= "name=" . $i ?>></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <input type="hidden" id="tabFile" value='<?= json_encode($persons) ?>'>
        <input type="hidden" id="headerFile" value='<?= json_encode($header) ?>'>
        <!-- Formulaire -->
        <br />
        <br />
        <form action="" class="sectionForm form-control" method="POST">
            <fieldset class="sectionFormEntry">
                Nom :<input type="text" class="lastName form-control" name="lastName" maxlength="20" size="40" required>
                &nbsp;&nbsp;&nbsp;
                Prénom :<input type="text" class="firstName form-control" name="firstName" maxlength="20" size="40" required>
                &nbsp;&nbsp;&nbsp;
                Age :<input type="number" class="age form-control" name="age" maxlength="3" size="20" required>
                &nbsp;&nbsp;&nbsp;
                Formation<input type="text" class="formation form-control" name="formation" maxlength="10" size="20" required>
                &nbsp;&nbsp;&nbsp;
                <div class="sectionFormBtn col-3 mx-auto">
                    <button class="btn btn-dark " name="btn_clear" onclick="clearForm_jquery()">Vider</button>
                </div>
            </fieldset>
        </form>
        <!--Boutons et résultat-->
        <div class="sectionFormBtn col-3 mx-auto">
            <button class="btn btn-success btn-lg mt-3" onclick="callAddFunction()">Ajouter au fichier</button>
        </div>
    </div>
</body>

</html>
<?php

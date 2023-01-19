<!DOCTYPE html>
<html lang="fr">

<?php include "../assets/html/head.html" ?>

<script>
    $(document).ready(function() {
        refreshFromLocalStorage();
        $('.tableW').DataTable();
        $('#btn').on('click', function(event) {
            fetchCityWeather($('#addCity').val());
            $('#addCity').val("");
            event.preventDefault();
        });
    });
</script>

<body>
    <div class="container">
        <!-- Nav -->
        <?php include "../assets/html/nav.html" ?>
        <!-- Tableau -->
        <div class="container mt-5">
            <table class="tableW">
                <div class="geoCatch"></div>
                <thead>
                    <tr>
                        <th>Ville</th>
                        <th>Longitude</th>
                        <th>Latitude</th>
                        <th>Temperature</th>
                        <th>T maxi</th>
                        <th>T mini</th>
                        <th>Tendance</th>
                        <th>Effacer</th>
                    </tr>
                </thead>
                <tbody id='tbody'>
                </tbody>
            </table>
        </div>
        <form action="" class="form-control" method="POST">
            <fieldset class="form-control">
                Ville :<input type="text" class="lastName form-control" id="addCity" name="lastName" maxlength="20" size="40" required>
                <div class="sectionFormBtn col-3 mx-auto">
                    <button id="btn" class="btn btn-dark">Ajouter Ville</button>
                </div>
            </fieldset>
        </form>
    </div>
</body>

</html>
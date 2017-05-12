<!--Displays Categories on Index page if marked for that location based on Navigation location -->

<!-- The global variable is inserting the correct number for the css page to display the correct size if the asides are off -->



    <!--Title -->
<!--    <div class="row">-->
<!--        <div class="col-lg-8">-->
<!--            <h3>Resources</h3>-->
<!--        </div>-->
<!--   </div>-->
    <!-- /.row -->
    <?php
    if(isset($_GET['view'])) {
        $view = $_GET['view'];
    } else {
        $view = '';
    }
    switch($view) {
        case 'catbynavid'; //index.php?view=catbynavid&navigationID=#
            listFECatByNavID();
            break;

        case 'catbynavname'; //index.php?view=catbynavname&navname=Something
            listFECatByNavName();
            break;

        case 'indexcategories'; //index.php?view=indexcategories
            findIndexCategories();
            break;

        default:  //Shows categories with Navigation marked with Location 3(body)
            findIndexCategories();
            break;
    }

    ?>


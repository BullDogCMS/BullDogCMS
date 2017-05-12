<!--Help Page navigation is not visible unless you uncomment in includes\adminNavigationSide.php -->
<table class = "table table-hover">
    <thead>
    <tr>
        <th></th>
        <th>Id</th>
        <th>Title</th>
        <th class="description">Content</th>
    </tr>
    </thead>
    <tbody>

    <?php
    listHelpPages();
    deleteHelpPage();

    ?>
    </tbody>
</table>

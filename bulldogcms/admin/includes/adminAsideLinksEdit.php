<h1 class="page-header">
    Aside Edit
</h1>

<?php
//Set initial variable values from categories table
if(isset($_GET['edit'])) {
$linkID = $_GET['edit'];
$query = "SELECT * FROM links WHERE linkID = $linkID ";
$ID = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($ID)) {
    $linkName = htmlentities($row['linkName'], ENT_QUOTES, 'UTF-8');//escaped to be displayed on edit page. Must be unescaped in adminfunctionslinks when going into database.
    $linkURL = htmlentities($row['linkURL'], ENT_QUOTES, 'UTF-8');//escaped to be displayed on edit page. Must be unsescaped in adminfunctionslinks when going into database.
    $linkOrder = $row['linkOrder'];
    $linkTypeID = htmlentities($row['linkTypeID'], ENT_QUOTES, 'UTF-8');
}
?>
<div class="col-xs-6">
    <form action="" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="linkName">Link Name</label>
            <input value="<?php if (isset($linkName)) {
                echo $linkName;
            } ?>" type="text" class="form-control" name="linkName">
        </div>

        <div class="form-group">
            <label for="linkURL">Link URL</label>
            <input value="<?php if (isset($linkURL)) {
                echo $linkURL;
            } ?>" type="url" class="form-control" name="linkURL">
        </div>

        <div class="row">
            <div class="form-group col-xs-12 col-md-6">
                <label for="linkTypeID">Link Type</label>
                <br>
                <input type="radio" name="linkTypeID"
                    <?php if (isset($linkTypeID) && $linkTypeID =="1") echo "checked";?>
                       value="1">Link
                <input type="radio" name="linkTypeID"
                    <?php if (isset($linkTypeID) && $linkTypeID =="2") echo "checked";?>
                       value="2">News
            </div>
        </div>

        <!--Order Drop-down-->
        <div class="form-group col-xs-12 col-md-12">
            <label for="linksOrder">Order</label>
            <?php
            $query = "SELECT linkOrder FROM links WHERE linkTypeID = $linkTypeID ORDER BY linkOrder";
            $selectLinks = mysqli_query($connection, $query);
            confirmQuery($selectLinks);

            echo "<select class='form-control' name='linkOrder' id='linkOrder'>";
            while ($row = mysqli_fetch_assoc($selectLinks)) {
                $newLinkOrder = $row['linkOrder'];

                if ($newLinkOrder == $linkOrder) {
                    echo "<option value='$newLinkOrder' selected='true'>$newLinkOrder</option>";
                } else {
                    echo "<option value='$newLinkOrder'>$newLinkOrder</option>";
                }
            }
            ?>
            </select>
        </div>
        <?php
        //Update links table
        updatelinks($linkID, $linkOrder, $linkTypeID);
        }
        ?>

<div class="form-group">
    <input type="submit" name="updatelinks" value="Update Links" data-toggle="tooltip" title="Update Links">
    <input class = "btn btn-link" type="button" onclick="window.history.back()" value="Cancel" data-toggle='tooltip' title='Cancels editing the Link, and sends back to the Aside Links page.'>
</div>

    </form>
    </div>
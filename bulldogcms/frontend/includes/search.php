<?php IF ($GLOBAL['siteSearch']) :    // If statement that surrounds the blog search well html that will hide it based on the
//  based on the variable. -Micah ?>
<div class="col-md-4 col-xs-12 search">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Search</h4>
        <!--<form action="includes/articlelistSearch.php" method="post">-->
        <form action="index.php?view=articlelist&display=searcharticles" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>
</div>
<?php ENDIF; //Other end of the if statement surrounding the blog search well html -Micah?>
<!-- Displays a list of users -->
<!--Added blank table header to handle Delete/Edit icons, and styling to match Categories Page.-->
<div class="col-xs-12">
    <table class="table table-hover" id="userList">
        <thead>
        <tr>
            <th></th>
            <th id="username">
                <ul class="sort-header">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Username<b class="caret"></b></a>
                        <ul style="list-style: none;" class="dropdown-menu">
                            <li>
                                <a href="index.php?view=users&order=username&sort=asc">Sort by Ascending</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="index.php?view=users&order=username&sort=desc">Sort by Descending</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </th>

            <th>
                <ul class="sort-header">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">First Name<b class="caret"></b></a>
                        <ul style="list-style: none;" class="dropdown-menu">
                            <li>
                                <a href="index.php?view=users&order=firstname&sort=asc">Sort by Ascending</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="index.php?view=users&order=firstname&sort=desc">Sort by Descending</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </th>

            <th>
                <ul class="sort-header">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Last Name<b class="caret"></b></a>
                        <ul style="list-style: none;" class="dropdown-menu">
                            <li>
                                <a href="index.php?view=users&order=lastname&sort=asc">Sort by Ascending</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="index.php?view=users&order=lastname&sort=desc">Sort by Descending</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </th>

            <th>
                <ul class="sort-header">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Email<b class="caret"></b></a>
                        <ul style="list-style: none;" class="dropdown-menu">
                            <li>
                                <a href="index.php?view=users&order=email&sort=asc">Sort by Ascending</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="index.php?view=users&order=email&sort=desc">Sort by Descending</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </th>

            <th>
                <ul class="sort-header">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Role<b class="caret"></b></a>
                        <ul style="list-style: none;" class="dropdown-menu">
                            <!--Had to reverse URL for ascending and descending, because it sorts by ID, not role name.-->
                            <li>
                                <a href="index.php?view=users&order=role&sort=desc">Sort by Ascending</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="index.php?view=users&order=role&sort=asc">Sort by Descending</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </th>

            <th>
                <ul class="sort-header">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Date Created<b class="caret"></b></a>
                        <ul style="list-style: none;" class="dropdown-menu">
                            <li>
                                <a href="index.php?view=users&order=datecreated&sort=asc">Sort by Ascending</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="index.php?view=users&order=datecreated&sort=desc">Sort by Descending</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </th>
        </tr>
        </thead>

        <tbody>

        <?php listUsers(); ?>
        <?php changeUserActive(); ?>

        </tbody>
    </table>
</div>
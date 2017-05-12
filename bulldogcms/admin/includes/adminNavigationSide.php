<!--This module controls the sidebar navigation links in the Admin Console -->

    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
            <?php   if($_SESSION['roleID'] == 2){

            echo "<li>
                <a href='./index.php?view=navigations'><i class='fa fa-fw fa-sitemap'></i> Navigations</a>
            </li>
            <li>
                <a href='./index.php?view=categories'><i class='fa fa-fw fa-bars'></i> Categories</a>
            </li>";}
            ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#articles_dropdown"><i class="fa fa-fw fa-newspaper-o"></i> Articles<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="articles_dropdown" class="collapse">
                    <li>
                        <a href="./index.php?view=articles" data-toggle='tooltip' title='Displays all Articles and their information within the system.'>View All Articles</a>
                    </li>
                    <li>
                        <a href="./index.php?view=articles&action=addarticle" data-toggle='tooltip' title='Allows you to add a new Article into the system.'>Add Article</a>
                    </li>
                    <li>
                        <a href="./index.php?view=articles&display=pendingarticles" data-toggle='tooltip' title='Displays all Pending Articles and their information within the system.'><i class="fa fa-fw fa-exclamation-triangle"></i> Pending Articles</a>
                    </li>
                    <li>
                        <a href="./index.php?view=articles&display=archivedarticles" data-toggle='tooltip' title='Displays all Archived Articles and their information within the system.'>Archived Articles</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#pages_dropdown"><i class="fa fa-fw fa-file-text"></i> Special Pages<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="pages_dropdown" class="collapse">
                    <li>
                        <a href="./index.php?view=articles&display=specialpages" data-toggle='tooltip' title='Displays all Special Pages and their information within the system.'>View All Pages</a>
                    </li>
                    <li>
                        <a href="./index.php?view=articles&action=addpage" data-toggle='tooltip' title='Allows you to add a new Special Page into the system.'>Add Page</a>
                    </li>
                    <li>
                        <a href="./index.php?view=articles&display=pendingpages" data-toggle='tooltip' title='Displays all Pending Pages and their information within the system.'><i class="fa fa-fw fa-exclamation-triangle"></i> Pending Pages</a>
                    </li>
                    <li>
                        <a href="./index.php?view=articles&display=archivedpages" data-toggle='tooltip' title='Displays all Archived Pages and their information within the system.'> Archived Pages</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#aside_dropdown"><i class="fa fa-fw fa-cogs"></i> Aside Settings<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="aside_dropdown" class="collapse">
                    <li>
                        <a href="./index.php?view=asidelinks" data-toggle='tooltip' title='Displays all Aside Links and their information within the system.'>Aside Links</a>
                    </li>
                    <li>
                        <a href="./index.php?view=asidesection" data-toggle='tooltip' title='Displays all Aside Sections and their information within the system.'>Aside Section</a>
                    </li>
                </ul>
            </li>

            <?php   if($_SESSION['roleID'] == 2){

            echo "<li>
                <a href='javascript:;' data-toggle='collapse' data-target='#theme'><i class='fa fa-fw fa-cogs'></i> Layout Settings<i class='fa fa-fw fa-caret-down'></i></a>
                <ul id='theme' class='collapse'>
                    <li>
                        <a href='./index.php?view=sitecolors' data-toggle='tooltip' title='Displays current site color settings for the front end site, and allows you to modify them.'>Site Colors</a>
                    </li>
                    <li>
                        <a href='./index.php?view=hpsettings' data-toggle='tooltip' title='Displays current home page settings for the front end site, and allows you to modify them.'>Homepage Settings</a>
                    </li>
                    <li>
                        <a href='./index.php?view=headersettings' data-toggle='tooltip' title='Displays current Header settings for the front end site, and allows you to modify them.'>Header Settings</a>
                    </li>
                    <li>
                        <a href='./index.php?view=footersettings' data-toggle='tooltip' title='Displays current Footer settings for the front end site, and allows you to modify them.'>Footer Settings</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href='./index.php?view=sitesettings'><i class='fa fa-fw fa-cog'></i> Site Settings</a>
            </li>
            <li>
                <a href='javascript:;' data-toggle='collapse' data-target='#users'><i class='fa fa-fw fa-user'></i> Users<i class='fa fa-fw fa-caret-down'></i></a>
                <ul id='users' class='collapse'>
                    <li>
                        <a href='./index.php?view=users' data-toggle='tooltip' title='Displays all Users and their information within the system.'>View Users</a>
                    </li>
                    <li>
                        <a href='./index.php?view=users&action=adduser' data-toggle='tooltip' title='Allows you to add a new User into the system.'>Add User</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href='javascript:;' data-toggle='collapse' data-target='#reports'><i class='fa fa-fw fa-wrench'></i> Tools<i class='fa fa-fw fa-caret-down'></i></a>
                <ul id='reports' class='collapse'>
                    <li>
                        <a href='./index.php?view=changelog' data-toggle='tooltip' title='Displays the change log for the CMS Admin site.'>Change Log Report</a>
                    </li>
                    <li>
                        <a href='filemanager/dialog.php?relative_url=1' class='iframe-btn' data-toggle='tooltip' title='Access the File Manager.'>File Manager</a>
                    </li>
                </ul>
            </li> ";}
            ?>
            <!--Hide/Unhide by developers to add new Help Pages -->
            <!--If adding pages, change filemanager/Config/config.php to point to /images/helppages/  and /thumbs/ then change back.  Need to copy new images to sites -->
<!--
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#helppages_dropdown"><i class="fa fa-fw fa-file-text"></i> Help Pages<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="helppages_dropdown" class="collapse">
                    <li>
                        <a href="./index.php?view=helppages" data-toggle='tooltip' title='Displays all Help Pages and their information within the system.'>View All Pages</a>
                    </li>
                    <li>
                        <a href="./index.php?view=helppages&action=addhelppage" data-toggle='tooltip' title='Allows you to add a new Help Page into the system.'>Add Page</a>
                    </li>
                </ul>
            </li>
-->
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>

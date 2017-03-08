<!-- Navbar.php ----------------------------------------- -->


<nav class="navbar navbar-default">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul id="listenav" class="nav navbar-nav">
            <?php
                // --- pour chaque type de pizza, on fabrique le lien et l'ancre
                foreach ( $pizzastypes as $pizztype ) {
                    echo '<li><a class="bnavig text-center" href="#pizztyp'.$pizztype['idtype'].'">'.$pizztype['txtbtn'].'</a></li>';
                }
            ?>
            <li><a class="bnavig text-center" href="#noscontacts">Qui sommes-nous ?</a></li>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>

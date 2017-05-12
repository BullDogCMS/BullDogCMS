<!--<header class="jumbotron hero-spacer">-->
<header>
<!--Hero text code:  https://codepen.io/mrnathan8/pen/KwKdmO -->
    <div class="hero">
        <h1><?php if(isset($GLOBAL['heroicHeader'])) {echo $GLOBAL['heroicHeader'];} ?></h1>
        <p><?php if(isset($GLOBAL['heroicText1'])) {echo $GLOBAL['heroicText1'];} ?></p>
        <?php if(isset($GLOBAL['heroicImage']) && $GLOBAL['heroicImage'] != ''){
            ?>
            <img class="img-responsive" src="uploads/<?php echo $GLOBAL['heroicImage'] ?>" alt="heroic">
        <?php } ?></div>
<!--
    <section class="hero">
        <div class="row intro">
            <div class="small-centered medium-uncentered medium-6 large-7 columns">
                <h1>Team Fellowship</h1>
                <p>Something should be over Heroic</p>
            </div>
        </div>
    </section>
-->

    <!--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, ipsam, eligendi, in quo sunt possimus non incidunt odit vero aliquid similique quaerat nam nobis illo aspernatur vitae fugiat numquam repellat.</p>
    <p><a class="btn btn-primary btn-large">Call to action!</a>
    </p>-->
</header>
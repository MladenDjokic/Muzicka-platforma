<?php
include('header.php');
?>

<div class="container mt-5">
    <?php if (!isset($_SESSION['user_id'])): ?>
        <div class="jumbotron mt-4">
            <h1 class="display-4">Dobrodosli na muzicku platformu Djokic!</h1>
            <p class="lead">Uzivajte u vasoj omiljenoj muzici!</p>
            <hr class="my-4">
            <p>Za pocetak, ulogujte se ili se registrujte na nas sajt!</p>
            <a class="btn btn-primary btn-lg" href="login.php" role="button">Login</a>
            <a class="btn btn-secondary btn-lg" href="register.php" role="button">Register</a>
        </div>
    <?php else: ?>
        <div class="jumbotron mt-4">
            <h1 class="display-4">Dobrodosli nazad, <?= $_SESSION['username']; ?>!</h1>
            <p class="lead">Istrazite najnoviju muziku!</p>
            <hr class="my-4">
            <div class="d-flex justify-content-center">
                <a class="btn btn-outline-primary btn-lg mx-2 animate-button" href="muzika.php" role="button">Istrazi</a>
                <a class="btn btn-outline-success btn-lg mx-2 animate-button" href="omiljena_muzika.php" role="button">Vasa muzika</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="container mt-5">
    <h2 class="text-center">Popularni izvodjaci</h2>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <img src="img/acraze.jpg" class="card-img-top" alt="Artist 1">
                <div class="card-body">
                    <h5 class="card-title">ACRAZE</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <img src="img/ceca.jpg" class="card-img-top" alt="Artist 2">
                <div class="card-body">
                    <h5 class="card-title">Ceca</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <img src="img/maya.jpg" class="card-img-top" alt="Artist 3">
                <div class="card-body">
                    <h5 class="card-title">Maya Berovic</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <img src="img/sade.jpeg" class="card-img-top" alt="Artist 4">
                <div class="card-body">
                    <h5 class="card-title">Sade</h5>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

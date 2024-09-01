<?php
include('header.php');
include('db.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$edit_mode = false;
$song_id = null;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naziv = $_POST['naziv'];
    $trajanje = $_POST['trajanje'];
    $izvodjac_ime = $_POST['izvodjac_ime'];
    $album_naziv = $_POST['album_naziv'];

    
    $sql = "SELECT id FROM izvodjaci WHERE ime='$izvodjac_ime'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $izvodjac = $result->fetch_assoc();
        $izvodjac_id = $izvodjac['id'];
    } else {
       
        $sql = "INSERT INTO izvodjaci (ime) VALUES ('$izvodjac_ime')";
        if ($conn->query($sql) === TRUE) {
            $izvodjac_id = $conn->insert_id;
        } else {
            echo "Greška pri dodavanju izvođača: " . $conn->error;
            exit();
        }
    }

    
    $sql = "SELECT id FROM albumi WHERE naziv='$album_naziv'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $album = $result->fetch_assoc();
        $album_id = $album['id'];
    } else {
        
        $sql = "INSERT INTO albumi (naziv) VALUES ('$album_naziv')";
        if ($conn->query($sql) === TRUE) {
            $album_id = $conn->insert_id;
        } else {
            echo "Greška pri dodavanju albuma: " . $conn->error;
            exit();
        }
    }

    if (isset($_POST['song_id']) && !empty($_POST['song_id'])) {
        
        $song_id = $_POST['song_id'];
        $sql = "UPDATE pesme SET naziv='$naziv', trajanje='$trajanje', izvodjac_id='$izvodjac_id', album_id='$album_id' WHERE id='$song_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Pesma je uspešno izmenjena!";
        } else {
            echo "Greška: " . $conn->error;
        }
    } else {
        
        $sql = "INSERT INTO pesme (naziv, trajanje, izvodjac_id, album_id) VALUES ('$naziv', '$trajanje', '$izvodjac_id', '$album_id')";
        if ($conn->query($sql) === TRUE) {
            echo "Pesma je uspešno dodata!";
        } else {
            echo "Greška: " . $conn->error;
        }
    }
}


if (isset($_GET['edit_id'])) {
    $edit_mode = true;
    $song_id = $_GET['edit_id'];
    $sql = "SELECT pesme.*, izvodjaci.ime AS izvodjac_ime, albumi.naziv AS album_naziv FROM pesme
            JOIN izvodjaci ON pesme.izvodjac_id = izvodjaci.id
            JOIN albumi ON pesme.album_id = albumi.id
            WHERE pesme.id='$song_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $song = $result->fetch_assoc();
    } else {
        echo "Greška: Pesma nije pronađena.";
        exit();
    }
}
?>

<div class="container mt-5">
    <h2><?= $edit_mode ? "Izmeni pesmu" : "Dodaj novu pesmu" ?></h2>
    <form method="POST" action="dodaj_pesmu.php">
        <?php if ($edit_mode): ?>
            <input type="hidden" name="song_id" value="<?= $song['id'] ?>">
        <?php endif; ?>
        <div class="form-group">
            <label for="naziv">Naziv pesme</label>
            <input type="text" class="form-control" id="naziv" name="naziv" value="<?= $edit_mode ? $song['naziv'] : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="trajanje">Trajanje</label>
            <input type="text" class="form-control" id="trajanje" name="trajanje" value="<?= $edit_mode ? $song['trajanje'] : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="izvodjac_ime">Izvođač</label>
            <input type="text" class="form-control" id="izvodjac_ime" name="izvodjac_ime" value="<?= $edit_mode ? $song['izvodjac_ime'] : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="album_naziv">Album</label>
            <input type="text" class="form-control" id="album_naziv" name="album_naziv" value="<?= $edit_mode ? $song['album_naziv'] : '' ?>" required>
        </div>
        <button type="submit" class="btn btn-primary"><?= $edit_mode ? "Sačuvaj izmene" : "Dodaj pesmu" ?></button>
    </form>
</div>

<hr>

<div class="container mt-5">
    <h2>Sve pesme</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naziv</th>
                <th>Trajanje</th>
                <th>Izvođač</th>
                <th>Album</th>
                <th>Izmeni</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT pesme.id, pesme.naziv AS pesma_naziv, pesme.trajanje, izvodjaci.ime AS izvodjac_ime, albumi.naziv AS album_naziv 
                    FROM pesme
                    JOIN izvodjaci ON pesme.izvodjac_id = izvodjaci.id
                    JOIN albumi ON pesme.album_id = albumi.id";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()):
            ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['pesma_naziv'] ?></td>
                    <td><?= $row['trajanje'] ?></td>
                    <td><?= $row['izvodjac_ime'] ?></td>
                    <td><?= $row['album_naziv'] ?></td>
                    <td>
                        <a href="dodaj_pesmu.php?edit_id=<?= $row['id'] ?>" class="btn btn-outline-primary">Izmeni</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>

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

$song_id = $_GET['song_id'] ?? null;

if (!$song_id) {
    echo "Greška: Nema ID-ja pesme.";
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_name = $_POST['new_name'];
    $new_duration = $_POST['new_duration'];
    $new_artist_name = $_POST['new_artist_name'];
    $new_album_name = $_POST['new_album_name'];

    
    $sql = "SELECT id FROM izvodjaci WHERE ime='$new_artist_name'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $izvodjac = $result->fetch_assoc();
        $new_artist_id = $izvodjac['id'];
    } else {
        
        $sql = "INSERT INTO izvodjaci (ime) VALUES ('$new_artist_name')";
        if ($conn->query($sql) === TRUE) {
            $new_artist_id = $conn->insert_id;
        } else {
            echo "Greška pri dodavanju izvođača: " . $conn->error;
            exit();
        }
    }

    
    $sql = "SELECT id FROM albumi WHERE naziv='$new_album_name' AND izvodjac_id='$new_artist_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $album = $result->fetch_assoc();
        $new_album_id = $album['id'];
    } else {
        
        $sql = "INSERT INTO albumi (naziv, izvodjac_id) VALUES ('$new_album_name', '$new_artist_id')";
        if ($conn->query($sql) === TRUE) {
            $new_album_id = $conn->insert_id;
        } else {
            echo "Greška pri dodavanju albuma: " . $conn->error;
            exit();
        }
    }

    
    $sql = "UPDATE pesme SET naziv='$new_name', trajanje='$new_duration', izvodjac_id='$new_artist_id', album_id='$new_album_id' WHERE id='$song_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Pesma je uspešno izmenjena!";
    } else {
        echo "Greška: " . $conn->error;
    }
}


$sql = "SELECT pesme.naziv, pesme.trajanje, izvodjaci.ime AS izvodjac_ime, albumi.naziv AS album_naziv
        FROM pesme
        JOIN izvodjaci ON pesme.izvodjac_id = izvodjaci.id
        JOIN albumi ON pesme.album_id = albumi.id
        WHERE pesme.id = '$song_id'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $song = $result->fetch_assoc();
} else {
    echo "Greška: Pesma nije pronađena.";
    exit();
}
?>

<div class="container mt-5">
    <h2>Izmeni pesmu</h2>
    <form method="POST" action="izmeni_pesmu.php?song_id=<?= $song_id ?>">
        <div class="form-group">
            <label for="new_name">Naziv pesme</label>
            <input type="text" class="form-control" id="new_name" name="new_name" value="<?= htmlspecialchars($song['naziv']) ?>" required>
        </div>
        <div class="form-group">
            <label for="new_duration">Trajanje</label>
            <input type="text" class="form-control" id="new_duration" name="new_duration" value="<?= htmlspecialchars($song['trajanje']) ?>" required>
        </div>
        <div class="form-group">
            <label for="new_artist_name">Izvođač</label>
            <input type="text" class="form-control" id="new_artist_name" name="new_artist_name" value="<?= htmlspecialchars($song['izvodjac_ime']) ?>" required>
        </div>
        <div class="form-group">
            <label for="new_album_name">Album</label>
            <input type="text" class="form-control" id="new_album_name" name="new_album_name" value="<?= htmlspecialchars($song['album_naziv']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
    </form>
</div>

</body>
</html>

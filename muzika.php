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


$sql = "SELECT omiljene_pesme FROM korisnicke_preferencije WHERE korisnicko_ime = '$user_id'";
$result = $conn->query($sql);

$favorites = [];
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $favorites = $row['omiljene_pesme'] ? explode(',', $row['omiljene_pesme']) : [];
}


$favorites_str = implode(',', $favorites);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['song_id'])) {
    $song_id = $_POST['song_id'];

    if (!in_array($song_id, $favorites)) {
        $favorites[] = $song_id;
        $favorites_str = implode(',', $favorites);

        if ($result && $result->num_rows > 0) {
            $sql = "UPDATE korisnicke_preferencije SET omiljene_pesme = '$favorites_str' WHERE korisnicko_ime = '$user_id'";
        } else {
            $sql = "INSERT INTO korisnicke_preferencije (korisnicko_ime, omiljene_pesme) VALUES ('$user_id', '$favorites_str')";
        }

        if (!$conn->query($sql)) {
            echo "Error: " . $conn->error;
        }
    }
}

$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'pesma_naziv';
$order_dir = isset($_GET['order_dir']) && $_GET['order_dir'] == 'desc' ? 'DESC' : 'ASC';


$sql = "SELECT pesme.id, pesme.naziv AS pesma_naziv, pesme.trajanje, izvodjaci.ime AS izvodjac_ime, albumi.naziv AS album_naziv 
        FROM pesme
        JOIN izvodjaci ON pesme.izvodjac_id = izvodjaci.id
        JOIN albumi ON pesme.album_id = albumi.id";


if (!empty($favorites)) {
    $sql .= " WHERE pesme.id NOT IN ($favorites_str)";
}

$sql .= " ORDER BY $order_by $order_dir";
$result = $conn->query($sql);
?>

<div class="container mt-5">
    <h2>Sve pesme</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><a href="?order_by=id&order_dir=<?= $order_dir == 'ASC' ? 'desc' : 'asc' ?>">ID</a></th>
                <th><a href="?order_by=pesma_naziv&order_dir=<?= $order_dir == 'ASC' ? 'desc' : 'asc' ?>">Naziv</a></th>
                <th><a href="?order_by=trajanje&order_dir=<?= $order_dir == 'ASC' ? 'desc' : 'asc' ?>">Trajanje</a></th>
                <th><a href="?order_by=izvodjac_ime&order_dir=<?= $order_dir == 'ASC' ? 'desc' : 'asc' ?>">Izvođač</a></th>
                <th><a href="?order_by=album_naziv&order_dir=<?= $order_dir == 'ASC' ? 'desc' : 'asc' ?>">Album</a></th>
                <th>Omiljeno</th>
                <th>Izmeni</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['pesma_naziv'] ?></td>
                    <td><?= $row['trajanje'] ?></td>
                    <td><?= $row['izvodjac_ime'] ?></td>
                    <td><?= $row['album_naziv'] ?></td>
                    <td>
                        <form method="POST" action="muzika.php">
                            <input type="hidden" name="song_id" value="<?= $row['id'] ?>">
                            <button type="submit" class="btn btn-outline-danger">❤</button>
                        </form>
                    </td>
                    <td>
                        <a href="izmeni_pesmu.php?song_id=<?= $row['id'] ?>" class="btn btn-primary">Izmeni</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>


<?php
session_start();


if (!isset($_SESSION["host"])) {
    header("Location: login.php");
    exit;
}


if (!isset($_SESSION["daftarItem"])) {
    $_SESSION["daftarItem"] = [];
}

$folderTujuan = "uploads/";
$namaFileBukti = "";


if (
    isset($_FILES["buktiStruk"]) &&
    $_FILES["buktiStruk"]["error"] === UPLOAD_ERR_OK
) {
    if (!is_dir($folderTujuan)) {
        mkdir($folderTujuan, 0755, true);
    }

  
    $namaFile = basename($_FILES["buktiStruk"]["name"]);
    $ekstensi = strtolower(
        pathinfo($namaFile, PATHINFO_EXTENSION)
    );

    $ekstensiDiizinkan = ["jpg", "jpeg", "png"];

    if (in_array($ekstensi, $ekstensiDiizinkan, true)) {
   
        $namaFileBaru = uniqid("struk_", true) . "." . $ekstensi;
        $pathFile = $folderTujuan . $namaFileBaru;

        if (
            move_uploaded_file(
                $_FILES["buktiStruk"]["tmp_name"],
                $pathFile
            )
        ) {
            $namaFileBukti = $pathFile;
        }
    }
}

$itemBaru = [
    "nama" => $_POST["nama"],
    "harga" => $_POST["harga"],
    "jumlahOrang" => $_POST["jumlahOrang"],
    "status" => $_POST["status"],
    "bukti" => $namaFileBukti,
];

$_SESSION["daftarItem"][] = $itemBaru;

header("Location: dashboard.php");
exit;

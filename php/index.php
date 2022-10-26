<?php
include 'Conexion.php';

$PDO = new Conexion();

if($_SERVER ['REQUEST_METHOD'] == 'GET'){
    if(isset ($_GET['inpID'])){

    $sql = $PDO->prepare("call sp_consultaUsuario(:id)");
    $sql->bindValue(':id', $_GET['inpID']);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 OK");
    echo json_encode($sql->fetchAll());
    exit;
}else{
    $sql = $PDO->prepare("call sp_datosUsuario()");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 OK");
    echo json_encode($sql->fetchAll());
    exit;
    }

}
if($_SERVER ['REQUEST_METHOD'] == 'POST'){
    $sql = "call sp_InsertarUsuario(:nombre,:Apaterno, :AMaterno, :email, :Telefono, :Status);";
    $stmt = $PDO -> prepare($sql);
    $stmt ->bindValue (':nombre', $_POST ['inpNombre']);
    $stmt ->bindValue (':Apaterno', $_POST ['inpAPaterno']);
    $stmt ->bindValue (':AMaterno', $_POST ['inpAMaterno']);
    $stmt ->bindValue (':email', $_POST ['inpEmail']);
    $stmt ->bindValue (':Telefono', $_POST ['inpTelefono']);
    $stmt ->bindValue (':Status', $_POST ['inpEstatus']);
    $stmt ->execute();
    $idPost = $PDO -> lastInsertId();
    if($idPost){
        header("HTTP/1.1 200 hay datos");
        echo json_encode($idPost);
        exit;
    }
}
if($_SERVER ['REQUEST_METHOD'] == 'PUT'){
    $sql = "call sp_actualizarUsuario(:id,:nombre,:Apaterno, :AMaterno, :email, :Telefono, :Status);";
    $stmt = $PDO -> prepare($sql);
    $stmt ->bindValue (':nombre', $_POST ['inpNombre']);
    $stmt ->bindValue (':Apaterno', $_POST ['inpAPaterno']);
    $stmt ->bindValue (':AMaterno', $_POST ['inpAMaterno']);
    $stmt ->bindValue (':email', $_POST ['inpEmail']);
    $stmt ->bindValue (':Telefono', $_POST ['inpTelefono']);
    $stmt ->bindValue (':Status', $_POST ['inpEstatus']);
    $stmt ->bindValue (':id', $_GET ['inpID']);
    $stmt ->execute();
        header("HTTP/1.1 200 hay datos");
        exit;
}
if($_SERVER ['REQUEST_METHOD'] == 'REST'){
    $sql = "call sp_eliminarUsuario(:id);";
    $stmt = $PDO -> prepare($sql);
    $stmt ->bindValue (':id', $_GET ['inpID']);
    $stmt ->execute();
        header("HTTP/1.1 200 hay datos");
        exit;
}
header("HTTP/1.1 400 Bad Request");
?>
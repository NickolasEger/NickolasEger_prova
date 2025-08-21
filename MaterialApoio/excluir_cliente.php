<?php
session_start();
require 'conexao.php';


if($_SESSION['perfil']!=1){
    echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
    exit();   
}

$clientes = [];

$sql = "SELECT * FROM cliente ORDER BY nome_cliente ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_cliente = $_GET['id'];

    $sql = "DELETE FROM cliente WHERE id_cliente = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id',$id_cliente,PDO::PARAM_INT);

    if($stmt->execute()){
        echo "<script>alert('Cliente excluido com sucesso!');window.location.href='excluir_cliente.php';</script>";
    } else{
        echo "<script>alert('Erro ao excluir o cliente!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Cliente</title>
    <link rel = "stylesheet" href = "styles.css">
</head>
<body>
    <!-- Barra de Navegação -->
    <nav class="navbar">
        <ul>
            <li><a href="cadastro_cliente.php">Cadastrar Usuário</a></li>
            <li><a href="alterar_cliente.php">Alterar Usuário</a></li>
            <li><a href="buscar_cliente.php">Buscar Usuário</a></li>
            <li><a href="excluir_cliente.php">Excluir Usuário</a></li>
            <li><a href="principal.php">Início</a></li>
        </ul>
    </nav>

    <h2>Excluir Cliente</h2>
    <?php if(!empty($clientes)): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Perfil</th>
            </tr>
        <?php foreach($clientes as $cliente): ?>
            <tr>
                <td><?= htmlspecialchars($cliente['id_cliente'])?></td>
                <td><?= htmlspecialchars($cliente['nome_cliente'])?></td>
                <td><?= htmlspecialchars($cliente['email'])?></td>
                <td>
                    <a href="excluir_cliente.php?id=<?= htmlspecialchars($cliente['id_cliente'])?>" 
                       onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                       Excluir
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum cliente encontrado</p>
    <?php endif; ?>

    <center>
        <address>Nickolas Eger</address>
    </center>
</body>
</html>
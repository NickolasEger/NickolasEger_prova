<?php
session_start();
require 'conexao.php';

//verifica se o usuario tem permissao de adm
if($_SESSION['perfil']!=1){
    echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
    exit();   
}

//inicializa variavel para armazenar usuarios
$usuarios = [];

//busca todos os usuarios cadastrados em ordem alfabetica
$sql = "SELECT * FROM usuario ORDER BY nome ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

//se um id for passado via GET exclui o usuario
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_usuario = $_GET['id'];

    // exclui o usuairo do banco de dados
    $sql = "DELETE FROM usuario WHERE id_usuario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id',$id_usuario,PDO::PARAM_INT);

    if($stmt->execute()){
        echo "<script>alert('Usuario excluido com sucesso!');window.location.href='excluir_usuario.php';</script>";
    } else{
        echo "<script>alert('Erro ao excluir o usuario!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Usuario</title>
    <link rel = "stylesheet" href = "styles.css">
</head>
<body>
    <!-- Barra de Navegação -->
    <nav class="navbar">
        <ul>
            <li><a href="cadastro_usuario.php">Cadastrar Usuário</a></li>
            <li><a href="alterar_usuario.php">Alterar Usuário</a></li>
            <li><a href="buscar_usuario.php">Buscar Usuário</a></li>
            <li><a href="excluir_usuario.php">Excluir Usuário</a></li>
            <li><a href="principal.php">Início</a></li>
        </ul>
    </nav>

    <h2>Excluir Usuário</h2>
    <?php if(!empty($usuarios)): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Ações</th>
            </tr>
        <?php foreach($usuarios as $usuario): ?>
            <tr>
                <td><?= htmlspecialchars($usuario['id_usuario'])?></td>
                <td><?= htmlspecialchars($usuario['nome'])?></td>
                <td><?= htmlspecialchars($usuario['email'])?></td>
                <td><?= htmlspecialchars($usuario['id_perfil'])?></td>
                <td>
                    <a href="excluir_usuario.php?id=<?= htmlspecialchars($usuario['id_usuario'])?>" 
                       onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                       Excluir
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum usuário encontrado</p>
    <?php endif; ?>
</body>
</html>

</html>
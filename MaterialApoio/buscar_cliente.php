<?php 
session_start();
require_once 'conexao.php';


if($_SESSION['perfil']!=1 && $_SESSION['perfil']!=2){
    echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
    exit();
    
}

$cliente = []; 

if($_SERVER["REQUEST_METHOD"]=="POST" && !empty($_POST['busca'])){
    $busca = trim($_POST['busca']);

    if(is_numeric($busca)){
        $sql="SELECT * FROM cliente WHERE id_cliente = :busca ORDER BY nome_cliente ASC";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':busca',$busca, PDO::PARAM_INT);
    }else{
        $sql="SELECT * FROM cliente WHERE nome_cliente LIKE :busca_nome ORDER BY nome_cliente ASC";
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':busca_nome',"%$busca%", PDO::PARAM_STR);
        
    }
    }else{
        $sql="SELECT * FROM cliente ORDER BY nome_cliente ASC";
        $stmt=$pdo->prepare($sql);

    }
    $stmt->execute();   
    $clientes = $stmt->fetchALL(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Cliente</title>
    <link rel = "stylesheet" href = "styles.css">
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="cadastro_cliente.php">Cadastrar Cliente</a></li>
            <li><a href="alterar_cliente.php">Alterar Cliente</a></li>
            <li><a href="buscar_cliente.php">Buscar Cliente</a></li>
            <li><a href="excluir_cliente.php">Excluir Cliente</a></li>
            <li><a href="principal.php">Início</a></li>
        </ul>
    </nav>

    <h2>Lista de Clientes</h2>

    <form action="buscar_cliente.php" method="POST">
        <label for="busca">Digite o ID ou nome (opcional): </label>
        <input type="text" id="busca" name="busca">
        <button type="submit">Pesquisar</button>
    </form>

    <?php if(!empty($clientes)): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
            <?php foreach($clientes as $cliente): ?>
            <tr>
                <td><?= htmlspecialchars($cliente['id_cliente']) ?></td>
                <td><?= htmlspecialchars($cliente['nome_cliente']) ?></td>
                <td><?= htmlspecialchars($cliente['email']) ?></td>
                <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                <td>
                    <a href="alterar_cliente.php?id=<?= htmlspecialchars($cliente['id_cliente']) ?>">Alterar</a>
                    <a href="excluir_cliente.php?id=<?= htmlspecialchars($cliente['id_cliente']) ?>" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum cliente encontrado.</p>
    <?php endif; ?>

    <center>
        <address>Nickolas Eger</address>
    </center>
</body>
</html>
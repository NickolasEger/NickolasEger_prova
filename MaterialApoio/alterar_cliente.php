<?php 
session_start();
require_once 'conexao.php';

if($_SESSION['perfil']!=1 && $_SESSION['perfil']!=2) {
    echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
    exit();
}

$cliente = null;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST['busca_cliente'])){
        $busca = trim($_POST['busca_cliente']);

        if(is_numeric($busca)){
            $sql = "SELECT * FROM cliente WHERE id_cliente = :busca_cliente";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca_cliente',$busca,PDO::PARAM_INT);
        } else{
            $sql = "SELECT * FROM cliente WHERE nome_cliente LIKE :busca_nome";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome',"%$busca%",PDO::PARAM_STR);
        }

        $stmt->execute();
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$cliente){
            echo "<script>alert('Cliente não encontrado!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Cliente</title>
    <link rel = "stylesheet" href = "styles.css">
    <script src=scripts.js></script>
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

    <h2>Alterar Cliente</h2>

    <form action="alterar_cliente.php" method="POST">
        <label for="busca_cliente">Digite o ID ou nome do cliente</label>
        <input type="text" id="busca_cliente" name="busca_cliente" required onkeyup="buscarSugestoes()">

        <div id="sugestoes"></div>
        <button type="submit">Buscar</button>
    </form>

    <?php if($cliente): ?>
        <form action="processa_alteracao_cliente.php" method="POST">
            <input type="hidden" name="id_cliente" value="<?=htmlspecialchars($cliente['id_cliente'])?>">

            <label for="nome_cliente">Nome:</label>
            <input type="text" id="nome_cliente" name="nome_cliente" value="<?=htmlspecialchars($cliente['nome_cliente'])?>" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="<?=htmlspecialchars($cliente['email'])?>" required>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" value="<?=htmlspecialchars($cliente['endereco'])?>" required>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="<?=htmlspecialchars($cliente['telefone'])?>" required>

            


            <button type="submit">Alterar</button>
            <button type="reset">Cancelar</button>
        </form>
    <?php endif; ?>
</body>
</html>
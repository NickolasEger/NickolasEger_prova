<?php 
session_start();
require_once 'conexao.php';

//VERIFICA SE O Cliente TEM PERMISSAO
//SUPONDO QUE O 1 SEJA O ADMINISTRADOR   
if($_SESSION['perfil']!=1){
    echo "Acesso Negado!";
    exit;
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $nome_cliente = $_POST['nome'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $id_funcionario_responsavel = $_POST['id_funcionario_responsavel'];
    $telefone = $_POST['telefone'];

    $sql="INSERT INTO cliente(nome_cliente,email,endereco,id_funcionario_responsavel,telefone) VALUES (:nome_cliente,:email,:endereco,:id_funcionario_responsavel,:telefone)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome_cliente',$nome_cliente);
    $stmt->bindParam(':email',$email);
    $stmt->bindParam(':endereco',$endereco);
    $stmt->bindParam(':telefone',$telefone);
    $stmt->bindParam(':id_funcionario_responsavel',$id_funcionario_responsavel);

    if($stmt->execute()){
        echo "<script>alert('Cliente cadastrado com sucesso!');</script>";
    }else{
        echo "<script>alert('Erro ao cadastrar o cliente!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cadastrar Cliente</title>
<link rel="stylesheet" href="styles.css">
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


<h2>Cadastrar Cliente</h2>
<form action="cadastro_cliente.php" method="POST">

    <label for="nome_cliente">Nome:</label>
    <input type="text" id="nome" name="nome" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="endereco">Endereço:</label>
    <input type="text" id="endereco" name="endereco" required>

    <label for="telefone">Telefone:</label>
    <input type="text" id="telefone" name="telefone" required>

    <label for="id_funcionario_responsavel">Funcionario:</label>
    <select id="id_funcionario_responsavel" name="id_funcionario_responsavel">
        <option value="1">Administrador</option>
        <option value="2">Secretaria</option>
        <option value="3">Almoxarife</option>
        <option value="4">Cliente</option>
    </select>

    <button type="submit">Salvar</button>
    <button type="reset">Cancelar</button>
</form>

<center><address>Nickolas Eger</address></center>

</body>
</html>

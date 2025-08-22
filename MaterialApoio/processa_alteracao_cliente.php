<?php
session_start();
require 'conexao.php';

if($_SESSION['perfil'] !=1){
    echo "<script>alert('Acesso Negado!')window.location.href='principal.php';</script>";
    exit();
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $nome_cliente = $_POST['nome_cliente'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $id_funcionario_responsavel = isset($_POST['id_funcionario_responsavel']) ? $_POST['id_funcionario_responsavel'] : null;
    $telefone = $_POST['telefone'];
    $nova_senha = !empty($_POST['nova_senha'])? password_hash($_POST['nova_senha'],PASSWORD_DEFAULT): null;

    
    if($nova_senha){
        $sql = "UPDATE cliente SET nome_cliente = :nome_cliente,email = :email,id_funcionario_responsavel = :id_funcionario_responsavel,endereco = :endereco,telefone = :telefone WHERE id_cliente = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha',$nova_senha);
    } else{
        $sql = "UPDATE cliente SET nome_cliente=:nome_cliente,email=:email,id_funcionario_responsavel=:id_funcionario_responsavel,endereco=:endereco,telefone=:telefone WHERE id_cliente = :id";
        $stmt = $pdo->prepare($sql);
    }
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome_cliente',$nome_cliente);
    $stmt->bindParam(':email',$email);
    $stmt->bindParam(':endereco',$endereco);
    $stmt->bindParam(':telefone',$telefone);
    $stmt->bindParam(':id_funcionario_responsavel',$id_funcionario_responsavel);

    if($stmt->execute()){
        echo "<script>alert('Cliente atualizado com sucesso!')window.location.href='buscar_cliente.php';</script>";
    } else{
        echo "<script>alert('Erro ao atualizar cliente!')window.location.href='alterar_cliente.php?id=$id_cliente';</script>";
    }

}




?>
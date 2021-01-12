<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amigo Secreto - Simples e Facil</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<?php 
    $id = $_GET['id'];


    //Seleciona o nome da pessoa do banco
    $query = 'SELECT pessoa.nome AS pessoaNome, sorteio.codigo AS sorteioId, pessoasorteio.isVisto  FROM pessoasorteio INNER JOIN pessoa';
    $query .= ' ON pessoasorteio.idpessoa = pessoa.codigo';
    $query .= ' INNER JOIN sorteio';
    $query .= ' ON pessoasorteio.idsorteio = sorteio.codigo';
    $query .= ' WHERE pessoasorteio.id=' . $id ;
    //faz conexão com o banco 
    include 'bd.php';
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $nomePessoa = $row['pessoaNome'];
    $nomeSorteio = $row['sorteioId'];
    $javiu = $row['isVisto'];
    //verifica se a pessoa já viu
    if($javiu == null) {
    //Se não viu:
        //Seleciona o nome de todos envolvidos no sorteio que NÃO FORAM SORTEADOS
        $query = 'SELECT pessoa.nome, pessoa.codigo FROM pessoa INNER JOIN pessoasorteio';
        $query .= ' ON pessoa.codigo = pessoasorteio.idpessoa';
        $query .= ' WHERE pessoasorteio.idSorteio = ' .$nomeSorteio;
        $query .= " AND pessoasorteio.isSorteado IS NULL AND pessoa.nome != '".$nomePessoa."'";
        $result = mysqli_query($conn, $query);

        //array para armazenar os nomes das pessoas
        //mete o nome das pinta num array
        $participantes = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
             array_push($participantes, $row);
        }
        //seleciona um número
        $arraySize = count($participantes) - 1;
        $randomNumber = rand(0, $arraySize);

        $amigoSecreto = $participantes[$randomNumber]['nome'];
        $msg = 'O nome do seu amigo secreto é:' .$amigoSecreto;
        //Pega essa pessoa selecionada (o amigo secreto do fulano) e muda o status dela pra SORTEADA
            //primeiro pega o ID do pessoasorteio dele mediante seu código (da tabela pessoa)
            $query = 'SELECT pessoasorteio.id FROM pessoasorteio INNER JOIN pessoa';
            $query .= ' ON pessoasorteio.idpessoa = pessoa.codigo';
            $query .= ' WHERE pessoa.codigo = '. $participantes[$randomNumber]['codigo'];
            $result = mysqli_query($conn, $query);
            $foiSorteado = mysqli_fetch_array($result, MYSQLI_ASSOC);

        //agora com o id do PESSOASORTEIO DELE faz a mudança
        $query = 'UPDATE pessoasorteio SET isSorteado = 1 WHERE pessoasorteio.id = ' .$foiSorteado['id'];
        echo $query;
        mysqli_query($conn, $query);
        //Muda o status do fulano para JÁ VIU O AMIGO SECRETO - Bloqueia link
        $query = 'UPDATE pessoasorteio SET isVisto = 1 WHERE pessoasorteio.id = ' .$id;
        mysqli_query($conn, $query);
    }
    else {
    //Se já viu:
        //mostra uma mensagem que ela já viu o amigo secreto
        $msg = "O nome do seu amigo secreto foi bloqueado pois alguém já aceesou este link!";
    }
?>

<body>
    <div class="meio">
    
    <h3>Olá <?php echo $nomePessoa; ?></h3>

    <p> <?php echo $msg; ?>  </p>
    
    </div>

</body>
</html>
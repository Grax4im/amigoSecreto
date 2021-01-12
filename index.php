<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amigo Secreto - Simples e Rapido</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <?php

        if(isset($_POST['titulo'])) {
            $conec = mysqli_connect("localhost","robertadm","1L5deRbKzt8RFB47","amigosecreto");
            $query = "INSERT INTO sorteio(nome) VALUES('" . $_POST['titulo'] . "')";
            $result = mysqli_query($conec,$query);
            foreach ($_POST['pessoa'] as $pessoa) {

              $query = "INSERT INTO pessoa(nome) VALUES('" .$pessoa . "')";
              $result = mysqli_query($conec,$query);  
            
              $query = "SELECT codigo FROM pessoa WHERE nome = '" . $pessoa . "'";
              $coisarada = mysqli_query($conec,$query);
              $lastIdPessoa = mysqli_fetch_assoc($coisarada);
              
              $query = "SELECT codigo FROM sorteio WHERE nome = '" . $_POST['titulo'] . "'";
              $coisarada = mysqli_query($conec,$query);
              $lastIdSorteio = mysqli_fetch_assoc($coisarada);

              $ids = $lastIdPessoa['codigo'] . ',' . $lastIdSorteio['codigo'];
              $query = "INSERT INTO pessoasorteio(idPessoa, idSorteio) VALUES($ids)";
              $result = mysqli_query($conec,$query);
            }
            $location = 'Location: sorteio.php?nome=' . $_POST['titulo'];
            header($location);
        }

    ?>
    <div class="meio">
        <p class=""></p>
        <form action='index.php' method="POST" > 
            <div class="text-center centrado">
            <img src="img/gift.png" class="gift" alt="Presente">
            <h1>Amigo Secreto Online</h1>
            </div>
            <div>
            <div class="form-group mt-3">
            <input type="name" class="form-control" name='titulo' placeholder="Titulo do Sorteio" required autofocus>
            </div>
            <div class="form-group mt-3">
            <input type="name" class="form-control" placeholder="Nome do participante" name="pessoa[]" required>
            </div>
            <div class="form-group mt-3">       
            <input type="name" class="form-control" placeholder="Nome do participante" name="pessoa[]" required> 
            </div>
            <div class="morePeople"></div>
            <a href="#" class="mt-3 addMore">+ Adicionar mais uma pessoa</a>  
            <button class="btn btn-lg btn-primary btn-block" type="submit">Criar sorteio</button>
        </form>
    </div>
    <script src='js/code.js'>     
    </script>
</body>
</html>
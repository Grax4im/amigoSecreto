<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amigo Secreto - Simples e Rapido</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
<?php 
  $titulo = $_GET['nome'];  
  $conn = mysqli_connect("localhost","robertadm","1L5deRbKzt8RFB47","amigosecreto");
  $query = "SELECT pessoa.nome, pessoasorteio.id ";
  $query .= "FROM pessoa INNER JOIN pessoasorteio ";
  $query .= "ON pessoa.codigo = pessoasorteio.idPessoa ";
  $query .= "INNER JOIN sorteio ";
  $query .= "ON pessoasorteio.idSorteio = sorteio.codigo ";
  $query .= "WHERE sorteio.nome = '";
  $query .= $_GET['nome'] . "'";

  $result = mysqli_query($conn, $query);

?>
    <div class="text-center">
        <div class="meio">
            <img src="img/gift.png" class="gift" alt="Presente">
            <h1>Seu sorteio acaba de ser criado!</h1>
        </div>
        <h4>Compartilhe o link correspondente com cada participante.</h4>
        <div class="container container-fluid">
        <table class="table table-striped table-bordered mt-3 mb-3 text-left">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Link</th>
                </tr>
            </thead>
            <tbody>
                <!-- começa o loop das pessoas e links aqui-->
                <?php
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        $link = 'http://localhost/amigoSecreto/sorteado.php?id='.$row['id'];

                        echo '<tr>';
                        echo '<td>';
                        echo $row['nome'];
                        echo '</td>';
                        echo '<td>';
                        echo "<a href='".$link."'>Clique Aqui</a>";
                        echo '</td>';
                        echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        </div>
        <p>Atenção: cada link só pode ser aberto uma unica vez. Após o participante conhecer o seu amigo secreto, o link
            ficará bloqueado. </p>
        <p>Portanto: não espie o amigo secreto alheio!</p>
    </div>
    <script src='js/code.js'>
    </script>
</body>

</html>
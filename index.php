<?php
    try {
        $pdo = new PDO("mysql:dbname=proj_filtros;host=localhost", "root", "");
    } catch (PDOExpection $e) {
        echo "Erro: " . $e->getMessage();
        exit();
    }
    $sexos = array(
        '0' => "Feminino",
        '1' => "Masculino"
    );
    if (isset($_POST['sexo']) && $_POST['sexo'] != '') {
        $sexo = htmlspecialchars($_POST['sexo']);
        $query = "SELECT * FROM usuarios WHERE sexo = {$sexo}";
        $query = $pdo->prepare($query);
        $query->execute();
    } else {
        $sexo = '';
        $query = "SELECT * FROM usuarios";
        $query = $pdo->prepare($query);
        $query->execute();
    }

    if ($query->rowCount() > 0) {
        $dados = "";
        $query = $query->fetchAll();
        $dados .= '<table border="1" style="width:100%">'; 
        $dados .= '<thead>'; 
        $dados .= '<tr>'; 
        $dados .= '<th>Nome:</th>'; 
        $dados .= '<th>Idade:</th>'; 
        $dados .= '<th>Sexo:</th>'; 
        $dados .= '</tr>'; 
        $dados .= '</thead>'; 
        $dados .= '<tbody>'; 
        foreach ($query as $row) {
            $dados .= '<tr>';
            $dados .= '<td>' . $row['nome'] . '</td>';
            $dados .= '<td>' . $row['idade'] . '</td>';
            $dados .= '<td>' . $sexos[$row['sexo']] . '</td>';
            $dados .= '</tr>';
        }
        $dados .= '</tbody>'; 
        $dados .= '</table>'; 
        flush();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Filtros</title>
</head>
<body>
    <h1>Filtro do usuário:</h1>
    <form action="" method="POST">
        <select name="sexo">
            <option value="">Selecione</option>
            <option value="0" <?php echo ($sexo == '0')?'selected="selected"':''; ?>>Feminino</option>
            <option value="1" <?php echo ($sexo == '1')?'selected="selected"':''; ?>>Masculino</option>
        </select>
        <input type="submit" value="Filtrar">
    </form>

    <hr />
    <?php 
    if (!empty($dados)) {
        echo $dados;
    }
    ?>
</body>
</html>
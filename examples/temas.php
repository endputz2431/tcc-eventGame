<?php
include 'class_adm.php';
include 'class_recompensas.php';

if(!empty($_POST['nomeTema'])){
    $temaInserir = new ADM();

    $nomeTema = $_POST['nomeTema'];
    $propriedadeTema = $_POST['corTema'];
    $custoTema = $_POST['custoTema'];

    $temaInserir->inserirTemas($nomeTema, $propriedadeTema, $custoTema);
}

// fazer exibições de todos os temas
$recompensa = new Recompensa();

$recompensa->vizualizarTemas();
?>

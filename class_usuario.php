<?php
class Usuario{
    public $id;
    public $nome;
    public $email;
    public $senha;
    public $pontuacao;
    public $recompensa;
    public $nivel;
    public $tema;
    public $skin;

    public $pdo;

    public function __construct(){
        $this->pontuacao = 10;
        $this->nivel = 1;
    }

    public function conectarBD(){
        include 'conexaoBDpdoPOO.php';
    }

    public function inserir(){

        try {
            $this->conectarBD();

            $stmt = $this->pdo->prepare("INSERT INTO usuario (nomeUsuario, senhaUsuario, emailUsuario, pontuacaoLUsuario, idRecomensa, nivelUsuario, temaUsuario, skinUsuario) VALUES(:nomeUsuario, :senhaUsuario, :emailUsuario, :pontuacaoLUsuario, :idRecomensa, :nivelUsuario, :temaUsuario, :skinUsuario)");
            $stmt->execute(array(
                ':nomeUsuario' => "$this->nome", ':senhaUsuario' => "$this->senha", ':emailUsuario' => "$this->email", ':pontuacaoLUsuario' => "$this->pontuacao", ':idRecomensa' => $this->recompensa, ':nivelUsuario' => $this-nivel, ':temaUsuario' => 7, ':skinUsuario' => 3
            ));

            echo $stmt->rowCount(); 
            echo"<script>alert('Parabéns, você está cadastrado. Agora efetue o login.');window.location.href = 'index.php';</script>";
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

    public function login(){
        $this->conectarBD();

        $consulta = $this->pdo->query("SELECT * FROM usuario")or die('Erro na busca por usuário');
        $ver = false;
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            if(($_POST["email"] == $linha['emailUsuario']) && (md5($_POST["senha"]) == $linha['senhaUsuario'])){


                $_SESSION['idUsuario'] = $linha['idUsuario'];
                $_SESSION['emailUsuario'] = $linha['emailUsuario'];
                $_SESSION['senhaUsuario'] = $linha['senhaUsuario'];
                $_SESSION['nomeUsuario'] = $linha['nomeUsuario'];
                $_SESSION['pontuacaolUsuario'] = $linha['pontuacaolUsuario'];
                $_SESSION['idRecomensa'] = $linha['idRecomensa'];
                $_SESSION['nivelUsuario'] = $linha['nivelUsuario'];

                // definir qual o tema do usuario
                $this->conectarBD();

                $consultaRecompensa = $this->pdo->query("SELECT * FROM recompensa WHERE idRecomensa = ".$linha['temaUsuario']."");

                while ($linhaRecompensa = $consultaRecompensa->fetch(PDO::FETCH_ASSOC)) {
                    $_SESSION['temaAplicada'] = $linhaRecompensa['nomeReompensa'];
                }

                // definir qual a skin do usuario
                $this->conectarBD();

                $consultaRecompensa1 = $this->pdo->query("SELECT * FROM recompensa WHERE idRecomensa = ".$linha['skinUsuario']."");

                while ($linhaRecompensa1 = $consultaRecompensa1->fetch(PDO::FETCH_ASSOC)) {
                    $_SESSION['skinAplicada'] = $linhaRecompensa1['nomeReompensa'];
                }

                $ver = true;

                // include 'examples/class_notificacao.php';

                // $notificacao = new Notificacao();

                // $texto = 'Bem vindo!';

                // $notificacao->inserirNotificacaoPrivada($texto, $_SESSION['idUsuario']);

                echo "<script language='javascript' type='text/javascript'> alert('Login efetuado com sucesso!');</script>";
                echo "<script>window.location.href = \"examples/pagina_eventos.php\";</script>";
                break;
            }
        }
        if($ver == false){
            echo"<script language='javascript' type='text/javascript'> alert('E-mail ou senha incorretos, ou você não possui cadastro');</script>";
        }
    }
}
?>

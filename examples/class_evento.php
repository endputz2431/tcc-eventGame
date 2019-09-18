<?php
class Evento{
    public $id;
    public $titulo;
    public $idusuario;
    public $data_inicio;
    public $data_fim;
    public $hora_inicio;
    public $hora_fim;
    public $local;
    public $cidade;
    public $estado;
    public $pais;
    public $area_academica;
    public $sobre_evento;

    public $pdo;

    public $busca;

    public function conectarBD(){
        $this->pdo = new PDO('mysql:host=localhost;dbname=id10730896_banco', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function inserir(){

        try {
            $this->conectarBD();

            $stmt = $this->pdo->prepare("INSERT INTO evento (tituloEvento, idUsuario, dataInicioEvento, dataFimEvento, horaInicioEvento, horaFimEvento, localEvento, cidadeEvento, estadoEvento, paisEvento, areaAcademicaEvento, sobreEvento) VALUES(:tituloEvento, :idUsuario, :dataInicioEvento, :dataFimEvento, :horaInicioEvento, :horaFimEvento, :localEvento, :cidadeEvento, :estadoEvento, :paisEvento, :areaAcademicaEvento, :sobreEvento)");

            $stmt->execute(array(
                ':tituloEvento' => "$this->titulo",
                ':idUsuario' => "$this->idusuario",
                ':dataInicioEvento' => "$this->data_inicio",
                ':dataFimEvento' => "$this->data_fim",
                ':horaInicioEvento' => "$this->hora_inicio",
                ':horaFimEvento' => "$this->hora_fim",
                ':localEvento' => "$this->local",
                ':cidadeEvento' => "$this->cidade",
                ':estadoEvento' => "$this->estado",
                ':paisEvento' => "$this->pais",
                ':areaAcademicaEvento' => "$this->area_academica",
                ':sobreEvento' => "$this->sobre_evento"
            ));

            //var_dump($stmt->queryString);
            $stmt->debugDumpParams();
            exit();

            return $this->pdo->lastInsertId();
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return -1;
        }

    }

    public function deletar(){
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=id10120250_banco', 'id10120250_root', 'andre2001');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare('DELETE FROM Usuario WHERE idUsuario = :idUsuario');
            $stmt->bindParam(':idUsuario', $this->id); 
            $stmt->execute();

            echo $stmt->rowCount(); 
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function alterar(){
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=id10120250_banco', 'id10120250_root', 'andre2001');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare('UPDATE Usuario SET nomeUsuario = :nomeUsuario, senhaUsuario = :senhaUsuario, emailUsuario = :emailUsuario WHERE idUsuario = :idUsuario');
            $stmt->execute(array(
                ':idUsuario'   => $this->id,
                ':nomeUsuario' => $this->nome,
                ':senhaUsuario' => $this->senha,
                ':emailUsuario'   => $this->email
            ));

            echo $stmt->rowCount(); 
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function consultarPorUsuario($idanfitriao){
        $this->conectarBD();

        $consulta = $this->pdo->query("SELECT * FROM evento WHERE idUsuario = '$idanfitriao'");

        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {

            $results = $linha['idEvento'];
            $idusuario = $linha['idUsuario'];
            $tituloEvento = $linha["tituloEvento"];
            $sobreEvento = $linha["sobreEvento"];
            $dataInicioEvento = $linha["dataInicioEvento"];
            $dataFimEvento = $linha["dataFimEvento"];
            $horaInicioEvento = $linha["horaInicioEvento"];
            $horaFimEvento = $linha["horaFimEvento"];
            $local = $linha["localEvento"];
            $cidade = $linha["cidadeEvento"];
            $estado = $linha["estadoEvento"];
            $pais = $linha["paisEvento"];
            $area_academica = $linha["areaAcademicaEvento"];

            echo '

            <div class="tab-pane active" id="'.$results.'">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">'.$tituloEvento.'</h4>
                  <p class="card-category">'.$dataInicioEvento." ".$horaInicioEvento.'</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive table-upgrade">
                    <table class="table">
                      <thead>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Anfitrião</td>
                          <td class="text-center">'.$_SESSION['nomeUsuario'].'</td>
                        </tr>
                        <tr>
                          <td>Datas</td>
                          <td class="text-center">'.date('d/m/Y', strtotime($dataInicioEvento)).' até '.date('d/m/Y', strtotime($dataFimEvento)).'</td>
                        </tr>
                        <tr>
                          <td>Horários</td>
                          <td class="text-center">'.date("H:i", strtotime($horaInicioEvento)).' ás '.date("H:i", strtotime($horaFimEvento)).'</td>
                        </tr>
                        <tr>
                          <td>Local</td>
                          <td class="text-center">'.$local.'</td>
                        </tr>
                        <tr>
                          <td>Onde</td>
                          <td class="text-center">'.$cidade.', '.$estado.', '.$pais.'</td>
                        </tr>
                        <tr>
                          <td>Área academica</td>
                          <td class="text-center">'.$area_academica.'</td>
                        </tr>
                        <tr>
                          <td>Sobre</td>
                          <td class="text-center"><a href="#">Ver</a></td>
                        </tr>
                        <tr>

                          <td>Inscritos</td>
                          <td class="text-center">999999(falta)</td>
                        </tr>
                        <tr>
                          <td>Valor inscrição</td>
                          <td class="text-center">FREE(falta)</td>
                        </tr>
                        <tr>
                         <td><a class="nav-link" href="#'.++$results.'">Próximo</a></td>
                          <td class="text-center">
                          <a href="#" style="float:right" class="btn btn-round btn-fill btn-info">Gerenciar</a>
                           <a href="#" class="btn btn-round btn-fill btn-default" style="float:right; margin-right: 3%;">Excluir</a>
                          </td>
                        </tr>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

                 </div>

            ';
        }
    }

    public function consultar(){


        $this->conectarBD();

        $consulta = $this->pdo->query("SELECT * FROM evento");
        echo '<div class="row"  id="rowEvent">';

        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $results = $linha['idEvento'];
            $tituloEvento = $linha["tituloEvento"];
            $sobreEvento = $linha["sobreEvento"];
            $dataInicioEvento = $linha["dataInicioEvento"];
            $dataFimEvento = $linha["dataFimEvento"];
            $horaInicioEvento = $linha["horaInicioEvento"];
            $horaFimEvento = $linha["horaFimEvento"];
            $local = $linha["localEvento"];
            $cidade = $linha["cidadeEvento"];
            $estado = $linha["estadoEvento"];
            $pais = $linha["paisEvento"];
            $area_academica = $linha["areaAcademicaEvento"];

            $this->conectarBD();

            $consultaMissaoEvento = $this->pdo->query("SELECT * FROM missaoevento WHERE idEvento = '$results'");

            while ($linhaMissaoEvento = $consultaMissaoEvento->fetch(PDO::FETCH_ASSOC)) {
                $idMissao = $linhaMissaoEvento['idMissao'];
            }

            $this->conectarBD();

            $consultaMissao = $this->pdo->query("SELECT * FROM missao WHERE idMissao = '$idMissao'");

            while ($linhaMissao = $consultaMissao->fetch(PDO::FETCH_ASSOC)) {
                $tituloMissao = $linhaMissao['tituloMissao'];
                $sobreMissao = $linhaMissao['sobreMissao'];
                $idRecompensa = $linhaMissao['idRecomensa'];
            }

            echo '<div class="col-md-3" id="titulo2">
                <div class="card" style="width: 18rem;height: 400px; overflow: auto;">
                    <div id="corTitulo">
                        <label class="card-title" style="margin-left:7%; margin-top:5%;margin-right:7%"><b>'.$tituloEvento.'</b></label>
                    </div>
                    <div class="card-body" style="overflow: auto;">
                        <p class="card-text"><b>Sobre:</b> '.$sobreEvento.'</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Data de inicio: '.date('d/m/Y', strtotime($dataInicioEvento)).'</li>
                        <li class="list-group-item">Hora de inicio: '.date("H:i", strtotime($horaInicioEvento)).'</li>
                        <li class="list-group-item">Cidade: '.$cidade.'</li>
                    </ul>
                    <div class="card-body">
                        <a id="modal-'.$results.'" href="#modal-container-'.$results.'" role="button" class="btn" data-toggle="modal">Detalhes</a>
					<div class="modal fade" id="modal-container-'.$results.'" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="myModalLabel">
										Evento '.$tituloEvento.'
									</h5> 
									<button type="button" class="close" data-dismiss="modal">
										<span aria-hidden="true">×</span>
									</button>
								</div>
								<div class="modal-body" style="height: 400px; overflow: auto;">
									Sobre<br> <label style="padding-left: 25px;"></label>'.$sobreEvento.'

                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Data de inicio: '.date('d/m/Y', strtotime($dataInicioEvento)).' até '.date('d/m/Y', strtotime($dataFimEvento)).'</li>
                                        <li class="list-group-item">Hora de inicio: '.date("H:i", strtotime($horaInicioEvento)).'</li>
                                        <li class="list-group-item">Hora de fim: '.date("H:i", strtotime($horaFimEvento)).'</li>
                                        <li class="list-group-item">Local: '.$local.'</li>
                                        <li class="list-group-item">Onde: '.$cidade.', '.$estado.', '.$pais.'</li>
                                        <li class="list-group-item">Referente: '.$area_academica.'</li>
                                        <hr>
                                        <li class="list-group-item">Missão: '.$tituloMissao.'</li>
                                        <li class="list-group-item">Sobre: '.$sobreMissao.'</li>
                                        <li class="list-group-item">Recompensa: '.$idRecompensa.'</li>
                                    </ul>
                                    <div class="clearfix"></div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary">
										Inscreva-se
									</button> 
									<button type="button" class="btn btn-secondary" data-dismiss="modal">
										Fechar
									</button>
								</div>
							</div>
						</div>						
					</div>					
                </div>
        </div>';

            echo '</div>';
        }
    }

    public function consultarInscricao($usuario){       
        $this->conectarBD();

        $consulta = $this->pdo->query("SELECT * FROM inscricao WHERE idUsuario = '$usuario'");

        echo "<div class='row'>";

        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {

            $results = $linha['idEvento'];
            $idusuario = $linha['idUsuario'];
            $tipoInscricao = $linha["tipoInscricao"];
            $valorInscricao = $linha["valorInscricao"];
            $pagoInscricao = $linha["pagoInscricao"];

            if($pagoInscricao == 1){
                $situacao = 'Pago';
            } else {
                $situacao = 'Pendente';
            }

            echo "

            <div class='col-lg-4 col-md-6 col-sm-6'>
              <div class='card card-stats'>
               <a href='#' title='".$situacao."'>
                <div class='card-header card-header-success card-header-icon'>
                  <div class='card-icon'>
                    <i class='material-icons'>amp_stories</i>
                  </div>
                  <p class='card-category'>Evento</p>
                  <h3 class='card-title'>R$ ".$valorInscricao."</h3>
                </div>
                <div class='card-footer'>
                  <div class='stats'>
                    <i class='material-icons'>date_range</i> Hora, Data, Cidade
                  </div>
                  <label style='margin-left: 10%'>".$tipoInscricao."</label>
                </div>
                </a>
              </div>
            </div>

            ";
        }

        echo "</div>";
    }

    public function inscricao(){
        try {
            $this->conectarBD();

            $stmt = $this->pdo->prepare("INSERT INTO inscricao(idUsuario, idEvento, tipoInscricao, valorInscricao, pagoInscricao) VALUES (:idUsuario, :idEvento, :tipoInscricao, :valorInscricao, :pagoInscricao)");
            $stmt->execute(array(
                ':idUsuario' => "$idanfitriao",
                ':idEvento' => "$this->id", // fverificar
                ':tipoInscricao' => "", // falta fazer
                ':valorInscricao' => "", // falta fazer
                ':pagoInscricao' => "" // falta fazer
            ));

            echo 'Inscrito';
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return -1;
        }
    }
}
?>
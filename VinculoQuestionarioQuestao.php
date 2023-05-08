<?php 
    $titulo = "Vincular Questões (Questionário ". $_GET['questionarioId']. ")";

    include_once 'verificaElaborador.php';
    include_once 'Fachada.php';
    include_once 'LayoutHeader.php';

    $daoQuestao = $factory->getQuestaoDao();
    $daoQuestionario = $factory->getQuestionarioDao();
    $daoQuestionarioQuestao = $factory->getQuestionarioQuestaoDao();

    $obj = $_GET['questionarioId'];
    $questoes = $daoQuestao->buscaTodos();
    $questoesQuest = $daoQuestionarioQuestao->buscaQuestoesPorQuestionarioId($obj);

    // pega só questões que não estão vinculadas
    $qstsExcept = $daoQuestionarioQuestao->buscaQuestoesExcetoPorQuestionarioId($obj);
    $idQstsExcept = []; 
    foreach ($qstsExcept as $qsts){
        $idQstsExcept["{$qsts->getId()}"] = $qsts->getId();
    }

?>
        <script src="public/js/vinculo.js"></script>
        <script type="text/javascript">
            var idQuestionario = '<?php echo $obj; ?>';
        </script>
        
        <section class="tabela-questoes container my-5">
            <h2>Questões</h2>
            <div class="table-responsive">
            <table id="tabela-vinculo" class="table table-striped table-hover">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Pontos</th>
                        <th>Ordem</th>
                        <th>Vínculo</th>
                        <th>Remover</th>
                    </tr>
                </thead>
                <tbody>
                </th>
                <?php 
                    foreach ($questoes as $questao){               
                        echo '<tr class="table-row">';
                        echo '    <td>'.$questao->getId().'</td>';
                        echo '    <td>'.$questao->getDescricao().'</td>';
                        echo '    <td>'.$questao->getTipo().'</td>';

                        if (!in_array($questao->getId(), $idQstsExcept)){
                            $qQuestao = $daoQuestionarioQuestao->buscaPorIds($obj, $questao->getId());

                            // questoes já vinculadas
                            echo '    <td><input type="number" class="form-control ponto-input" value="'.$qQuestao->getPontos().'" disabled></td>';
                            echo '    <td><input type="number" class="form-control ordem-input" value="'.$qQuestao->getOrdem().'" disabled></td>';
                            echo '    <td><button class="botao-vinculo btn btn-success bg-success-subtle text-black fw-bold" disabled>Vincular</button></td>';
                            echo '    <td><button class="botao-remove-vinculo btn btn-danger bg-danger-subtle text-black fw-bold">Remover</button></td>';
                        } else {
                            // questoes não vinculadas
                            echo '    <td><input type="number" class="form-control ponto-input"></td>';
                            echo '    <td><input type="number" class="form-control ordem-input"></td>';
                            echo '    <td><button class="botao-vinculo btn btn-success bg-success-subtle text-black fw-bold">Vincular</button></td>';
                            echo '    <td><button class="botao-remove-vinculo btn btn-danger bg-danger-subtle text-black fw-bold" disabled>Remover</button></td>';
                        }

                        echo '</tr>';
                }
                ?>
                </tbody>
            </table>  
            </div>
            <div class="d-flex justify-content-center">
                <a href="Menu.php" class="btn btn-primary btn-lg m-4 mx-auto float-center">Prosseguir</a>
            </div>
        </section>
    </body>
</html>


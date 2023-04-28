<?php 
    $titulo = "Vincular Questões (Questionário ". $_GET['questionarioId']. ")";

    include_once 'verificaElaborador.php';
    include_once 'Fachada.php';
    include_once 'LayoutHeader.php';

    $daoQuestao = $factory->getQuestaoDao();
    $daoQuestionario = $factory->getQuestionarioDao();
    $daoQuestionarioQuestao = $factory->getQuestionarioQuestaoDao();

    $questoes = $daoQuestao->buscaTodos();

    $obj = $_GET['questionarioId'];
?>
        <script src="js/vinculo.js"></script>
        <script type="text/javascript">
            var idQuestionario = '<?php echo $obj; ?>';
        </script>
        
        <section class="tabela-questoes container my-5">
            <h2 class="">Questões</h2>
            <table id="tabela-vinculo" class="table table-striped table-hover">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Descricao</th>
                        <th>Tipo</th>
                        <th>Pontos</th>
                        <th>Ordem</th>
                        <th>Adicionar/Remover</th>
                        <th>Vincular</th>
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
                        echo '    <td><input type="number" class="form-control ponto-input" disabled></td>';
                        echo '    <td><input type="number" class="form-control ordem-input" disabled></td>';
                        echo '    <td><button class="botao-vincular btn btn-secondary fw-bold">+</button></td>';
                        echo '    <td><button class="botao-enviar-questao btn btn-primary fw-bold" disabled>></button></td>';
                        echo '</tr>';
                }
                ?>
                </tbody>
            </table>  
            <a href="Menu.php" class="btn btn-primary w-100 btn-lg p-3 mt-4 fw-semibold fs-4">Prosseguir</a>
        </section>
    </body>
</html>


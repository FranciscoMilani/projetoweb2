<?php 
    $titulo = "Vincular Questões (Questionário ". $_GET['questionarioId']. ")";

    include_once 'verificaElaborador.php';
    include_once 'Fachada.php';
    include_once 'LayoutHeader.php';

    $daoQuestao = $factory->getQuestaoDao();
    $questoes = $daoQuestao->buscaTodos();
?>
        <section class="tabela-questoes container my-5">
            <h2 class="">Questões</h2>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Descricao</th>
                        <th>Discursiva</th>
                        <th>Objetiva</th>
                        <th>Multipla escolha</th>
                        <th>Adicionar</th>
                        <th>Remover</th>
                    </tr>
                </thead>
                <tbody>
                </th>
                <?php 
                    foreach ($questoes as $questao){
                        echo '<tr>';
                        echo '    <td>'.$questao->getId().'</td>';
                        echo '    <td>'.$questao->getDescricao().'</td>';
                        echo '    <td>'.$questao->getIsDiscursiva().'</td>';
                        echo '    <td>'.$questao->getIsObjetiva().'</td>';
                        echo '    <td>'.$questao->getIsMultiplaEscolha().'</td>';
                        echo '    <td><button class="btn btn-success fw-bold">+</button></td>';
                        echo '    <td><button class="btn btn-danger fw-bold">-</button></td>';
                        echo '</tr>';
                }
                ?>
                </tbody>
            </table>  
        </section>

        <section class="container my-5 tabela-vinculo">
            <h2 class="">Vincular</h2>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pontos</th>
                        <th>Ordem</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><input type="text"></td>
                        <td><input type="number"></td>
                    </tr>
                </tbody>
            </table>
            <?php 
                echo '<td>teste data</td>';
                echo '<td>teste data</td>';
            ?>
        </section>
    </body>
</html>


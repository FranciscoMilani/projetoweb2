<?php 
    include 'verificaElaborador.php';
    $titulo = "Vincular Questões (Questionário ". $_GET['questionarioId']. ")";
    include 'LayoutHeader.php';

    
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
                        <th>ADD</th>
                        <th>RMV</th>
                    </tr>
                </thead>
                <tbody>
                </th>
                <?php 

                    echo '<tr>';
                    echo '    <td>1</td>';
                    echo '    <td>teste data</td>';
                    echo '    <td>teste data</td>';
                    echo '    <td>teste data</td>';
                    echo '    <td>teste data</td>';
                    echo '    <td><button class="btn btn-success fw-bold">+</button></td>';
                    echo '    <td><button class="btn btn-danger fw-bold">-</button></td>';
                    echo '</tr>';
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


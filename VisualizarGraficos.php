<?php 
    $titulo = "Métricas de Questionários";
    include_once "Fachada.php";
    include_once "LayoutHeader.php";
    include_once "verificaElaborador.php";
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

$(document).ready(function(){
    atualiza_grafico()
})

function atualiza_grafico(){
    $.ajax({
        url: "ConsultaDados.php",
        type: "GET",
        dataType: "json",
    }).done(function(dados){
        mostra_grafico_barra(dados['c1'], 'chart-qtd-ofertas')
        mostra_grafico_barra(dados['c2'], 'chart-qtd-respostas')
        mostra_grafico_pizza(dados['c3'], 'chart-total-pizza')
        //mostra_grafico_barra(dados['c2'], 'chart-porcento-aprovados')
    })
}

function mostra_grafico_barra(dados, contexto){
    const ctx = document.getElementById(contexto);
    const nomes = Object.values(dados.dados).map(item => item.nome);
    const counts = Object.values(dados.dados).map(item => item.count);
    console.log(counts)

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: nomes,
            datasets: [{
                label: dados.label,
                data: counts,
                borderWidth: 1
            }]
        },
        options: {
            events: ['mousemove', 'mouseout', /*'click',*/ 'touchstart', 'touchmove'],
            scales: {
                y: {
                    beginAtZero: true,
                    max: Math.pow(10, String(Object.values(dados.dados)[0]['count']).length),
                }
            },
            scale: {
                ticks: {
                    precision: 0,
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
}



function mostra_grafico_pizza(dados, contexto){
    const ctx = document.getElementById(contexto);
    const nomes = Object.keys(dados);
    const counts = Object.values(dados);

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: nomes,
            datasets: [{
                label: 'Questionários',
                data: counts,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}


</script>

    <body>
        <main>
            <section class="container-fluid" style="margin-top: 50px;">
                <div class="row row-cols-2 justify-content-center">
                    <div class="col-md-5 col-12 card">
                        <div class="p-3">
                            <canvas id="chart-qtd-ofertas" height="300"></canvas>
                        </div>
                    </div>
                    <div style="width: 20px;"></div>
                    <div class="col-md-5 col-12 card">
                        <div class="p-3">
                            <canvas id="chart-qtd-respostas" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div style="height: 20px;"></div>
                <div class="row row-cols-2 justify-content-center">
                    <div class="col-md-5 col-12 card">
                        <input class="form-control mt-2 justify-content-center align-self-center" type="text" placeholder="identificador do questionário">
                        <div class="p-3" style="width:40vw !important">
                            <canvas id="chart-porcento-aprovado" height="300"></canvas>
                        </div>
                    </div>
                    <div style="width: 20px;"></div>
                    <div class="col-md-5 col-12 card">
                        <div class="p-3">
                            <canvas id="chart-total-pizza" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div style="width: 20px;"></div>
            </section>
        </main>
    </body>

</html>
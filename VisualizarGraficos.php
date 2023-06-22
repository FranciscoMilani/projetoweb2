<?php 
    $titulo = "Métricas de Questionários";
    include_once "Fachada.php";
    include_once "LayoutHeader.php";
    include_once "verificaElaborador.php";
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var charts = {}

$(document).ready(function(){
    atualiza_grafico();

    $(".pesquisa-field").keyup(function(e){
        if (e.keyCode === 13){
            atualiza_grafico_input({questionarioId: $(this).val()});            
        }
    })
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
    })
}

function atualiza_grafico_input(dados = ""){
    $.ajax({
        url: "ConsultaDados.php",
        type: "GET",
        dataType: "json",
        data: dados,
    }).done(function(dados){
        destroi_chart('chart-porcento-aprovados')
        // chart = Chart.getChart("chart-porcento-aprovados")
        // if (chart != null) {
        //     chart.destroy();
        // }

        mostra_grafico_pizza(dados['c4'], 'chart-porcento-aprovados')

    })
}

function mostra_grafico_barra(dados, contexto){
    const ctx = document.getElementById(contexto);
    const nomes = Object.values(dados.dados).map(item => item.nome);
    const counts = Object.values(dados.dados).map(item => item.count);

    let chart = new Chart(ctx, {
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

    charts[contexto] = chart;
}



function mostra_grafico_pizza(dados, contexto){
    const ctx = document.getElementById(contexto);
    const nomes = Object.keys(dados);
    const counts = Object.values(dados);

    let chart = new Chart(ctx, {
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

    charts[contexto] = chart;
}


function destroi_chart(chartId){
    var chart = charts[chartId];
    if (chart) {
        chart.destroy();
        delete charts[chartId];
    }
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
                        <input class="pesquisa-field form-control mt-2 justify-content-center align-self-center" type="text" placeholder="id">
                        <div class="p-3" style="width:40vw !important">
                            <canvas id="chart-porcento-aprovados" height="300"></canvas>
                        </div>
                    </div>
                    <div style="width: 20px;"></div>
                    <div class="col-md-5 col-12 card">
                        <div class="p-3">
                            <canvas id="chart-total-pizza" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div style="width: 20px; height: 20px;"></div>
                <div class="row justify-content-center">
                    <div class="col-10 card">
                        <div class="p-3" style="width:40vw !important">
                            <p style="display:block;">texto</p>
                            <p style="display:block;">texto</p>
                            <p style="display:block">texto</p>
                            <p style="display:block">texto</p>
                            <p style="display:block">texto</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        
<?php 
include_once "LayoutFooter.php";
?>
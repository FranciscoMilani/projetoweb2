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
            $(this).blur();
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
        destroi_chart('chart-porcento-aprovados');

        if (dados['c4'] != null){
            mostra_grafico_pizza(dados['c4'], 'chart-porcento-aprovados');     
        }
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
    const canvas = document.getElementById(chartId);
    const context = canvas.getContext('2d');
    const chart = charts[chartId];
    context.clearRect(0, 0, context.width, context.height);
    
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
                        <h5 class="p-3 text-center">Top 10 Questionários por Qtd. Ofertas</h5>
                        <div class="p-3">
                            <canvas id="chart-qtd-ofertas" height="300"></canvas>
                        </div>
                    </div>
                    <div style="width: 20px; height: 20px;"></div>
                    <div class="col-md-5 col-12 card">
                        <h5 class="p-3 text-center">Top 10 Questionários por Qtd. Respostas</h5>
                        <div class="p-3">
                            <canvas id="chart-qtd-respostas" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div style="height: 20px; height: 20px;"></div>
                <div class="row row-cols-2 justify-content-center">
                    <div class="col-md-5 col-12 card">
                        <h5 class="p-3 text-center">Porcento de aprovados/reprovados</h5>
                        <input class="pesquisa-field form-control mt-2 justify-content-center align-self-center" type="text" placeholder="pesquisar id">
                        <div class="p-3" style="width:40vw !important">
                            <canvas id="chart-porcento-aprovados" height="300"></canvas>
                        </div>
                    </div>
                    <div style="width: 20px; height: 20px;"></div>
                    <div class="col-md-5 col-12 card">
                        <h5 class="p-3 text-center">Total de respondidos/não respondidos</h5>
                        <div class="p-3">
                            <canvas id="chart-total-pizza" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div style="width: 20px; height: 20px;"></div>
                <!-- <div class="row justify-content-center" style="margin-bottom: 50px;">
                    <div class="col-10 card">
                        <div class="p-3" style="width:40vw !important">
                            <p>Número de questionários do elaborador:</p>
                            <p>Número de questionários total:</p>
                            <p>Número de questionários total:</p>
                        </div>
                    </div>
                </div> -->
            </section>
        </main>
        
<?php 
include_once "LayoutFooter.php";
?>
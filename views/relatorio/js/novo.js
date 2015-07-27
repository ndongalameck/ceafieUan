


$(document).ready(function () {
    grafico();
    grafico1();
 
    


});

function grafico() {

    $.getJSON('https://localhost/uan/dashboard/dados', function (data) {

        console.log(data)
        var json = $.parseJSON(data);
        var bar4 = new RGraph.Bar({
            id: 'cvs',
            data: json,
            background: {
                grid: {
                    autofit: {
                        numvlines: 5
                    }
                }
            },
            options: {
                colors: ['#2A17B1', '#98ED00', '#E97F02'],
                labels: ['CAP', 'CEPAC', 'CEPID'],
                numyticks: 5,
                ylabels: {
                    count: 5
                },
                hmargin: 15,
                gutter: {
                    left: 35
                },
                variant: '3d',
                strokestyle: 'transparent',
                hmargin: {
                    grouped: 0
                },
                scale: {
                    round: true
                }
            }
        }).draw()

    });

}




function grafico1() {

    $.getJSON('https://localhost/uan/dashboard/dados1', function (data) {

        console.log(data)
        var json = $.parseJSON(data);
        var bar4 = new RGraph.Bar({
            id: 'cvs1',
            data: json,
            background: {
                grid: {
                    autofit: {
                        numvlines: 5
                    }
                }
            },
            options: {
                colors: ['#2A17B1', '#98ED00', '#E97F02'],
                labels: ['Excelente', 'Bom', 'Suficiente'],
                numyticks: 5,
                ylabels: {
                    count: 5
                },
                hmargin: 15,
                gutter: {
                    left: 35
                },
                variant: '3d',
                strokestyle: 'transparent',
                hmargin: {
                    grouped: 0
                },
                scale: {
                    round: true
                }
            }
        }).draw()

    });

}



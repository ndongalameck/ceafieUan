


$(document).ready(function () {
    $("#imagem").hide();
    open();
    saudacao();
//    grafico();
//    grafico1();
    validar();
    editarMatricula1();
    editarDocente1();
    editarCurso1();
    editarModulo1();
    editarPrograma1();
    editarUsuario1();
    editarTema();




});

function notificacao(nome, mensagem, url) {
    $.amaran({
        content: {
            img: url + "views/layout/default/images/gravatar.jpg",
            user: nome,
            message: mensagem
        },
        theme: 'user green',
        position: 'top right',
        closeButton: true,
        cssanimationIn: 'rubberBand',
        cssanimationOut: 'bounceOutUp'
    });

}



function saudacao() {
    $.getJSON('https://localhost/uan/dashboard/listarUsuario', function (data) {
        notificacao(data.nome, data.mensagem, data.url);
    });
}


function open() {

    $(document).on('click', '.click', function () {
        $("#esconder").hide();
        var id = $(this).attr('rel');
        console.log(id);

        $('#imagem').show();
        setTimeout("$('#pageContent').load('" + id + "', function(){ $('#imagem').hide(); });", 1000);
    });
}



function editarTema() {

    $('#tema').change(function () {

        var url = $(this).attr('action');
        var data = $(this).serialize();
        console.log(data);
        $.post(url, data)
                .done(function (data) {
                    var json = $.parseJSON(data);

                    alert(json.mensagem);
                    $(location).attr('href', "https://localhost/uan/login");
                });

        return false;
    });

}






function editar() {

    $(document).on('submit', '#editar', function () {
        var url = $(this).attr('action');
        var data = $(this).serialize();
        console.log(data);
        $.post(url, data)
                .done(function (data) {
                    var json = $.parseJSON(data);

                    alert(json.mensagem);

                });

        return false;
    });

}







function alerta(mensagem) {
    $.amaran({
        content: {
            bgcolor: '#8e44ad',
            color: '#fff',
            message: mensagem
        },
        theme: 'colorful',
        position: 'top right',
        closeButton: true,
        cssanimationIn: 'rubberBand',
        cssanimationOut: 'bounceOutUp'

    });


}

function remover() {

    $(document).on('click', '#remover', function () {
        if (confirm('Pretendes Apagar este Item?')) {
            var id = $(this).attr('rel');
            console.log(id);
            $.post(id)
                    .done(function (data) {
                        alert("Dados apagado com sucesso");

                        //setTimeout("$('#pageContent').load('" + id + "', function(){ $('#imagem').hide(); });", 1000);
                    });
        }
        else {
            return false;
        }
    });
}


function validar() {
    var url = "https://localhost/uan/matricula/index";
    $(document).on('click', '#validar', function () {

        var id = $(this).attr('rel');
        $.post(id)
                .done(function (data) {
                    setTimeout("$('#pageContent').load('" + url + "', function(){ $('#imagem').hide(); });", 1000);
                });


    });
}


function editarMatricula1() {

    $(document).on('click', '#editar1', function () {
        var id = $(this).attr('rel');
        var url = "https://localhost/uan/matricula/editarDados/" + id;
        console.log(id);
        setTimeout("$('#pageContent').load('" + url + "', function(){ $('#imagem').hide(); });", 1000);

    });
}


function editarDocente1() {

    $(document).on('click', '#docente1', function () {
        var id = $(this).attr('rel');
        var url = "https://localhost/uan/docente/editarDados/" + id;
        console.log(url);
        setTimeout("$('#pageContent').load('" + url + "', function(){ $('#imagem').hide(); });", 1000);

    });
}

function editarCurso1() {

    $(document).on('click', '#curso1', function () {
        var id = $(this).attr('rel');
        var url = "https://localhost/uan/curso/editarDados/" + id;
        console.log(url);
        setTimeout("$('#pageContent').load('" + url + "', function(){ $('#imagem').hide(); });", 1000);

    });
}

function editarModulo1() {

    $(document).on('click', '#modulo1', function () {
        var id = $(this).attr('rel');
        var url = "https://localhost/uan/modulo/editarDados/" + id;
        console.log(url);
        setTimeout("$('#pageContent').load('" + url + "', function(){ $('#imagem').hide(); });", 1000);

    });
}

function editarPrograma1() {

    $(document).on('click', '#programa1', function () {
        var id = $(this).attr('rel');
        var url = "https://localhost/uan/programa/editarDados/" + id;
        console.log(url);
        setTimeout("$('#pageContent').load('" + url + "', function(){ $('#imagem').hide(); });", 1000);

    });
}



function editarUsuario1() {

    $(document).on('click', '#usuario1', function () {
        var id = $(this).attr('rel');
        // var url = "https://localhost/uan/usuario/editarDados/" + id;
        console.log(id);
        setTimeout("$('#pageContent').load('" + id + "', function(){ $('#imagem').hide(); });", 1000);

    });
}


//function resetar() {
//    $("form").bind("reset", function () {
//        setTimeout(function () {
//            $('#adicionar').change()
//        }, 150)
//
//    });
//}



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


function pesquisar() {

    $('#pesquisaEstado').change(function () {
        if ($(this).val()) {
            $.getJSON('https://localhost/uan/matricula/pesquisaPor/', {id: $(this).val(), ajax: 'true'}, function (j) {
                console.log(j);
            });
        } else {
            console.log("erro");
        }
    });

}








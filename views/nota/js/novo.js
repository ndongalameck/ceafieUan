
$(document).ready(function () {
    cursos();
    validar();
    modulos();
    modulos1();
    tabela();
    
    var oTable = $('#tabela').dataTable();

    /* Add event listener to the dropdown input */
    $('#ano').blur(function () {

        oTable.fnFilter($(this).val());
    });
    $('#curso').change(function () {
        oTable.fnFilter($(this).val());
    });
    $('#modulo1').change(function () {
        oTable.fnFilter($(this).val());
    });
    docenteMOdulo();
});



function cursos() {

    $.getJSON('https://localhost/uan/curso/pesquisaPor/', {
    }).done(function (data) {
        $.each(data, function (id, valor) {

            $("#curso").append('<option value="' + valor.id + '">' + valor.nome + '</option>');

        });
    });


}



function docenteMOdulo() {

    $.getJSON('https://localhost/uan/nota/pesquisaDocenteNotas/', {
    }).done(function (data) {
        $.each(data, function (id, valor) {

            $("#modulo").append('<option value="' + valor.id + '">' + valor.nome + '</option>');

        });
    });


}

function modulos() {


    $('#curso').change(function () {
        if ($(this).val()) {
            $('#modulo').hide();
            $('.carregando').hide();
            $('.carregando').html("carregando...").show();
            $.getJSON('https://localhost/uan/modulo/pesquisaPor/', {id: $(this).val(), ajax: 'true'}, function (j) {
                var options = '<option value=""></option>';
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
                }
                $('#modulo').html(options).show();
                $('.carregando').hide();
            });
        } else {
            $('#modulo').html('<option value="">-- Escolha um curso --</option>');
        }
    });

}


function modulos1() {


    $('#curso').change(function () {
        if ($(this).val()) {
            $('#modulo1').hide();
            $('.carregando').hide();
            $('.carregando').html("carregando...").show();
            $.getJSON('https://localhost/uan/modulo/pesquisaPor/', {id: $(this).val(), ajax: 'true'}, function (j) {
                var options = '<option value=""></option>';
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].nome + '">' + j[i].nome + '</option>';
                }
                $('#modulo1').html(options).show();
                $('.carregando').hide();
            });
        } else {
            $('#modulo1').html('<option value="">-- Escolha um curso --</option>');
        }
    });
}


function tabela() {


    $('#tabela').dataTable({
        "pagingType": "full_numbers",
        "sDom": '<"H"Tlfr>t<"F"ip>',
        "oTableTools": {
            "sRowSelect": "multi",
            "aButtons": ["copy", "csv", "xls", "pdf", "print"]
        },
        "bDestroy": true,
        "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0, 1]
            }],
        "aLengthMenu": [[5, 10, 25, 50, 75, -1], [5, 10, 25, 50, 75, "All"]],
        "iDisplayLength": 5,
        "bJQueryUI": true,
        "oLanguage": {"sLengthMenu":
                    "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch": "Pesquisar: ",
            "oPaginate": {"sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"},
            "oFilterSelectedOptions": {
                AllText: "All Widgets",
                SelectedText: "Selected Widgets"
            }

        },
        "aaSorting": [[0, 'desc']],
        "aoColumnDefs": [{"sType": "num-html", "aTargets": [0]},
        ]

    });
}




/** * Função para criar um objeto XMLHTTPRequest */
function CriaRequest() {
    try {
        request = new XMLHttpRequest();
    }
    catch (IEAtual) {
        try {
            request = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (IEAntigo) {

            try {
                request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (falha) {
                request = false;
            }
        }
    }

    if (!request)
        alert("Seu Navegador não suporta Ajax!");
    else
        return request;
}
/** * Função para enviar os dados */

function getDados(elemento) {
    // Declaração de Variáveis

    var acao = $('#' + elemento).attr('id');
    var ano = document.getElementById("ano").value;
    var imagem = document.getElementById("img").value;
    var modulo = $("#modulo").val();

    var result = document.getElementById("conteudo");
    var xmlreq = CriaRequest();
    // Exibi a imagem de progresso 
    result.innerHTML = '<img src="' + imagem + '"/>';
    // Iniciar uma requisição


    xmlreq.open("POST", "https://localhost/uan/nota/pesquisarPor/" + acao + '/' + modulo + '/' + ano + '/', true);
    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function () {
        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {

            // Verifica se o arquivo foi encontrado com sucesso 
            if (xmlreq.status == 200) {
                result.innerHTML = xmlreq.responseText;
                tabela();

            }

            else {
                result.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };

    xmlreq.send(null);


}


function getTodos(elemento) {

    var acao = $('#' + elemento).attr('id');

    var result = document.getElementById("conteudo");
    var imagem = document.getElementById("img").value;
    var xmlreq = CriaRequest();
    // Exibi a imagem de progresso 
    result.innerHTML = '<img src="' + imagem + '"   class="img-circle"/>';
    // Iniciar uma requisição


    xmlreq.open("POST", "https://localhost/uan/nota/pesquisarPor/" + acao + '/', true);
    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function () {
        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {

            // Verifica se o arquivo foi encontrado com sucesso 
            if (xmlreq.status == 200) {
                result.innerHTML = xmlreq.responseText;
                tabela();

            }

            else {
                result.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };

    xmlreq.send(null);


}


function validar() {
    $("#buscar").validate({
        rules: {
            ano: {
                required: true,
                number: true

            },
            curso: {
                required: true,
            },
            modulo: {
                required: true,
            }

        }
    });

}





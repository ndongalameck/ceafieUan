
$(document).off('.data-api');
$(document).off('.alert.data-api')
$(document).ready(function () {
    teste();
    validar();
    validaEditar();
    cursos();
    modulos();
    tabela();
    remover();

    extras();


});



function extras() {

    var bootstrapButton = $.fn.button.noConflict() // return $.fn.button to previously assigned value
    $.fn.bootstrapBtn = bootstrapButton            // give $().bootstrapBtn the Bootstrap functionality
    var oTable = $('#tabela').dataTable();
    $('#curso').change(function () {
        oTable.fnFilter($(this).val());
    });
    $(".modal1").click(function () {
        var id = $(this).attr('rel');

        $.getJSON('https://localhost/uan/docente/detalhes/', {id: id, ajax: 'true'}, function (data) {

            $("#myModal").modal('show');
            var html;
            $.each(data, function (id, valor) {

                $("#conteudo").append('<p>' + valor.nome + '</p>');
            });

            var url = 'localhost/uan/docente/index';
            $("#fechar").click(function () {
                $(location).attr('href', '');

            });
        });
    });
}



function teste() {

    $.getJSON('https://localhost/uan/docente/preencherSelect/', {
    }).done(function (data) {


        var json = JSON.parse(JSON.stringify(data));
        console.log(json);
        var grupos = {};
        var select = document.getElementById("dados");
        json.forEach(function (data) {

            var grupo = data.nome1;
            console.log(grupo);
            if (!grupos[grupo]) {
                var optG = document.createElement('optgroup');
                optG.label = data.nome1;
                select.appendChild(optG);
                var g = {
                    data: [],
                    el: optG
                }
                grupos[grupo] = g;
                g.data.push(data);
            }
            var option = document.createElement('option');
            option.value = data.id;
            option.innerHTML = data.nome;
            grupos[grupo].el.appendChild(option);
        });
        $("#dados").multipleSelect({
            multiple: true,
            multipleWidth: 255,
            width: '100%',
            position: 'top',
            selectAll: false
        });
    });
}




function cursos() {



    $.getJSON('https://localhost/uan/curso/pesquisaPor/', {
    }).done(function (data) {

        $.each(data, function (id, valor) {

            $("#curso").append('<option value="' + valor.id + '">' + valor.nome + '</option>');
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
                console.log(j);
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




function remover() {
    var url = "https://localhost/uan/docente/remover";
    $(document).on('click', '#remover', function () {
        if (confirm('Pretendes Apagar este Item?')) {
            var id = $(this).attr('rel');
            console.log(id);
            $.post(id)
                    .done(function (data) {
                        alert("Dados apagado com sucesso");
                        $(location).attr('href', url);
                    });
        }
        else {
            return false;
        }
    });
}


function modal(id) {

    BootstrapDialog.show({
        closable: false,
        message: function (dialog) {
            var $message = $('<div></div>');
            var pageToLoad = dialog.getData('pageToLoad');
            $message.load(pageToLoad);

            return $message;
        },
        data: {
            'pageToLoad': 'https://localhost/uan/docente/informacao/' + id
        },
        cssClass: 'login-dialog',
        buttons: [{
                cssClass: 'btn btn-primary',
                label: 'Lecionar em novo curso',
                action: function (dialogItself) {
                    dialogItself.close();
                    $(location).attr('href', 'https://localhost/uan/docente/addCurso/' + id);

                }
            },
//            {
//                cssClass: 'btn btn-info',
//                label: 'Imprimir Ficha',
//                action: function (dialogItself) {
//                    dialogItself.close();
//                    $(location).attr('href', 'https://localhost/uan/docente/imprimirFicha/' + id);
//
//                }
//            }
            {
                cssClass: 'btn btn-danger',
                label: 'Fechar',
                action: function (dialogItself) {
                    dialogItself.close();
                    $(location).attr('href', 'https://localhost/uan/docente/');
                }


            },
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



function getDados(elemento) {
    // Declaração de Variáveis

    var acao = $('#' + elemento).attr('id');
    var imagem = document.getElementById("img").value;
    var curso = $("#curso").val();

    var result = document.getElementById("conteudo");
    var xmlreq = CriaRequest();
    // Exibi a imagem de progresso 
    result.innerHTML = '<img src="' + imagem + '"/>';
    // Iniciar uma requisição


    xmlreq.open("POST", "https://localhost/uan/docente/pesquisaPor/" + acao + '/' + curso + '/', true);
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

    xmlreq.open("POST", "https://localhost/uan/docente/pesquisaPor/" + acao + '/', true);
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

    $("#adicionar").validate({
        rules: {
            nome: {
                required: true,
                minlength: 3

            },
            apelido: {
                required: true,
                minlength: 3
            },
            genero: {
                required: true

            },
            bi: {
                required: true,
                minlength: 14,
                maxlength: 14,
            },
            nacionalidade: {
                required: true,
                minlength: 4
            },
            telefone: {
                required: true,
                number: true,
                minlength: 9,
                maxlength: 9

            },
            email: {
                required: true,
                email: true
            },
            grau: {
                required: true
            },
            dados: {
                required: true
            },
        },
        messages: {
            bi: {minlength: "exemplo 235467891LA034"},
            telefone: {minlength: "exemplo 932345678"},
            apelido: {minlength: "obrigat&oacute;rio."},
        }
    });

}


function validaEditar() {
    $("#editar").validate({
        rules: {
            nome: {
                required: true,
                minlength: 3

            },
            apelido: {
                required: true,
                minlength: 3
            },
            genero: {
                required: true

            },
            bi: {
                required: true,
                minlength: 14,
                maxlength: 14,
            },
            nacionalidade: {
                required: true,
                minlength: 4
            },
            telefone: {
                required: true,
                number: true,
                minlength: 9,
                maxlength: 9

            },
            email: {
                required: true,
                email: true
            },
            grau: {
                required: true
            },
            dados: {
                required: true
            },
        },
        messages: {
            bi: {minlength: "exemplo 235467891LA034"},
            telefone: {minlength: "exemplo 932345678"},
            apelido: {minlength: "obrigat&oacute;rio."},
        }
    });

}





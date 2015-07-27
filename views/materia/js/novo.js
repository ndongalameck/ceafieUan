
$(document).ready(function () {
    tabela();
    cursos();
    modulos();
    validar();
    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
    $('#data').datepicker({
        format: "dd/mm/yyyy",
        language: "pt-BR",
        startDate: today,
        clearBtn: true,
    });

});

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


function pesquisar() {

    $(document).on('submit', '#pesquisar', function () {
        cursos();
        var url = $(this).attr('action');
        var data = $(this).serialize();
        console.log(data);
        $.post(url, data)
                .done(function (data) {
                });
        return false;
    });
    $('#pesquisar').each(function () {
        this.reset();
    });
}


function resetar() {
    $("form").bind("reset", function () {
        setTimeout(function () {
            $('#curso').change()
        }, 50)

        setTimeout(function () {
            $('#modulo').change()
        }, 50)

    });
}

//function alerta(mensagem) {
//    $.amaran({
//        content: {
//            bgcolor: '#8e44ad',
//            color: '#fff',
//            message: mensagem
//        },
//        theme: 'colorful',
//        position: 'top right',
//        closeButton: true,
//        cssanimationIn: 'rubberBand',
//        cssanimationOut: 'bounceOutUp'
//
//    });
//}



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

function validar() {
    $("#adicionar").validate({
        rules: {
            curso: {
                required: true,
            },
            modulo: {
                required: true,
            },
            docente: {
                required: true,
            },
            inicio: {
                required: true,
            },
            arquivo: {
                required: true,
            },
            data: {
                required: true,
                 dateBR: true
            }


        }
    });

}




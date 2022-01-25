

 $(document).ready(function () {
  $('#table').DataTable( {
      "order": [[ 0, "desc" ]],
      "createdRow": function( row, data, dataIndex ) {
       if ( data["9"] == "<label>Si</label>" ) {
        
           $( row ).css( "background-color", "#ffcdd2  " );
           
       }
   },
  } );
});
 $(document).ready(function () {
   $('#table2').DataTable( {
       "order": [[ 0, "desc" ]],
       "createdRow": function( row, data, dataIndex ) {
        if ( data["9"] == "<label>Si</label>" ) {
         
            $( row ).css( "background-color", "#ffcdd2  " );
            
        }
    },
   } );
 });


 
  $(document).ready(function () {
    $('#tableProgramadas').DataTable( {
        "order": [[ 0, "desc" ]],
    } );
  });
  
$( document ).ready(function() {
  var rowCount = $('#table2').DataTable();
     $("#TareasGeneradas").text(rowCount.rows().count());
  var rowCount2 = $('#table').DataTable();
      $("#TareasAsignadas").text(rowCount2.rows().count());

      var rowCount3 = $('#tableProgramadas').DataTable();
      $("#TareasAsignadasProgramadas").text(rowCount3.rows().count());
});


    $(document).ready(function () {
      $('.VerModalTareaDesglosada').click(function () {
        var TaskIDShow = $(this).attr("id");
        $('#ModalTareaCompleta').modal("show");
        $.ajax({
            data: { TaskIDShow: TaskIDShow },
            url: 'Classes/Querys.php',
            type: 'post',
            dataType: 'JSON',
            success: function (data) {
              $('#txtUserAsignadorDeTareaShow').val(data[0].Asignador);
              $('#txtTituloShow').val(data[0].TituloTarea);
              $('#txtDescripcionShow').val(data[0].Descripcion);
              $('#txtAsignadoShow').val(data[0].Asignado);
              $('#txtFechaLimiteShow').val(data[0].FechaLimite);
            }
          });
      });
    });

    $(document).ready(function () {
      $('.TerminarTarea').click(function () {
        var TaskIDToTerminate = $(this).attr("id");
        $('#ModalTerminarTarea').modal("show");
        document.getElementById("TaskID1260").value = TaskIDToTerminate;
      });
    });

    $(document).ready(function () {
      $('.VerModalTareaProgramadaDesglosada').click(function () {
        var TaskProgrammedIDShow = $(this).attr("id");
        $('#ModalTareaProgramadaCompleta').modal("show");
        $.ajax({
            data: { TaskProgrammedIDShow: TaskProgrammedIDShow },
            url: 'Classes/Querys.php',
            type: 'post',
            dataType: 'JSON',
            success: function (data) {
              $('#txtUserAsignadorDeTareaShowProgramada').val(data[0].Asignador);
              $('#txtTituloShowProgramada').val(data[0].TituloTarea);
              $('#txtDescripcionShowProgramada').val(data[0].Descripcion);
              $('#txtAsignadoShowProgramada').val(data[0].Asignado);
              $('#txtFechaInicioShowProgramada').val(data[0].FechaDeProximoEvento);
              $('#txtFrecuenciaProgramada').val(data[0].Frecuencia);
            }
          });
      });
    });


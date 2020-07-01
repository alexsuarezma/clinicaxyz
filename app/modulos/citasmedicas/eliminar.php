

<?php
 
 $id_citas= $_GET['Id'];


include 'conexion.php ';

 $sql_el="UPDATE citas set estado='Cancelado' where idcitas=$id_citas ";
 mysqli_query($conexion,$sql_el);

     echo ("<script LANGUAGE='JavaScript'>
    window.alert('Consulta cancelada exitosamente ');
    window.location.href='citas.php';
    </script>");
?>
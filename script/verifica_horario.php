<?php
    require_once('../config.php');

    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $data_agendamento = $_POST['date'];
    $sala = $_POST['sala'];
    
    $query = "SELECT * FROM horario h WHERE h.id_horario  NOT IN (SELECT id_horario 
    FROM agendamento a WHERE a.data_agendamento='$data_agendamento' AND a.id_sala=$sala); ";

    $result = mysqli_query($con,$query);
    if (mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            echo '<option value="' . $row[0] . '">'. $row[1].'</option>';
        }
    } else{
        echo '<p>Não temos horário disponível para esse dia nesta sala.</p>';
    }
    
    mysqli_close( $con );
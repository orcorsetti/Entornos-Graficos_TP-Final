<?php
    require("../../database/db.php");
    try{
        require_once ('../../vendor/autoload.php');
        if(isset($_POST['importConsults'])){
            $failedUpdates = [];
            if($_FILES['consultsFile']['error'] == UPLOAD_ERR_OK){
                $allowedFileType = [
                    'application/vnd.ms-excel',
                    'text/xls',
                    'text/xlsx',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ];
                if (in_array($_FILES["consultsFile"]["type"], $allowedFileType)){
                    $uploads_dir = "../../uploads";
                    $tmp_name = $_FILES['consultsFile']['tmp_name'];
                    $name = basename($_FILES['consultsFile']['name']);
                    move_uploaded_file($tmp_name,"$uploads_dir/$name");
    
                    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify("$uploads_dir/$name");
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                    $reader -> setReadDataOnly(true);
    
                    $spreadsheet = $reader->load("$uploads_dir/$name");
                    $worksheet = $spreadsheet -> getActiveSheet();
    
                    $rows = $worksheet-> toArray();
                    foreach ($rows as $row) {
                        if($row[0] !== NULL || $row[1] !== NULL || $row[2] !== NULL || $row[3] !== NULL || $row[4] !== NULL){
                            $insert = true;
                            if(count($row) !== 5){
                                    array_push($failedUpdates, $row);
                                    $insert = false;
                                }
                            $query = "SELECT * FROM mat_doc WHERE cod_mat=$row[0] AND dni=$row[1]";
                            $result = $conn-> query($query);
                            if($result -> num_rows == 0){
                                if(controlaDependencias($row, $conn)){
                                    $query = "INSERT INTO mat_doc(cod_mat, dni) VALUES ($row[0], $row[1])";
                                    $conn -> query($query);
                                    if($conn->errno){
                                        throw new Exception("Error al insertar los datos en la base de datos: ".$conn->error);
                                    }
                                } else{
                                    array_push($failedUpdates, $row);
                                    $insert = false;
                                }
                            }
                            if($insert){
                                $query = "SELECT * FROM consultas WHERE cod_mat='$row[0]' AND dni='$row[1]'";
                                $result = $conn->query($query);
                                if($result -> num_rows == 0) {
                                    $query = "INSERT INTO consultas(lugar, hora, dia_semana, cod_mat, dni) VALUES ('$row[4]', '$row[3]', '$row[2]', '$row[0]', '$row[1]')";
                                } else {
                                    $query = "UPDATE consultas SET lugar= '$row[4]' , hora = '$row[3]', dia_semana = '$row[2]' WHERE cod_mat = '$row[0]' AND dni = '$row[1]'";
                                }
                                $conn -> query($query);
                                if($conn->errno){
                                    throw new Exception("Error al insertar los datos: ".$conn->error);
                                }
                            }
                        }
                    }
                    if(count($failedUpdates) == 0){
                        $_SESSION['message'] = "Se han actualizado/creado todas las consultas correctamente";
                        $_SESSION['message-type'] ="success";
                    } elseif (count($failedUpdates) == count($rows)){
                        $_SESSION['updateError'] = "Ningun registro se completo correctamente";
                    } else {
                        $_SESSION['message'] = "Algunos registros no se han actualizado correctamente";
                        $_SESSION['message-type'] = "warning";
                        $_SESSION['failedUpdates'] = $failedUpdates;
                    }
                }          
            }
        } else {
            throw new Exception("Falta un campo requerido");
        }
        header('Location: '.$namespace.'views/admins/update_classes.php');
    }catch(Exception $ex){
            $_SESSION['updateError'] = $ex -> getMessage();
            header('Location: '.$namespace.'views/admins/update_classes.php');
        }

function controlaDependencias($row, $conn){
    $validate = true;
    $query = "SELECT * FROM materias WHERE cod_mat = '$row[0]'";
    $result = $conn -> query($query);
    if($result -> num_rows < 1){
        $validate = false;
    }
    $query = "SELECT * FROM docentes WHERE dni = '$row[1]'";
    $result = $conn -> query($query);
    if($result -> num_rows < 1){
        $validate = false;
    }
    return $validate;
}
?>
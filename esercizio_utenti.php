<?php
include('include/database.php');

$action = 'lista';
if(isset($_GET['action'])){
    $action = $_GET['action'];
}

$id = 0;
if(isset($_REQUEST['id'])){
    $id = filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);
}

switch($action){
    case 'lista':
        $strhtml = crea_lista();
        break;
    case 'dettaglio':
        $strhtml = visualizza_dettaglio();
        break;
    case 'form':
        $strhtml = crea_form();
        break;
    case 'salva':
        $strhtml = salva();
        break;
    case 'elimina':
        $strhtml = elimina();
        break;
    default:
        $strhtml = crea_lista();
        break;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>Utenti</title>
</head>
<body class="m-4">
    <?php 
        if(isset($errore) && $errore ==1){
            echo $msgError;
        }
    ?>

    <div class="container d-flex flex-column mx-auto">
        <?php echo $strhtml; ?>
    </div>


    <!--Script Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <!--Script jQuery-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script>
        function elimina(id){
            
            var scelta = window.confirm('Sei sicuro di voler eliminare l\'utente?');
            if(scelta){
                location.href='?action=elimina&id='+id;
            }
           
        }
    </script>
</body>
</html>

<?php
//Funzioni:

function crea_lista(){
    global $db, $id;
    $search = '%';
    if(isset($_GET['search'])){
        $search = '%'. $_GET['search'] .'%';
    }
        $strhtml = '<div class="mx-auto">';
        $strhtml .= '<h2 class="text-center mb-4">Lista utenti</h2>';
        $strhtml .= '<form class="m-4" action="?action=lista" method="GET">';
        $strhtml .= '<div class="col-md-8 d-flex flex-end mx-auto">';
        $strhtml .= '<input class="form-control me-2" type="search" name="search" placeholder="Cerca utenti" value="'.str_replace('%','',$search).'">&nbsp;';
        $strhtml .= '<input type="submit" class="btn btn-success" value="Cerca">';
        $strhtml .= '</div>';
        $strhtml .= '</form>';
        $strhtml .= '<table class="table">';
        $strhtml .= '<thead>';
        $strhtml .= '<tr>';
        $strhtml .= '<th>ID</th>';
        $strhtml .= '<th>Nome</th>';
        $strhtml .= '<th>Cognome</th>';
        $strhtml .= '<th>Email</th>';
        $strhtml .= '</tr>';
        $strhtml .= '</thead>';
        $strhtml .= '<tbody>';
        $sql = 'SELECT id, nome, cognome, email FROM utenti WHERE nome like :search OR cognome like :search';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':search', $search, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() == 0) {
            $strhtml .= '<tr>';
            $strhtml .= '<td colspan="6">Nessun utente disponibile con i criteri di ricerca usati</td>';
            $strhtml .= '</tr>';
        } elseif($stmt->rowCount() == 1){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            header('location: ?action=dettaglio&id='.$row['id']);
        } else{
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $strhtml .= '<tr>';
                $strhtml .= '<td>'.$row['id'].'</td>';
                $strhtml .= '<td>'.$row['nome'].'</td>';
                $strhtml .= '<td>'.$row['cognome'].'</td>';
                $strhtml .= '<td>'.$row['email'].'</td>';
                $strhtml .= '<td><a class="btn btn-primary text-decoration-none" href="?action=dettaglio&id='.$row['id'].'">Scopri di più</a></td>';
                $strhtml .= '<td><a class="btn btn-warning text-decoration-none" href="?action=form&id='.$row['id'].'">Modifica</a></td>';
                $strhtml .= '<td><a id="eliminaUtente" class="btn btn-danger text-decoration-none" href="javascript:elimina('.$row['id'].')">Elimina</a></td>';
                $strhtml .= '</tr>';
            }
        }
        $strhtml .= '</tbody>';
        $strhtml .= '</table>';
        $strhtml .= '<div class="d-grid gap-2 col-4 mx-auto mt-4">';
        $strhtml .= '<a href="?action=form" class="btn btn-success">Aggiungi nuovo utente</a>';
        $strhtml .= '</div>';
    return ($strhtml);
}

function visualizza_dettaglio(){
    global $db, $id;
    $sql = 'SELECT * FROM utenti WHERE id = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $strhtml = '<div class="mx-auto text-center">';
    $strhtml .= '<h3>Dettaglio utente</h3>';
    $strhtml .= '<p class="text-dark fs-3">'.$row['nome'].' '.$row['cognome'].'<p>';
    $strhtml .= '</div>';
    $strhtml .= '<div class="mx-auto">';
    $strhtml .= '<div class="card shadow-sm" style="width: 18rem;">';
    $strhtml .= '<img src="https://picsum.photos/200" class="card-img-top" alt="foto-personale">';
    $strhtml .= '<div class="card-body">';
    $strhtml .= '<div class="card-text">';
    $strhtml .= '<p><strong>Email: </strong>'.$row['email'].'</p>';
    //$strhtml .= '<p><strong>Password: </strong>'.$row['pass'].'</p>';
    $strhtml .= '<p><strong>Indirizzo: </strong>'.$row['via_indirizzo'].' '.$row['indirizzo'].' '.$row['numero_indirizzo'].'</p>';
    $strhtml .= '<p><strong>Città: </strong>'.$row['city'].'</p>';
    $strhtml .= '<p><strong>Data di nascita: </strong>'.$row['data_nascita'].'</p>';
    $strhtml .= '<p><strong>Sesso: </strong>'.$row['sesso'].'</p>';
    $strhtml .= '<p><strong>Abilitazione: </strong>'.$row['abilitazione'].'</p>';
    $strhtml .= '</div>';
    $strhtml .= '</div>';
    $strhtml .= '</div>';
    $strhtml .= '</div>';

    return ($strhtml);
} 

function crea_form(){
    global $db, $id;
    $sql = 'SELECT * FROM utenti WHERE id = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    if($stmt->rowCount() == 0){ 
        $row['nome'] = '';
        $row['cognome'] = '';
        $row['email'] ='';
        $row['pass'] = '';
        $row['via_indirizzo'] = '';
        $row['indirizzo'] = '';
        $row['numero_indirizzo'] = '';
        $row['city'] = '';
        $row['data_nascita'] = '';
        $row['sesso'] = '';
        $row['abilitazione'] = '';
    } else{
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    $strhtml = '<div class="container mx-auto">';
    $strhtml .= '<h3 class="mb-4 text-center">Compila il form per <br>aggiungere/modificare un utente</h3>';
    $strhtml .= '<form action="?action=salva" method="POST">';
    $strhtml .= '<div class="col-md-8 d-flex flex-column mx-auto">';
    $strhtml .= '<input type="hidden" name="id" value="'.$id.'">';
    $strhtml .= '<div class="mb-3 row">';
    $strhtml .= '<label class="col-sm-2 col-form-label">Nome</label>';
    $strhtml .= '<div class="col-sm-10">';
    $strhtml .= '<input type="text" name="nome" class="form-control" value="'.$row['nome'].'" placeholder="Inserisci il nome">';
    $strhtml .= '</div>';
    $strhtml .= '</div>';
    $strhtml .= '<div class="mb-3 row">';
    $strhtml .= '<label class="col-sm-2 col-form-label">Cognome</label>';
    $strhtml .= '<div class="col-sm-10">';
    $strhtml .= '<input type="text" name="cognome" class="form-control" value="'.$row['cognome'].'" placeholder="Inserisci il cognome">';
    $strhtml .= '</div>';
    $strhtml .= '</div>';
    $strhtml .= '<div class="mb-3 row">';
    $strhtml .= '<label class="col-sm-2 col-form-label">Email</label>';
    $strhtml .= '<div class="col-sm-10">';
    $strhtml .= '<input value="'.$row['email'].'" type="email" name="email" class="form-control" placeholder="Inserisci la tua email">';
    $strhtml .= '</div>';
    $strhtml .= '</div>';
    $strhtml .= '<div class="mb-3 row">';
    $strhtml .= '<label class="col-sm-2 col-form-label">Password</label>';
    $strhtml .= '<div class="col-sm-10">';
    $strhtml .= '<input type="password" name="pass" class="form-control" placeholder="******">';
    $strhtml .= '</div>';
    $strhtml .= '</div>';
    $strhtml .= '<div class="mb-3 row">';
    $strhtml .= '<label class="col-sm-2 col-form-label">Indirizzo</label>';
    $strhtml .= '<div class="col-sm-10 d-flex justify-content-between">';
    $strhtml .= '<div>';
    $strhtml .= '<select name="via_indirizzo" class="form-select" aria-label="Default select example">';
    if($row['via_indirizzo'] == 'via'){
        $strhtml .= '<option value="via" selected>via</option>';
    } else{
        $strhtml .= '<option value="via">via</option>';
    }
    if($row['via_indirizzo'] == 'viale'){
        $strhtml .= '<option value="viale" selected>viale</option>';
    } else{
        $strhtml .= '<option value="viale">viale</option>';
    }
    if($row['via_indirizzo'] == 'corso'){
        $strhtml .= '<option value="corso" selected>corso</option>';
    } else{
        $strhtml .= '<option value="corso">corso</option>';
    }
    if($row['via_indirizzo'] == 'piazza'){
        $strhtml .= '<option value="piazza" selected>piazza</option>';
    } else{
        $strhtml .= '<option value="piazza">piazza</option>';
    }
    if($row['via_indirizzo'] == 'altro'){
        $strhtml .= '<option value="altro" selected>altro</option>';
    } else{
        $strhtml .= '<option value="altro">altro</option>';
    }
    $strhtml .= '</select>';
    $strhtml .= '</div>';
    $strhtml .= '<div class="flex-grow-1 mx-1">';
    $strhtml .= '<input type="text" name="indirizzo" class="form-control" value="'.$row['indirizzo'].'" placeholder="Inserisci il indirizzo">';
    $strhtml .= '</div>';
    $strhtml .= '<div>';
    $strhtml .= '<input type="text" name="numero_indirizzo" class="form-control" value="'.$row['numero_indirizzo'].'" placeholder="Numero civico">';
    $strhtml .= '</div>';
    $strhtml .= '</div>';
    $strhtml .= '</div>';
    $strhtml .= '<div class="mb-3 row">';
    $strhtml .= '<label class="col-sm-2 col-form-label">Città</label>';
    $strhtml .= '<div class="col-sm-10">';
    $strhtml .= '<input type="text" name="city" class="form-control" value="'.$row['city'].'" placeholder="Inserisci la città">';
    $strhtml .= '</div>';
    $strhtml .= '</div>';
    $strhtml .= '<div class="mb-3 row">';
    $strhtml .= '<label class="col-sm-2 col-form-label">Data di nascita</label>';
    $strhtml .= '<div class="col-sm-10">';
    $strhtml .= '<input type="date" name="data_nascita" value="'.$row['data_nascita'].'" class="form-control">';
    $strhtml .= '</div>';
    $strhtml .= '</div>';
    $strhtml .= '<div class="mb-3 row">';
    $strhtml .= '<label class="col-sm-2 col-form-label">Sesso</label>';
    $strhtml .= '<div class="col-sm-10">';
    $strhtml .= '<select name="sesso" class="form-select" aria-label="Default select example">';
    $strhtml .= '<option selected>Seleziona il sesso</option>';
    if($row['sesso'] == 'M'){
        $strhtml .= '<option value="M" selected>M</option>';
    } else{
        $strhtml .= '<option value="M">M</option>';
    }
    if($row['sesso'] == 'F'){
        $strhtml .= '<option value="F" selected>F</option>';
    } else{
        $strhtml .= '<option value="F">F</option>';
    }
    if($row['sesso'] == 'N/A'){
        $strhtml .= '<option value="N/A" selected>N/A</option>';
    } else{
        $strhtml .= '<option value="N/A">N/A</option>';
    }
    $strhtml .= '</select>';
    $strhtml .= '</div>';
    $strhtml .= '</div>';
    $strhtml .= '<div class="mb-3 row">';
    $strhtml .= '<label class="col-sm-2 col-form-label">Abilitazione</label>';
    $strhtml .= '<div class="col-sm-10">';
    $strhtml .= '<select name="abilitazione" class="form-select" aria-label="Default select example">';
    if($row['abilitazione'] == 'SI'){
        $strhtml .= '<option value="SI" selected>SI</option>';
    } else{
        $strhtml .= '<option value="SI">SI</option>';
    }
    if($row['abilitazione'] == 'NO'){
        $strhtml .= '<option value="NO" selected>NO</option>';
    } else{
        $strhtml .= '<option value="NO">NO</option>';
    }
    $strhtml .= '</select>';
    $strhtml .= '</div>';
    $strhtml .= '</div>'; 
    $strhtml .= '<div class="d-grid gap-2 col-6 mx-auto">';
    $strhtml .= '<button type="submit" class="btn btn-outline-success">Invia</button>';
    $strhtml .= '</div>';
    $strhtml .= '</div>';
    $strhtml .= '</form>';
    $strhtml .= '</div>';
    
    return ($strhtml);
}

function salva(){
    global $db, $id;
    $nome = trim($_POST['nome']);
    $cognome = trim($_POST['cognome']);
    $via_indirizzo = trim($_POST['via_indirizzo']);
    $indirizzo = trim($_POST['indirizzo']);
    $numero_indirizzo = trim($_POST['numero_indirizzo']);
    $city = trim($_POST['city']);
    $email = trim($_POST['email']);
    $pass = trim($_POST['pass']);
    $data_nascita = trim($_POST['data_nascita']);
    $sesso = trim($_POST['sesso']);
    $abilitazione = trim($_POST['abilitazione']);

    $errore=0;
    $msgError= '<div class="alert alert-danger">';

        
    $test = controlla_caratteri($nome);
    if (!$test) {
        $errore = 1;
        $msgError .= '<p>Errore: sono consentiti sono i caratteri a-z e A-Z e le cifre 0-9</p>';
    }
    
    if(controlla_lunghezza($nome, 3)){
        $errore = 1;
        $msgError.= '<p>Errore: la lunghezza del nome deve essere di almeno 2 caratteri!</p>';
    }
      
    if(controlla_lunghezza($cognome, 3)){
        $errore = 1;
        $msgError.= '<p>Errore: la lunghezza del cognome deve essere di almeno 2 caratteri!</p>';
    }

    $test = controlla_caratteri($cognome);
    if (!$test) {
        $errore = 1;
        $msgError .= '<p>Errore: sono consentiti sono i caratteri a-z e A-Z e le cifre 0-9</p>';
    }

    if(controlla_lunghezza($pass, 8)){
        $errore = 1;
        $msgError.= '<p>Errore: la lunghezza della password deve essere di almeno 8 caratteri!</p>';
    }

    $test = controlla_caratteri($pass);
    if(!$test){
        $errore = 1;
        $msgError .= '<p>Errore: sono consentiti sono i caratteri a-z e A-Z e le cifre 0-9</p>';
    }

    $test = controlla_caratteri($indirizzo);
    if(!$test){
        $errore = 1;
        $msgError .= '<p>Errore: sono consentiti sono i caratteri a-z e A-Z e le cifre 0-9</p>';
    }

    $test = controlla_caratteri($via_indirizzo);
    if(!$test){
        $errore = 1;
        $msgError .= '<p>Errore: sono consentiti sono i caratteri a-z e A-Z e le cifre 0-9</p>';
    }

    $test = controlla_caratteri($numero_indirizzo);
    if (!$test) {
        $errore = 1;
        $msgError .= '<p>Errore: sono consentiti sono i caratteri a-z e A-Z e le cifre 0-9</p>';
    }


    $test = controlla_caratteri($abilitazione);
    if(!$test){
        $errore = 1;
        $msgError.= '<p>Errore nel campo "Abilitazione"</p>';
    }

    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errore =1;
        $msgError .= '<p>Errore nel campo "Email"</p>';
    }


    if(!validateDate($data_nascita)){
        $errore = 1;
        $msgError .= '<p>Errore nel campo "Data"</p>';
    }

    $msgError .= '</div>';

    if($errore == 0){
        if($id == 0){
            $pass = password_hash($pass, PASSWORD_BCRYPT);
            $sql = 'INSERT INTO utenti(nome, cognome, via_indirizzo, indirizzo, numero_indirizzo, city, email, pass, data_nascita, sesso, abilitazione) VALUES(:nome, :cognome, :via_indirizzo, :indirizzo, :numero_indirizzo, :city, :email, :pass, :data_nascita, :sesso, :abilitazione)';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':cognome', $cognome, PDO::PARAM_STR);
            $stmt->bindParam(':via_indirizzo', $via_indirizzo, PDO::PARAM_STR);
            $stmt->bindParam(':indirizzo', $indirizzo, PDO::PARAM_STR);
            $stmt->bindParam(':numero_indirizzo', $numero_indirizzo, PDO::PARAM_STR);
            $stmt->bindParam(':city', $city, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
            $stmt->bindParam(':data_nascita', $data_nascita, PDO::PARAM_STR);
            $stmt->bindParam(':sesso', $sesso, PDO::PARAM_STR);
            $stmt->bindParam(':abilitazione', $abilitazione, PDO::PARAM_STR);
            $stmt->execute();
            $strhtml = '<div class="alert alert-success d-grid gap-2 col-6 mx-auto text-center">Utente inserito con successo! <br><a class="alert-link" href="?acion=lista">Torna alla lista</a></div>';
        } else {
            $pass = password_hash($pass, PASSWORD_BCRYPT);
            $sql = 'UPDATE utenti SET nome = :nome, cognome = :cognome, via_indirizzo = :via_indirizzo, indirizzo = :indirizzo, numero_indirizzo = :numero_indirizzo, city = :city, email = :email, pass = :pass, data_nascita = :data_nascita, sesso = :sesso, abilitazione = :abilitazione WHERE id = :id LIMIT 1';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':cognome', $cognome, PDO::PARAM_STR);
            $stmt->bindParam(':via_indirizzo', $via_indirizzo, PDO::PARAM_STR);
            $stmt->bindParam(':indirizzo', $indirizzo, PDO::PARAM_STR);
            $stmt->bindParam(':numero_indirizzo', $numero_indirizzo, PDO::PARAM_STR);
            $stmt->bindParam(':city', $city, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
            $stmt->bindParam(':data_nascita', $data_nascita, PDO::PARAM_STR);
            $stmt->bindParam(':sesso', $sesso, PDO::PARAM_STR);
            $stmt->bindParam(':abilitazione', $abilitazione, PDO::PARAM_STR);
            $stmt->execute();

            $strhtml = '<div class="alert alert-success d-grid gap-2 col-6 mx-auto text-center">Utente modificato con successo! <br><a class="alert-link" href="?acion=lista">Torna alla lista</a></div>';
        }
    } else {
        $strhtml = $msgError;
    }

    return ($strhtml);
}

function elimina(){
    global $db, $id;
    $sql = 'DELETE FROM utenti WHERE id = :id LIMIT 1';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    header('location: esercizio_utenti.php');

    return ($strhtml);
}

function controlla_caratteri($str){
    $pattern = '/^[a-zA-Z0-9 ]{1,100}$/';
    $esito = preg_match($pattern, $str);
    return ($esito);
}


function controlla_lunghezza($str, $minlength){
    $prova = strlen(trim($str)) < $minlength;
    return $prova;
}

function validateDate($data_nascita, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $data_nascita);
    return $d && $d->format($format)===$data_nascita;
}
?>
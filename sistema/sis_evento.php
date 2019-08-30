<?php
session_start();
require "sessao_time.php"; 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sem título</title>
<link href="../css/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript">
function formatar(mascara, documento) {
  var i = documento.value.length;
  var saida = mascara.substring(0, 1);
  var texto = mascara.substring(i);
  if (texto.substring(0, 1) != saida) {
    documento.value += texto.substring(0, 1);
    }
}
</script>
<style>
body {
	background-color: transparent;
}
</style>
</head>

<body>
<div id="container">
<?php
  require '../processos/config.php';
  require '../processos/connection.php';
  require '../processos/database.php';


  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
  //RECEBE DADOS DO FORMULARIO
  $date = explode('/', test_input($_POST["data"])); 

  $titulo_evento = test_input($_POST["titulo"]);
  $data_evento = $date[2].'-'.$date[1].'-'.$date[0];
  $hora_evento = test_input($_POST["hora"]);
  $detalhe_evento = test_input($_POST["detalhe"]);

  $evento = array (
    'evento' => $titulo_evento,
	'data' => $data_evento,
	'hora' => $hora_evento,
	'obs' => $detalhe_evento
  );
  
  ///echo "<pre>";
  //print_r($evento); exit;

  $grava = DBCreate('agenda', $evento);
  
  
  if ($grava) {
    echo "<script> alert('Cadastrado com sucesso!') </script>";
    echo "<script>location.href=('sis_evento.php')</script>";
  }
  else { 
    echo "Erro ao cadastrar, tente novamente mais tarde!";
    exit;
    }
}
  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
<center>
<table width="80%" border="0" cellspacing="3" cellpadding="0">
  <tbody>
  <tr>
      <td height="67" colspan='2' align="CENTER">INSERIR EVENTO</td>

    </tr
    ><tr>
      <td width="133" colspan='2'>Titulo:
      	<input type="text" name="titulo" class="contato" style="width: 98%;">
      </td>
    </tr>
    <tr>
    	<td height="46">Data do Evento:<br />
            <input type="text" name="data" class="contato" maxlength="10" placeholder="dd/mm/aaaa" onkeyup="formatar('##/##/####', this, event)" style="width: 95%;">
        </td>
        <td height="46">Horário do Evento:<br />
            <input type="text" name="hora" class="contato" maxlength="5" placeholder="00:00" onkeyup="formatar('00:00', this, event)" style="width: 96%;">
        </td>
    </tr>
    <tr>
    	<td height="46" colspan='2'>Detalhe do Evento:
        <textarea name="detalhe" class="contato" id="" style="width: 98%; height: 150px;" ></textarea>
      </td>
    </tr>
    <tr>
      <td height="64" align="center" valign="middle" colspan='2'>
      	<input type="submit" class="button" value="Inserir" >
      </td>
    </tr>
  </tbody>
</table>
</center>
</form>
</div>
</body>
</html>

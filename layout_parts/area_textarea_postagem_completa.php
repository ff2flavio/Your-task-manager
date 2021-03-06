<?php foreach($usuario->colecaoUsuarioTarefasWhere("tarefas.id",$id) as $listar):
/**
* Apresenta determinadas legendas de acordo com a situação da tarefa
*/
$iconiSituacaoTarefa = "";
if ($listar->situacao == "1")
{
	$iconiSituacaoTarefa = "Pendente.";
}
elseif ($listar->situacao == "2")
{
	$iconiSituacaoTarefa = "Sendo Feita";
}
elseif ($listar->situacao == "3")
{
	$iconiSituacaoTarefa = "Feita";
}

/**
* Busca o nome do usuario a quem a tarefa foi atribuida
*/
foreach($usuario->listarWhere("id",$listar->vinculoUsuario) as $list)
{
	$_nomeDoUsuarioTarefaAtibuida = $list->nome;
}
?>
<section class="areas apresenta-tarefas">

<h1 class="h1-title-tarefas"><?php echo $listar->titulo; ?></h1>
<div class="info-areas">
<b>Tarefa atribuída ao usuário:</b> <?php echo $_nomeDoUsuarioTarefaAtibuida; ?></small> ( por ) <small><?php echo $listar->nome; ?><br>
<b>Cadastrada em:</b> <small><?php echo $listar->tarefasDataDoCadastro; ?></small> <br>
<b>Situação:</b> <small><?php echo $iconiSituacaoTarefa; ?></small> <br>
<hr>
<p><?php echo nl2br($listar->texto); ?></p>
</div><!-- end info areas -->

</section>
<div class="footer-areas">
<?php 
/**
* Para o usuario nivel "1" mostra o "editar e deletar" de todas as tarefas cadastradas
*/
if ($_SESSION["perfil"] == "1"):
?>
 
 <a href="editar_tarefas.php?editar&id=<?php echo $listar->idTarefas;?>" class="editar" title="Editar essa Tarefa">Editar</a> |
 <a href="tarefa_controller.php?deletar&id=<?php echo $listar->idTarefas;?>" class="deletar" title="Deletar essa Tarefa">Deletar</a> |
 <small>Tarefa criada por: <?php echo $listar->nome; ?></small>

<?php endif; ?>

<?php 
/**
* Para o usuario com perfil nivel "2" mostra apenas o "editar e deletar" das tarefas cadastradas por ele
*/
if ($listar->criadorDaTarefa == $_SESSION["idUsuario"])
{
	if ($_SESSION["perfil"] != "1")
	{
?>

<a href="editar_tarefas.php?editar&id=<?php echo $listar->idTarefas;?>" class="editar" title="Editar essa Tarefa">Editar</a> |
<a href="tarefa_controller.php?deletar&id=<?php echo $listar->idTarefas;?>" class="deletar" title="Deletar essa Tarefa">Deletar</a> |
<small>Tarefa criada por: <?php echo $listar->nome; ?></small>

<?php 
 } /*End primeiro if*/
} /*End segundo if*/
?>
</div><!-- end footer areas -->

<?php endforeach; ?>

<script>
	var deletar = $(".deletar");
	deletar.click( function() {
		var confirmar = confirm("Deseja realmente deletar essa Tarefa?");
		if (confirmar) {
			return true;
		} else {
			return false;
		}
	})
</script>
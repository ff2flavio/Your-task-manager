<?php 
class TarefasModel
{
	protected $titulo;
	protected $texto;
	protected $vinculoUsuario;
	protected $dataCadastro;
	protected $situacao;
	protected $dataAcao;
	protected $criadorDaTarefa;
	private $tableName = "tarefas";
	private $db;

	public function __construct(ConexaoInterface $conexao)
	{
		$this->db = $conexao->connect();
	}

	/**
    * Set´s: setting the attributes
    */

    public function setTitulo($titulo)
    {
    	$this->titulo = $titulo;
    }
    public function setTexto($texto)
    {
    	$this->texto = $texto;
    }
    public function setVinculoUsuario($vinculo)
    {
    	$this->vinculoUsuario = $vinculo;
    }
    public function setDataCadastro($data)
    {
    	$this->dataCadastro = $data;
    }
    public function setSituacao($situacao)
    {
    	$this->situacao = $situacao;
    }
    public function setDataAcao($dataAcao)
    {
        $this->dataAcao = $dataAcao;
    }
    public function setCriadorDaTarefa($criadorDaTarefa)
    {
    	$this->criadorDaTarefa = $criadorDaTarefa;
    }

    public function listar()
    {
    	$query = $this->db->prepare("select * from {$this->tableName} order by id desc, dataCadastro desc");
    	$query->execute();
    	return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function listarTarefasWhere($campo, $valor)
    {
        if ($campo == "id" or $campo == "vinculoUsuario" or $campo == "criadorDaTarefa")
        {
            $campo = (int) $valor;
        }

        $query = $this->db->prepare("select * from {$this->tableName} where {$campo} = ?");
        $query->execute(array($valor));
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function cadastrarTarefa()
    {
        $cadastrar = $this->db->prepare("insert into {$this->tableName} (titulo, texto, vinculoUsuario, dataCadastro, situacao, criadorDaTarefa) values(?,?,?,?,?,?)");
        $cadastrar->execute(array($this->titulo, $this->texto, $this->vinculoUsuario, $this->dataCadastro, $this->situacao, $this->criadorDaTarefa));
        return $cadastrar;
    }

    public function editar($id)
    {
        $id = (int) $id;
        $editar = $this->db->prepare("update {$this->tableName} set titulo = ?, texto = ?, vinculoUsuario = ?, situacao = ?, dataAcao = ? where id = ?");
        $editar->execute(array($this->titulo, $this->texto, $this->vinculoUsuario, $this->situacao, $this->dataAcao, $id));
        return $editar;
    }

    public function editarApenasVinculoUsuario($idTarefa, $vinculoNovoUsuario)
    {
        $id = (int) $idTarefa;
        $editar = $this->db->prepare("update {$this->tableName} set vinculoUsuario = ? where id = ?");
        $editar->execute(array($vinculoNovoUsuario, $idTarefa));
        return $editar;
    }

    public function editarApenasCriadorDaTarefa($idTarefa, $novoCriador)
    {
        $id = (int) $idTarefa;
        $editar = $this->db->prepare("update {$this->tableName} set criadorDaTarefa = ? where id = ?");
        $editar->execute(array($novoCriador, $idTarefa));
        return $editar;
    }

    public function deletar($id)
    {
        $id = (int) $id;
        $deletar = $this->db->prepare("delete from {$this->tableName} where id = ?");
        return $deletar->execute(array($id));
    }
}
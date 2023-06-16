<?php

include_once('RespondenteDao.php');
include_once('PostgresDao.php');

class PostgresRespondenteDao extends PostgresDao implements RespondenteDao
{

    private $table_name = 'respondente';

    public function insere($respondente)
    {

        $query = "INSERT INTO " . $this->table_name .
            " (login, senha, nome, email, telefone) VALUES" .
            " (:login, :senha, :nome, :email, :telefone)";

        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindParam(":login", $respondente->getLogin());
        $stmt->bindParam(":senha", md5($respondente->getSenha()));
        $stmt->bindParam(":nome", $respondente->getNome());
        $stmt->bindParam(':email', $respondente->getEmail());
        $stmt->bindParam(':telefone', $respondente->getTelefone());

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    }

    public function removePorId($id)
    {
        $query = "DELETE FROM " . $this->table_name .
            " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindParam(':id', $id);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function remove($respondente)
    {
        return removePorId($respondente->getId());
    }

    public function altera($respondente)
    {

        $query = "UPDATE " . $this->table_name .
            " SET id = :id, login = :login, senha = :senha, nome = :nome, email = :email, telefone = :telefone" .
            " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindParam(":id", $respondente->getId());
        $stmt->bindParam(":login", $respondente->getLogin());
        $stmt->bindParam(":senha", md5($respondente->getSenha()));
        $stmt->bindParam(":nome", $respondente->getNome());
        $stmt->bindParam(':email', $respondente->getEmail());
        $stmt->bindParam(':telefone', $respondente->getTelefone());

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function buscaPorId($id)
    {

        $respondente = null;

        $query = "SELECT
                    id, login, nome, senha, email, telefone
                FROM
                    " . $this->table_name . "
                WHERE
                    id = ?
                LIMIT
                    1 OFFSET 0";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $respondente = new Respondente($row['id'], $row['login'], $row['senha'], $row['nome'], $row['email'], $row['telefone']);
        }

        return $respondente;
    }

    public function buscaPorLogin($login)
    {

        $respondente = null;

        $query = "SELECT
                    id, login, nome, senha, email, telefone
                FROM
                    " . $this->table_name . "
                WHERE
                    login = ?
                LIMIT
                    1 OFFSET 0";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $login);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $respondente = new Respondente($row['id'], $row['login'], $row['senha'], $row['nome'], $row['email'], $row['telefone']);
        }

        return $respondente;
    }

    public function buscaTodos()
    {

        $respondentes = array();

        $query = "SELECT
                    id, login, senha, nome, email, telefone
                FROM
                    " . $this->table_name .
            " ORDER BY id ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $respondentes[] = new Respondente($id, $login, $senha, $nome, $email, $telefone);
        }

        return $respondentes;
    }

    public function buscaPorNome($nome)
    {
        $respondentes = array();

        $stmt = $this->conn->prepare("SELECT id, login, nome, senha, email, telefone
        FROM " . $this->table_name . "
        WHERE LOWER(nome) LIKE LOWER(:nome) OR LOWER(email) LIKE LOWER(:email)");

        $stmt->bindValue(':nome', '%' . $nome . '%', PDO::PARAM_STR);
        $stmt->bindValue(':email', '%' . $nome . '%', PDO::PARAM_STR);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $respondentes[] = new Respondente($row['id'], $row['login'], $row['senha'], $row['nome'], $row['email'], $row['telefone']);
        }

        return $respondentes;
    }

    public function buscaPorNomePaginado($nome, $limit, $offset)
    {
        $respondentes = array();

        $stmt = $this->conn->prepare(
            "SELECT id, login, nome, senha, email, telefone
                FROM {$this->table_name}
                WHERE LOWER(nome) LIKE LOWER(:nome) OR LOWER(email) LIKE LOWER(:nome)
                ORDER BY nome, email ASC
                LIMIT :limit OFFSET :offset"
        );

        $stmt->bindValue(':nome', '%' . $nome . '%', PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit);
        $stmt->bindValue(':offset', $offset);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $respondentes[] = new Respondente($row['id'], $row['login'], $row['senha'], $row['nome'], $row['email'], $row['telefone']);
        }
        return $respondentes;
    }

    public function contaComNome($nome)
    {
        $query = "SELECT COUNT(*) as contagem
                  FROM {$this->table_name}
                  WHERE LOWER(nome) LIKE LOWER(:nome) OR LOWER(email) LIKE LOWER(:nome)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':nome', '%' . $nome . '%', PDO::PARAM_STR);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            return $contagem;
        }

        return 0;
    }
    public function buscaInfosApiPorId($id)
    {
        $respondente = null;

        $query = "SELECT i.id, i.login, i.nome, i.senha, i.email, i.telefone, k.questionarioid
                  FROM {$this->table_name} i
                  INNER JOIN oferta k
                  ON  i.id = :id
                  AND i.id = k.respondenteid";


        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $respondente = new Respondente($row['id'], $row['login'], $row['senha'], $row['nome'], $row['email'], $row['telefone']);
            $aux[] = $row['questionarioid'];
            var_dump($aux[0]);
            foreach ($aux as $questionario){

            }
        }

        return $respondente;
    }

    public function buscaRespondenteJSON($id)
    {
        $resp = $this->buscaPorId($id);
        if ($resp != null) {
            return stripslashes(json_encode($resp->getDadosParaJSON(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        } else {
            return null;
        }
    }

    public function buscaRespondentesJSON()
    {
        $respondentes = $this->buscaTodos();
        $respJSON = array();
        foreach ($respondentes as $resp) {
            $respJSON[] = $resp->getDadosParaJSON();
        }
        return stripslashes(json_encode($respJSON, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
?>
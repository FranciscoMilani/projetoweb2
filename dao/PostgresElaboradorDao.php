<?php

include_once('ElaboradorDao.php');
include_once('PostgresDao.php');

class PostgresElaboradorDao extends PostgresDao implements ElaboradorDao
{

    private $table_name = 'elaborador';

    public function insere($elaborador)
    {

        $query = "INSERT INTO " . $this->table_name .
            " (login, senha, nome, email, instituicao, isadmin) VALUES" .
            " (:login, :senha, :nome, :email, :instituicao, :isadmin)";

        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindParam(":login", $elaborador->getLogin());
        $stmt->bindParam(":senha", md5($elaborador->getSenha()));
        $stmt->bindParam(":nome", $elaborador->getNome());
        $stmt->bindParam(":email", $elaborador->getEmail());
        $stmt->bindParam(":instituicao", $elaborador->getInstituicao());
        $stmt->bindParam(":isadmin", $elaborador->getIsAdmin(), PDO::PARAM_INT);

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

    public function remove($elaborador)
    {
        return $this->removePorId($elaborador->getId());
    }

    public function altera($elaborador)
    {

        $query = "UPDATE " . $this->table_name .
            " SET id = :id, login = :login, senha = :senha, nome = :nome, email = :email, instituicao = :instituicao, isadmin = :isadmin" .
            " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindParam(":id", $elaborador->getId());
        $stmt->bindParam(":login", $elaborador->getLogin());
        $stmt->bindParam(":senha", md5($elaborador->getSenha()));
        $stmt->bindParam(":nome", $elaborador->getNome());
        $stmt->bindParam(':email', $elaborador->getEmail());
        $stmt->bindParam(":instituicao", $elaborador->getInstituicao());
        $stmt->bindParam(":isadmin", $elaborador->getIsAdmin(), PDO::PARAM_INT);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function buscaPorId($id)
    {

        $elaborador = null;

        $query = "SELECT
                    id, login, nome, senha, email, instituicao, isAdmin
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
            $elaborador = new Elaborador($row['id'], $row['login'], $row['senha'], $row['nome'], $row['email'], $row['instituicao'], $row['isAdmin']);
        }

        return $elaborador;
    }

    public function buscaPorLogin($login)
    {
        $elaborador = null;

        $query = "SELECT id, login, nome, senha, email, instituicao, isadmin
                  FROM {$this->table_name}
                  WHERE login = :login 
                  LIMIT 1 OFFSET 0 ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':login', $login);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $elaborador = new Elaborador($row['id'], $row['login'], $row['senha'], $row['nome'], $row['email'], $row['instituicao'], $row['isadmin']);
        }

        return $elaborador;
    }

    public function buscaTodos()
    {

        $elaboradores = array();

        $query = "SELECT
                    id, login, senha, nome, email, instituicao, isadmin
                FROM
                    " . $this->table_name .
            " ORDER BY id ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $elaboradores[] = new Elaborador($id, $login, $senha, $nome, $email, $instituicao, $isadmin);
        }

        return $elaboradores;
    }

    public function buscaPorNome($nome)
    {
        $elaboradores = array();

        $stmt = $this->conn->prepare("SELECT id, login, nome, senha, email, instituicao, isadmin
        FROM " . $this->table_name . "
        WHERE LOWER(nome) LIKE LOWER(:nome) OR LOWER(email) LIKE LOWER(:email)");

        $stmt->bindValue(':nome', '%'.$nome.'%', PDO::PARAM_STR);
        $stmt->bindValue(':email', '%'.$nome.'%', PDO::PARAM_STR);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $elaboradores[] = new Elaborador($row['id'], $row['login'], $row['senha'], $row['nome'], $row['email'], $row['instituicao'], $row['isadmin']);
        }
        return $elaboradores;
    }
}
?>
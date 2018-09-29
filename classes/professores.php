<?php
/**
 * Created by PhpStorm.
 * User: aluno
 * Date: 28/09/2018
 * Time: 19:14
 */

class professores
{
    private $id_professor;
    private $nome_professor;
    private $cargo_professor;

    /**
     * professores constructor.
     * @param $id_professor
     * @param $nome_professor
     * @param $cargo_professor
     */
    public function __construct($id_professor, $nome_professor, $cargo_professor)
    {
        $this->id_professor = $id_professor;
        $this->nome_professor = $nome_professor;
        $this->cargo_professor = $cargo_professor;
    }

    /**
     * @return mixed
     */
    public function getIdProfessor()
    {
        return $this->id_professor;
    }

    /**
     * @param mixed $id_professor
     */
    public function setIdProfessor($id_professor): void
    {
        $this->id_professor = $id_professor;
    }

    /**
     * @return mixed
     */
    public function getNomeProfessor()
    {
        return $this->nome_professor;
    }

    /**
     * @param mixed $nome_professor
     */
    public function setNomeProfessor($nome_professor): void
    {
        $this->nome_professor = $nome_professor;
    }

    /**
     * @return mixed
     */
    public function getCargoProfessor()
    {
        return $this->cargo_professor;
    }

    /**
     * @param mixed $cargo_professor
     */
    public function setCargoProfessor($cargo_professor): void
    {
        $this->cargo_professor = $cargo_professor;
    }


}
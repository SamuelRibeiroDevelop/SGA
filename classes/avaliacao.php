<?php
/**
 * Created by PhpStorm.
 * User: aluno
 * Date: 28/09/2018
 * Time: 19:42
 */

class avaliacao
{
    private $idAvaliacao;
    private $curso;
    private $turma;
    private $aluno;
    private $nota1;
    private $nota2;
    private $notaFinal;

    /**
     * avaliacao constructor.
     * @param $idAvaliacao
     * @param $curso
     * @param $turma
     * @param $aluno
     * @param $nota1
     * @param $nota2
     * @param $notaFinal
     */
    public function __construct($idAvaliacao, $curso, $turma, $aluno, $nota1, $nota2, $notaFinal)
    {
        $this->idAvaliacao = $idAvaliacao;
        $this->curso = $curso;
        $this->turma = $turma;
        $this->aluno = $aluno;
        $this->nota1 = $nota1;
        $this->nota2 = $nota2;
        $this->notaFinal = $notaFinal;
    }

    /**
     * @return mixed
     */
    public function getIdAvaliacao()
    {
        return $this->idAvaliacao;
    }

    /**
     * @param mixed $idAvaliacao
     */
    public function setIdAvaliacao($idAvaliacao): void
    {
        $this->idAvaliacao = $idAvaliacao;
    }

    /**
     * @return mixed
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * @param mixed $curso
     */
    public function setCurso($curso): void
    {
        $this->curso = $curso;
    }

    /**
     * @return mixed
     */
    public function getTurma()
    {
        return $this->turma;
    }

    /**
     * @param mixed $turma
     */
    public function setTurma($turma): void
    {
        $this->turma = $turma;
    }

    /**
     * @return mixed
     */
    public function getAluno()
    {
        return $this->aluno;
    }

    /**
     * @param mixed $aluno
     */
    public function setAluno($aluno): void
    {
        $this->aluno = $aluno;
    }

    /**
     * @return mixed
     */
    public function getNota1()
    {
        return $this->nota1;
    }

    /**
     * @param mixed $nota1
     */
    public function setNota1($nota1): void
    {
        $this->nota1 = $nota1;
    }

    /**
     * @return mixed
     */
    public function getNota2()
    {
        return $this->nota2;
    }

    /**
     * @param mixed $nota2
     */
    public function setNota2($nota2): void
    {
        $this->nota2 = $nota2;
    }

    /**
     * @return mixed
     */
    public function getNotaFinal()
    {
        return $this->notaFinal;
    }

    /**
     * @param mixed $notaFinal
     */
    public function setNotaFinal($notaFinal): void
    {
        $this->notaFinal = $notaFinal;
    }

}
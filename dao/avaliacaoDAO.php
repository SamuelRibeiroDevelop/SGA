<?php
/**
 * Created by PhpStorm.
 * User: aluno
 * Date: 16/03/2018
 * Time: 21:17
 */

require_once "db/conexao.php";
require_once "classes/avaliacao.php";

class avaliacaoDAO
{

    public function situacao($n1, $n2){
        $media = ($n1 + $n2 / 2);
        $media2 = ((($n1 + $n2) / 2) + $n1 + $n2) / 2;

        if ($media >= 7){
            return "Aprovado!";
        }elseif ($media < 4){
            return "Reprovado!";
        }elseif ($media2 >= 6)
        {
            return "Aprovado!";
        }
    }

    public function remover($ava)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM Avaliacao WHERE idAvaliacao = :id");
            $statement->bindValue(":id", $ava->getIdAvaliacao());
            if ($statement->execute()) {
                return "Registo foi excluído com êxito";
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function salvar($ava)
    {
        global $pdo;
        try {
            if ($ava->getIdAvaliacao() != "") {
                $statement = $pdo->prepare("UPDATE Avaliacao SET Curso_idCurso=:Curso_idCurso, Turma_idTurma=:Turma_idTurma, Aluno_idAluno=:Aluno_idAluno, Nota1=:Nota1, Nota2=:Nota2, NotaFinal=:NotaFinal WHERE idAvaliacao = :id;");
                $statement->bindValue(":id", $ava->getIdAvaliacao());
            } else {
                $statement = $pdo->prepare("INSERT INTO Avaliacao (Curso_idCurso, Turma_idTurma, Aluno_idAluno, Nota1, Nota2, NotaFinal) VALUES (:Curso_idCurso, :Turma_idTurma, :Aluno_idAluno, :Nota1, :Nota2, :NotaFinal)");
            }
            $statement->bindValue(":Curso_idCurso", $ava->getCurso());
            $statement->bindValue(":Turma_idTurma", $ava->getTurma());
            $statement->bindValue(":Aluno_idAluno", $ava->getAluno());
            $statement->bindValue(":Nota1", $ava->getNota1());
            $statement->bindValue(":Nota2", $ava->getNota2());
            $statement->bindValue(":NotaFinal", $ava->getNotaFinal());

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "<script> alert('Dados cadastrados com sucesso !'); </script>";
                } else {
                    return "<script> alert('Erro ao tentar efetivar cadastro !'); </script>";
                }
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function atualizar($ava)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT idAvaliacao, Curso_idCurso, Turma_idTurma, Aluno_idAluno, Nota1, Nota2, NotaFinal FROM Avaliacao WHERE idAvaliacao = :id");
            $statement->bindValue(":id", $ava->getIdAvaliacao());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $ava->setIdAvaliacao($rs->idAvaliacao);
                $ava->setCurso($rs->Curso);
                $ava->setTurma($rs->Turma);
                $ava->setAluno($rs->Aluno);
                $ava->setNota1($rs->Nota1);
                $ava->setNota2($rs->Nota2);
                $ava->setNotaFinal($rs->NotaFinal);
                return $ava;
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function tabelapaginada()
    {

        //carrega o banco
        global $pdo;

        //endereço atual da página
        $endereco = $_SERVER ['PHP_SELF'];

        /* Constantes de configuração */
        define('QTDE_REGISTROS', 10);
        define('RANGE_PAGINAS', 2);

        /* Recebe o número da página via parâmetro na URL */
        $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

        /* Calcula a linha inicial da consulta */
        $linha_inicial = ($pagina_atual - 1) * QTDE_REGISTROS;

        /* Instrução de consulta para paginação com MySQL */
        $sql = "SELECT A.idAvaliacao, A.Nota1, A.Nota2, A.NotaFinal, C.Sigla, T.idTurma, AL.Nome, AL.Matricula 
        FROM Avaliacao A INNER JOIN Curso C ON A.Curso_idCurso = C.idCurso INNER JOIN Turma T ON A.Turma_idTurma = T.idTurma 
        INNER JOIN Aluno AL ON A.Aluno_idAluno = AL.idAluno LIMIT {$linha_inicial}, " .QTDE_REGISTROS;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM Avaliacao";
        $statement = $pdo->prepare($sqlContador);
        $statement->execute();
        $valor = $statement->fetch(PDO::FETCH_OBJ);

        /* Idêntifica a primeira página */
        $primeira_pagina = 1;

        /* Cálcula qual será a última página */
        $ultima_pagina = ceil($valor->total_registros / QTDE_REGISTROS);

        /* Cálcula qual será a página anterior em relação a página atual em exibição */
        $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual - 1 : 0;

        /* Cálcula qual será a pŕoxima página em relação a página atual em exibição */
        $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual + 1 : 0;

        /* Cálcula qual será a página inicial do nosso range */
        $range_inicial = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1;

        /* Cálcula qual será a página final do nosso range */
        $range_final = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina;

        /* Verifica se vai exibir o botão "Primeiro" e "Pŕoximo" */
        $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder';

        /* Verifica se vai exibir o botão "Anterior" e "Último" */
        $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';

        if (!empty($dados)):
            echo "
     <table class='table table-striped table-bordered'>
     <thead>
       <tr class='active'>
        <th>Código</th>
        <th>Nota 1</th>
        <th>Nota 2</th>
        <th>Nota Final</th>
        <th>Curso</th>
        <th>Turma</th>
        <th>Nome Aluno</th>
        <th>Matrícula Aluno</th>
        <th colspan='2'>Ações</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $var):
                echo "<tr>
        <td>$var->idAvaliacao</td>
        <td>$var->Nota1</td>
        <td>$var->Nota2</td>
        <td>$var->NotaFinal</td>
        <td>$var->Sigla</td>
        <td>$var->idTurma</td>
        <td>$var->Nome</td>
        <td>$var->Matricula</td>
        <td><a href='?act=upd&id=$var->idAvaliacao'><i class='ti-reload'></i></a></td>
        <td><a href='?act=del&id=$var->idAvaliacao'><i class='ti-close'></i></a></td>
       </tr>";
            endforeach;
            echo "
</tbody>
     </table>

     <div class='box-paginacao'>
       <a class='box-navegacao  $exibir_botao_inicio' href='$endereco?page=$primeira_pagina' title='Primeira Página'>Primeira</a>
       <a class='box-navegacao $exibir_botao_inicio' href='$endereco?page=$pagina_anterior' title='Página Anterior'>Anterior</a>
";

            /* Loop para montar a páginação central com os números */
            for ($i = $range_inicial; $i <= $range_final; $i++):
                $destaque = ($i == $pagina_atual) ? 'destaque' : '';
                echo "<a class='box-numero $destaque' href='$endereco?page=$i'>$i</a>";
            endfor;

            echo "<a class='box-navegacao $exibir_botao_final' href='$endereco?page=$proxima_pagina' title='Próxima Página'>Próxima</a>
       <a class='box-navegacao $exibir_botao_final' href='$endereco?page=$ultima_pagina' title='Última Página'>Último</a>
     </div>";
        else:
            echo "<p class='bg-danger'>Nenhum registro foi encontrado!</p>
     ";
        endif;

    }


}
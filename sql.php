<?php

/*
*
* Alterações feitas entre os dias 19/02/16 à 01/03/2016 >>>
*/
1. tb_pls
    ALTER TABLE `tb_pls`
        ADD COLUMN `etapa_id` INT NULL AFTER `delete`,
        ADD COLUMN `subetapa_id` INT NULL AFTER `etapa_id`;


2. tb_fluxo_historico
    CREATE TABLE `arearestrita_dev`.`tb_fluxo_log_origem_pl` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `pl_id` INT NULL,
        `tipo_id` INT NULL,
        `pl_origem` VARCHAR(45) NULL,
        `numero_da_pl` VARCHAR(45) NULL,
        `ano` VARCHAR(4) NULL,
        `etapa_id` INT NULL,
        `subetapa_id` INT NULL,
        `autor` VARCHAR(300),
        `relator` VARCHAR(300),
        `status_name` VARCHAR(100),
        `foco` LONGTEXT NULL,
        `oque_e` LONGTEXT NULL,
        `nossa_posicao` LONGTEXT NULL,
        `justificativa` LONGTEXT NULL,
        `situacao` LONGTEXT NULL,
        `tarefa` LONGTEXT NULL,
        `nostas_tecnicas` LONGTEXT NULL,
        `created` DATETIME NULL,
        `modified` DATETIME NULL,
        PRIMARY KEY (`id`))
        ENGINE = MyISAM;


3. tb_fluxo_etapa
    CREATE TABLE `tb_fluxo_etapa` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `pl_type_id` INT NULL,
        `etapa` VARCHAR(150) NULL,
        `descricao` VARCHAR(150) NULL,
        `ordem` INT NULL DEFAULT 1,
        `created` DATETIME NULL,
        `modified` DATETIME NULL,
        PRIMARY KEY (`id`))
        ENGINE = MyISAM;



4. tb_fluxo_subetapa
    CREATE TABLE `tb_fluxo_subetapa` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `etapa_id` INT NULL,
        `subetapa` VARCHAR(150) NULL,
        `descricao` VARCHAR(150) NULL,
        `ordem` INT NULL DEFAULT 1,
        `created` DATETIME NULL,
        `modified` DATETIME NULL,
        PRIMARY KEY (`id`))
        ENGINE = MyISAM;


5. tb_log_atualizacao_pl
    ALTER TABLE `tb_log_atualizacao_pl`
        ADD COLUMN `fluxograma` TINYINT(1) NULL DEFAULT 0 AFTER `enviado_por_email`,
        ADD COLUMN `etapa_id` INT NULL AFTER `fluxograma`,
        ADD COLUMN `etapa` VARCHAR(100) NULL AFTER `etapa_id`,
        ADD COLUMN `etapa_descricao` VARCHAR(150) NULL AFTER `etapa`,
        ADD COLUMN `etapa_ordem` INT NULL AFTER `etapa_descricao`,
        ADD COLUMN ` fluxo_etapa_add` TINYINT(1) NULL DEFAULT 0 AFTER `etapa_ordem`,
        ADD COLUMN ` fluxo_etapa_edit` TINYINT(1) NULL DEFAULT 0 AFTER ` fluxo_etapa_add `,
        ADD COLUMN ` fluxo_etapa_delete` TINYINT(1) NULL DEFAULT 0 AFTER ` fluxo_etapa_edit `,
        ADD COLUMN `etapa_vinculada_pl` TINYINT(1) NULL DEFAULT 0 AFTER `fluxo_etapa_delete`,
        ADD COLUMN `subetapa_id` INT NULL AFTER `etapa_ordem`,
        ADD COLUMN `subetapa` VARCHAR(100) NULL AFTER `subetapa_id`,
        ADD COLUMN `subetapa_descricao` VARCHAR(150) NULL AFTER `subetapa`,
        ADD COLUMN `subetapa_ordem` INT NULL AFTER `subetapa_descricao`,
        ADD COLUMN ` fluxo_subetapa_add` TINYINT(1) NULL DEFAULT 0 AFTER `etapa_ descricao `,
        ADD COLUMN ` fluxo_subetapa_edit` TINYINT(1) NULL DEFAULT 0 AFTER ` fluxo_subetapa_add `,
        ADD COLUMN ` fluxo_subetapa_delete` TINYINT(1) NULL DEFAULT 0 AFTER ` fluxo_subetapa_edit`,
        ADD COLUMN `subetapa_vinculada_pl` TINYINT(1) NULL AFTER `fluxo_subetapa_add`;




ALTER TABLE `arearestrita_dev`.`tb_log_atualizacao_pl` 
        CHANGE COLUMN `id` `id` INT(11) NOT NULL ,
        ADD COLUMN `fluxograma` INT NULL AFTER `enviado_por_email`,
        ADD COLUMN `etapa_id` INT NULL AFTER `fluxograma`,
        ADD COLUMN `etapa` VARCHAR(100) NULL AFTER `etapa_id`,
        ADD COLUMN `etapa_descricao` VARCHAR(150) NULL AFTER `etapa`,
        ADD COLUMN `etapa_ordem` INT NULL AFTER `etapa_descricao`,
        ADD COLUMN `fluxo_etapa_add` TINYINT(1) NULL DEFAULT 0 AFTER `etapa_ordem`,
        ADD COLUMN `fluxo_etapa_edit` TINYINT(1) NULL DEFAULT 0 AFTER `fluxo_etapa_add`,
        ADD COLUMN `fluxo_etapa_delete` TINYINT(1) NULL DEFAULT 0 AFTER `fluxo_etapa_edit`,
        ADD COLUMN `etapa_vinculada_pl` TINYINT(1) NULL DEFAULT 0 AFTER `fluxo_etapa_delete`,
        ADD COLUMN `subetapa_id` INT NULL AFTER `etapa_vinculada_pl`,
        ADD COLUMN `subetapa` VARCHAR(100) NULL AFTER `subetapa_id`,
        ADD COLUMN `subetapa_descricao` VARCHAR(150) NULL AFTER `subetapa`,
        ADD COLUMN `subetapa_ordem` INT NULL AFTER `subetapa_descricao`,
        ADD COLUMN `fluxo_subetapa_add` TINYINT(1) NULL DEFAULT 0 AFTER `subetapa_ordem`,
        ADD COLUMN `fluxo_subetapa_edit` TINYINT(1) NULL DEFAULT 0 AFTER `fluxo_subetapa_add`,
        ADD COLUMN `fluxo_subetapa_delete` TINYINT(1) NULL DEFAULT 0 AFTER `fluxo_subetapa_edit`,
        ADD COLUMN `subetapa_vinculada_pl` TINYINT(1) NULL AFTER `fluxo_subetapa_delete`;


///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////

                                            SELECT


                                                    Pl.id,
                                                    PlType.tipo,
                                                    Pl.tipo_id,
                                                    Pl.numero_da_pl,
                                                    Pl.ano,
                                                    Pl.autor_id,
                                                    Pl.relator_id,
                                                    Pl.prioridade,
                                                    Pl.arquivo,
                                                    StatusType.status_name,
                                                    StatusType.id,
                                                    Tema.tema_name,
                                                    Foco.txt,
                                                    Foco.modified,
                                                    OqueE.txt,
                                                    OqueE.modified,
                                                    Situacao.txt,
                                                    Situacao.modified,
                                                    NossaPosicao.txt,
                                                    NossaPosicao.modified,
                                                    Autor.nome as autor,
                                                    Relator.nome as relator,
                                                    Justificativa.justificativa,
                                                    Justificativa.modified,
                                                    AcaoAbear.id,
                                                    AcaoAbear.titulo,
                                                    AcaoAbear.descricao,
                                                    AcaoAbear.entrega,
                                                    AcaoAbear.realizado,
                                                    AcaoAbear.enviado_por_email,
                                                    AcaoAbear.modified

                                                FROM

                                                    tb_pls as Pl
                                                    left join tb_tema as Tema on (Tema.id = Pl.tema_id )
                                                    left join tb_pl_types as PlType on (PlType.id = Pl.tipo_id )
                                                    left join tb_status_types as StatusType on (StatusType.id = Pl.status_type_id )
                                                    left join tb_foco as Foco on (Foco.pl_id = Pl.id )
                                                    left join tb_o_que_e as OqueE on (OqueE.pl_id = Pl.id )
                                                    left join tb_situacao as Situacao on (Situacao.pl_id = Pl.id )
                                                    left join tb_nossa_posicao as NossaPosicao on (NossaPosicao.pl_id = Pl.id )
                                                    left join tb_autor_relator as Autor on (Autor.id = Pl.autor_id )
                                                    left join tb_autor_relator as Relator on (Relator.id = Pl.relator_id )
                                                    left join tb_justificativas as Justificativa on (Justificativa.pl_id = Pl.id )
                                                    left join tb_tarefas as AcaoAbear on (AcaoAbear.pl_id = Pl.id AND AcaoAbear.delete = 0 AND AcaoAbear.ativo = 1)

                                                WHERE
                                                    Pl.delete = 0 AND Pl.autor_id = 10 AND Pl.relator_id = 10

                                                GROUP BY Pl.id
                                                ORDER BY Pl.id DESC

///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
*
* <<< Alterações feitas entre os dias 19/02/16 à 01/03/2016
*/

?>

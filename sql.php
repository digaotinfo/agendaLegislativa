<?php

/*
*
* Alterações feitas entre os dias 19/02/16 à 01/03/2016 >>>
*/
1. tb_pls
ALTER TABLE `tb_pls`
    ADD COLUMN `etapa_id` INT NULL AFTER `delete`,
    ADD COLUMN `subetapa_id` INT NULL AFTER `etapa_id`,
    ADD COLUMN `pl_origem` TINYINT(1) NULL AFTER `relator_bk`,
    ADD COLUMN `pl_origem_numero` VARCHAR(45) NULL AFTER `pl_origem`



2. tb_fluxo_historico
    CREATE TABLE `tb_fluxo_historico` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `pl_id` INT NULL,
        `pl_origem` VARCHAR(45) NULL,
        `tipo_id` INT NULL,
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
        `link_da_pl` VARCHAR(300),
        `apensados_da_pl` VARCHAR(300),
        `prioridade` TINYINT(1),
        `tema_name` VARCHAR(100),
        `status_type` VARCHAR(300),
        `etapa` VARCHAR(150),
        `subetapa` VARCHAR(150),
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
ALTER TABLE tb_log_atualizacao_pl`
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

6. tb_atualizacao_externa_pl
CREATE TABLE `tb_atualizacao_externa_pl` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `remetente` varchar(300) DEFAULT NULL,
    `assunto` varchar(300) DEFAULT NULL,
    `corpo` longtext,
    `lido` tinyint(1) DEFAULT '0',
    `created` datetime DEFAULT NULL,
    `modified` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=MyISAM
/*
*
* <<< Alterações feitas entre os dias 19/02/16 à 01/03/2016
*/

?>

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Imagem
 *
 * @author sam
 */
class Imagem {

    //put your code here

    /*
     * @description var $imagem recebe o nome da imagem
     */
    var $imagem;
    /*
     * @description var $formato recebe o formato da imagem
     */
    var $formato;

    /*
     * @description var $erro variavel que recebe as mensagens de erro
     */
    var $erro;

    public function ler($imagem = FALSE) {

        $infoImagem = getimagesize($imagem);
        $this->formato = $infoImagem[2];

        if ($this->formato) {
            switch ($this->formato) {

                case IMAGETYPE_JPEG: $this->imagem = imagecreatefromjpeg($imagem);
                    break;
                case IMAGETYPE_PNG : $this->imagem = imagecreatefrompng($imagem);
                    break;
                case IMAGETYPE_GIF : $this->imagem = imagecreatefromgif($imagem);
                    break;
                default : $this->erro = "Erro ao ler Imagem! Formato de imagem não suportado";
                    throw new Exception($this->erro);
                    break;
            }
        }
    }

    function guardar($caminho, $formato = IMAGETYPE_JPEG, $qualidade = 75, $permissao = NULL) {

        if ($formato) {
            switch ($formato) {

                case IMAGETYPE_JPEG: imagejpeg($this->imagem, $caminho, $qualidade);
                    move_uploaded_file($caminho, '/home/sam/imagens/');
                    break;
                case IMAGETYPE_PNG : imagepng($this->imagem, $caminho, $qualidade);
                    move_uploaded_file($_FILES['imagem']['tmp_name'], '/home/sam/imagens/');
                    break;
                case IMAGETYPE_GIF : imagegif($this->imagem, $caminho, $qualidade);
                    move_uploaded_file($_FILES['imagem']['tmp_name'], '/home/sam/imagens/');
                    break;
                default : $this->erro = "Erro ao guardar Imagem! Formato de imagem não suportado";
                    throw new Exception($this->erro);
                    break;
            }
        }

        if ($permissao != NULL) {
            chmod($caminho, $permissao);
        }
    }

    function saida($formato = IMAGETYPE_JPEG) {

        if ($formato) {
            switch ($formato) {

                case IMAGETYPE_JPEG: imagejpeg($this->imagem);
                    break;
                case IMAGETYPE_PNG : imagepng($this->imagem);
                    break;
                case IMAGETYPE_GIF : imagegif($this->imagem);
                    break;
                default : $this->erro = "Erro na saida da Imagem! Formato de imagem não suportado";
                    throw new Exception($this->erro);
                    break;
            }
        }
    }

    function getLargura() {
        return imagesx($this->imagem);
    }

    function getAltura() {
        return imagesy($this->imagem);
    }

    public function CalculaAltura($altura) {
        $f = $altura / $this->getAltura();
        $largura = $this->getLargura() * $f;
        $this->redimensionar($largura, $altura);
    }

    public function CalculaLargura($largura) {
        $f = $largura / $this->getLargura();
        $altura = $this->getAltura() * $f;
        $this->redimensionar($largura, $altura);
    }

    public function escala($valor) {
        $largura = $this->getLargura() * $valor / 100;
        $altura = $this->getAltura() * $valor / 100;
        $this->redimensionar($largura, $altura);
    }

    public function redimensionar($largura, $altura) {
        $nova_imagem = imagecreatetruecolor($largura, $altura);
        imagecopyresampled($nova_imagem, $this->imagem, 0, 0, 0, 0, $largura, $altura, $this->getLargura(), $this->getAltura());
        $this->imagem = $nova_imagem;
    }

    public function redimensionaTransparente($largura, $altura) {
        $nova_imagem = imagecreatetruecolor($largura, $altura);
        if ($this->formato == IMAGETYPE_JPEG || $this->formato == IMAGETYPE_PNG || $this->formato == IMAGETYPE_GIF) {
            $imagem_transparente = imagecolortransparent($this->imagem);

            if ($imagem_transparente != -1) {
                $cor_transparente = imagecolorsforindex($$this->imagem, $imagem_transparente);
                $imagem_transparente = imagecolorallocate($nova_imagem, $cor_transparente['red'], $cor_transparente['green'], $cor_transparente['blue']);
                imagefill($nova_imagem, 0, 0, $cor_transparente);
                imagecolortransparent($nova_imagem, $cor_transparente);
            } elseif ($this->image_type == IMAGETYPE_PNG) {

                imagealphablending($nova_imagem, FALSE);
                $cor = imagecolorallocatealpha($nova_imagem, 0, 0, 0, 127);
                imagefill($nova_imagem, 0, 0, $cor);
                imagesavealpha($nova_imagem, TRUE);
            }
        }
        imagecopyresampled($nova_imagem, $this->imagem, 0, 0, 0, 0, $largura, $altura, $this->getLargura(), $this->getAltura());
        $this->imagem = $nova_imagem;
    }

}

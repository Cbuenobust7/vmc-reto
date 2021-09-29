<?php

class Coordenadas {
    public $x;
    public $y;
    public $cardinal;
    
    public function getX()
    {
        return $this->x;
    }
    public function getY()
    {
        return $this->y;
    }
    public function getCardinal()
    {
        return $this->cardinal;
    }
}

$salto = false;


for ($z = 0; ; $z++) {


    $inicial = new Coordenadas();
    $inicial->x = 0;
    $inicial->y = 0;
    $inicial->cardinal = 'Norte';

    $inputstxt = glob('txt/*.txt', GLOB_BRACE);
    $outputstxt = glob('*.txt', GLOB_BRACE);

    $textfile = $inputstxt[$z];

        $lines = array();
        $fopen = fopen($textfile, 'r');
        while (!feof($fopen)) {
            $line=fgets($fopen);
            $line=trim($line);
            $lines[]=$line;

        }
        fclose($fopen);
        $outputdirectivas = array();
        foreach ($lines as $string)
        {
            $string = preg_replace('!\s+!', ' ', $string);
            $row = explode(" ", $string);
            array_push($outputdirectivas,$row);
        }

        $outfile="out";// 
        $i=1;
        $fn=$outfile.$i.'.txt';

        while(file_exists($fn)){
        $fn=$outfile.$i.'.txt';
        $i++;
        }


        $fh=fopen($fn,'w') or die("NO SE PUEDE CREAR ARCHIVO DE TEXTO");
        fwrite($fh,"== REPORTE DE ENTREGAS == \n\n") or die("NO TIENE PERMISOS PARA ESCRIBIR EN ARCHIVO");


        foreach ($outputdirectivas as $directivas) {

        echo "<pre>";
        print_r($outputdirectivas);
        echo "</pre>";


        foreach($directivas as $orden) {


            if(($inicial->cardinal == 'Norte' ) && ($orden == 'I') && ($salto == false)) 
            {
                $inicial->cardinal = 'Occidente';
                $salto = true;
            }
            if(($inicial->cardinal == 'Norte' ) && ($orden == 'D') && ($salto == false)) 
            {
                $inicial->cardinal = 'Oriente';
                $salto = true;
            }
            if(($inicial->cardinal == 'Norte' ) && ($orden == 'A'))
            {
                $inicial->y += 1;
            }


            if(($inicial->cardinal == 'Occidente' ) && ($orden == 'I') && ($salto == false)) 
            {
                $inicial->cardinal = 'Sur';
                $salto = true;
            }
            if(($inicial->cardinal == 'Occidente' ) && ($orden == 'D') && ($salto == false)) 
            {
                $inicial->cardinal = 'Norte';
                $salto = true;
            }
            if(($inicial->cardinal == 'Occidente' ) && ($orden == 'A'))
            {
                $inicial->x -= 1;
            }


            if(($inicial->cardinal == 'Sur' ) && ($orden == 'I') && ($salto == false)) 
            {
                $inicial->cardinal = 'Oriente';
                $salto = true;
            }
            if(($inicial->cardinal == 'Sur' ) && ($orden == 'D') && ($salto == false)) 
            {
                $inicial->cardinal = 'Occidente';
                $salto = true;
            } 
            if(($inicial->cardinal == 'Sur' ) && ($orden == 'A'))
            {
                $inicial->y -= 1;
            } 
        

            if(($inicial->cardinal == 'Oriente' ) && ($orden == 'I') && ($salto == false))
            {
                $inicial->cardinal = 'Norte';
                $salto = true;

            }
            if(($inicial->cardinal == 'Oriente' ) && ($orden == 'D') && ($salto == false))
            {
                $inicial->cardinal = 'Sur';
                $salto = true;

            } 
            if(($inicial->cardinal == 'Oriente' ) && ($orden == 'A'))
            {
                $inicial->x += 1;
        
        }
        $salto = false;

        }

        $texto = '(' . $inicial->getX() . ' , ' . $inicial->getY() . ') Orientación: ' . $inicial->getCardinal() . "\n" ;
        echo $texto;
        fwrite($fh,$texto) or die("NO TIENE PERMISOS PARA ESCRIBIR EN ARCHIVO");

        }
        fclose($fh);
        echo "ARCHIVO DE TEXTO GENERADO: ". $fn;


if ($z >= 19) { break;

    }

}


?>
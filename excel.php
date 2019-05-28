<?php
class Excel {
    private $fp=null;

    function __construct()
    {
        $this->fp = fopen('php://output', 'w');
    }

    function doldur($data=array()){
        //UTF-8  Excel
        fputs($this->fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        if ($this->fp)
        {
            foreach($data as $d)
            {
                if(!isset($isaret)) {
                    fputcsv($this->fp,array_keys($d), ";");
                    $isaret = true;
                }
                fputcsv($this->fp, $d, ";");
            }
        }
        fclose($this->fp);
    }

    function kaydet($dosya){
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Description: File Transfer');
        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename=$dosya.csv;");
        header('Content-Transfer-Encoding: binary');
    }
}
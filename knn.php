<?php

/**
    KNN FOR PHP
    by Bruno Vais
 */

/**********************************************************************************
 *   this algorithm calculates the KNN based on the euclidean distance.           *
************************************************************************************/

Class KNN {
    
    private $file;
    private $classes;
    private $elements;
    private $dataSet;
    private $k;
    private $newArtifect;
    private $caracteristicas;
    private $distances;
    private $classificado;

    public function __construct(string $datasetPath){
        try{
            $this->file = json_decode(file_get_contents($datasetPath));
        }catch(Exception $e){
            die($e);
        }
        $this->setData();
        
    }

    private function setData(){
        $x = 0;
        foreach ($this->file as $key => &$value) {
            $this->elements[$key] = $key;
            $this->classes[$x] = $value->class;
            $this->setCaracteristicas($value);
            $x++;
        }
        $this->classes = array_unique($this->classes);
        $this->dataSet = $this->file; 
    }

    public function setK(int $k){
        $this->k = $k;
    }

    public function setNewArtifect($arg){
        $this->checkCompatibilityArgDataSet($arg);
        $this->newArtifect = $arg;
    }

    private function setCaracteristicas($data){
        $x = 0;
        foreach ($data as $key => $value){
            $this->caracteristicas[$x] = $key;
            $x++;
        }
    }

    private function checkCompatibilityArgDataSet($arg){
        $flag = false;
        foreach ($this->caracteristicas as $key => $value) {
            if(!array_key_exists($value, $arg)){
                if($value != 'class'){
                    $flag = true;
                }
            }
        }
        if($flag){
            die("caracteristicas do artefato não condizem com o dataset!");
        }
    }

    public function exec(){
        $this->calcDistanciaEuclidiana();
        asort($this->distances);
        return $this->classify();
    }
    // sqrt((x²i-x¹i)**2 + (x²n - x¹n)**2)
    private function calcDistanciaEuclidiana(){
        foreach ($this->dataSet as $key => $value) {
            $accumulator = 0;
            $x = $key;
            foreach ($value as $key => $char) {
                if(array_key_exists($key, $this->newArtifect)){
                    $euclides[$key] = (((float)$char - (float)$this->newArtifect[$key]) ** 2);
                }
            }
            foreach ($euclides as $key => $value) {
                $accumulator += $value; 
            }
            $this->distances[$x] = sqrt($accumulator);  
        }
    }

    private function classify(){
        $neighbors = [];
        $x = 0;
        foreach ($this->distances as $key => $value) {
            if($x < $this->k){
                $neighbors[$key] = $this->dataSet->$key->class;
                $x++;
            }
        }
        for ($i=0; $i < count($this->classes); $i++) { 
            $qtd[$i] = 0;
            foreach ($neighbors as $key => $value){
                if($value == $this->classes[$i]){
                    $qtd[$i]++; 
                }
            }
        }
        $key = array_search(max($qtd), $qtd);
        return $this->classes[$key];
    }
}
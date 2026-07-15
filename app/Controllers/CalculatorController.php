<?php
// app/Controllers/CalculatorController.php

class CalculatorController {
    
    public function somar($a, $b) {
        // Valida se os valores são realmente numéricos
        if (!is_numeric($a) || !is_numeric($b)) {
            throw new InvalidArgumentException("Os valores fornecidos devem ser números válidos.");
        }
        
        return $a + $b;
    }

    public function subtrair($a, $b) {
        if(!is_numeric($a) || !is_numeric($b)){
            throw new InvalidArgumentException("Os valores fornecidos devem ser números válidos.");
        }
        return $a - $b;
    }
        //Outras operações

}

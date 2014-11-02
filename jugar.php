<?php
    session_start();
    
    include './BarajaNaipes.php';
    $partida=array();
    
   
    if (!isset($_SESSION['partida'])) {
        $partida['tablero']=array('corazones'=>array(),'picas'=>array(),'treboles'=>array(),'diamantes'=>array());
        $partida['turno']=0;
        $partida['ronda']=0;
        if (isset($_GET['ID']))$partida['num_jug']= $_GET['ID'];
        else $partida['num_jug']=4;
        $baraja_partida=$baraja;
        barajar($baraja_partida);
        repartir($baraja_partida, $partida);
        
//        for ($x=0; $x<$partida['num_jug']; $x++) {
//            $partida[$x]= ordenar($partida[$x]);
//        }
        $_SESSION['partida']=$partida;
    }
     else {
        $partida=$_SESSION['partida'];
    }
    
    if (isset($_GET['turno'])){
            $partida['carta']='';
            if ($partida['turno']<($partida['num_jug']-1)) $partida['turno']++;
            else {
                $partida['turno']=0;
                $partida['ronda']++;
            }
            $_SESSION['partida']=$partida;
    }
    
    if (isset($_GET['palo']) && isset($_GET['numero'])){
        $carta=array('palo'=>$_GET['palo'],'numero'=>$_GET['numero']);
//        print_r($partida);
        lanzar($partida, $carta);
    }
    
    mostrarbaraja($partida);

    function repartir ($baraja,&$partida) {
        $num_jug=$partida['num_jug'];
        $mano=52/$num_jug;
        $resto=52%$num_jug;
        
        for ($x=0; $x<$num_jug; $x++) {
//            $partida[$x]=  array_slice($baraja, $mano*$x, $mano);
            $partida[$x]=  array_splice($baraja, 0, $mano);
        }
        
        if ($resto!=0){
            for ($y=0, $z=0; $resto!=0; $z++,$resto--){
//                array_push($partida[$y],array_slice($baraja,$mano*$num_jug-1+$z,1));
                $partida[$y][count($partida[$y])]=$baraja[$z];
                if ($y>($num_jug-1)) $y=0;
                else $y++;
            }
        }
        
    }
    
    function lanzar (&$partida, $carta) {
        $jugador=$partida['turno'];
        if ($carta['numero']==5){
            array_push ($partida['tablero'][$carta['palo']], $carta);
            for ($x=0; $x<count($partida[$jugador]); $x++) {
                                if (($partida[$jugador][$x]['numero']==$carta['numero'])&&
                                    ($partida[$jugador][$x]['palo']==$carta['palo'])){
                                    unset ($partida[$jugador][$x]);
                                    $partida[$jugador] = array_values($partida[$jugador]);
                                    break;
                                    }
                            }
//            pasaTurno();
            $partida['carta']='';
            if ($partida['turno']<($partida['num_jug']-1)) $partida['turno']++;
            else {
                $partida['turno']=0;
                $partida['ronda']++;
            }
            
        }
        else {
            
            $palo=$carta['palo'];

            if (!empty($partida['tablero'][$palo])){
                $cartas_mesa1=$partida['tablero'][$palo];
                $cartas_mesa2=$partida['tablero'][$palo];
                $primera=array_shift($cartas_mesa1);
                $ultima=array_pop($cartas_mesa2);
//                print_r($primera);
//                print_r($ultima);

                if (($carta['numero'])==$primera['numero']-1) {
                    //Agrego elemento al final
                    array_unshift ($partida['tablero'][$palo], $carta);
                    //Eliminar elemento de mano del jugador ¿????
                    for ($x=0; $x<count($partida[$jugador]); $x++) {
                        if (($partida[$jugador][$x]['numero']==$carta['numero'])&&
                            ($partida[$jugador][$x]['palo']==$carta['palo'])){
                            unset ($partida[$jugador][$x]);
                            $partida[$jugador] = array_values($partida[$jugador]);
                            break;
                            }
                        }
                    
//                    pasaTurno();
                    $partida['carta']='';
                    if ($partida['turno']<($partida['num_jug']-1)) $partida['turno']++;
                    else {
                        $partida['turno']=0;
                        $partida['ronda']++;
                    }
                }
                elseif (($carta['numero'])==$ultima['numero']+1) {

                    //Agrego elemento al principio
                    array_push ($partida['tablero'][$palo], $carta);
                    //Eliminar elemento de mano del jugador ¿????
                    for ($x=0; $x<count($partida[$jugador]); $x++) {
                        if (($partida[$jugador][$x]['numero']==$carta['numero'])&&
                            ($partida[$jugador][$x]['palo']==$carta['palo'])) {
                            unset ($partida[$jugador][$x]);
                            $partida[$jugador] = array_values($partida[$jugador]);
                            break;
                            }
                    }
//                    pasaTurno();
                    $partida['carta']='';
                    if ($partida['turno']<($partida['num_jug']-1)) 
                        $partida['turno']++;
                    else {
                        $partida['turno']=0;
                        $partida['ronda']++;
                    }
               }
        
            }
        }
        $_SESSION['partida']=$partida;
//        print_r($partida['tablero']);

}   
//        function pasaTurno() {
//            $partida['carta']='';
//            if ($partida['turno']<($partida['num_jug']-1)) $partida['turno']++;
//            else $partida['turno']=0;
//        }
    
?>

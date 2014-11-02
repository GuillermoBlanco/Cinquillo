<html>
    <body>
            <?php
            $baraja = array();
            $palos = array('corazones','picas','treboles','diamantes');
            $numeros=array(1,2,3,4,5,6,7,8,9,10,11,12,13);

            function crearBaraja($baraja,$palos,$numeros) {
               
                foreach ($palos as $palo) {
                    foreach ($numeros as $numero){
                        $carta=array('palo'=>$palo,'numero'=>$numero);                        
                        array_push($baraja, $carta);

                    }
                }

                return $baraja;
            }

            function mostrarbaraja ($partida){
                echo '<h1 style="font-size:3em; margin-bottom:-20px">Cinquillo </h1>';
                echo '<div style="float:left">';
                echo '<h1 style="color:red">Turno jugador: '.($partida['turno']+1).'</h1>';
                echo '<h2 style="">Ronda: '.($partida['ronda']+1).'</h1>';
                echo '<h1>Mesa</h1>';
                foreach ($partida['tablero'] as $palo) {
                      foreach ($palo as $carta) {
                      echo '<img src="naipes/'.$carta['palo'].'-'.$carta['numero'].'.gif"'.' WIDTH="40" HEIGHT="64">';
                      
                      }
                      echo '</br>';
                }
                echo '</div>';
                echo '<div style="float:right; padding-top:50px">';
                for ($x=0; $x<$partida['num_jug']; $x++)
                {
                    echo '<h2 style="text-align:right">Jugador '.($x+1).' </h2>';
                    
                        if ($partida['turno']==$x) {
                        echo '<div><a href="jugar.php?turno=pasa"><img src="images/pasa.png" WIDTH="40" HEIGHT="40"></a></div>';
                        foreach ($partida[$x] as $carta){
                            echo '<a href="jugar.php?palo='.$carta['palo'].'&numero='.$carta['numero'].'"><img src="naipes/'.$carta['palo'].'-'.$carta['numero'].'.gif"'.' WIDTH="40" HEIGHT="64"></a>';
                            } 
                        }
                        else{
                            foreach ($partida[$x] as $carta){
                                echo '<img src="naipes/'.$carta['palo'].'-'.$carta['numero'].'.gif"'.' WIDTH="40" HEIGHT="64">';
                            }        
                        }
                    echo '</br>';
                }
                echo '</div>';
            }
            
            function barajar (&$baraja) {
                shuffle($baraja);
            }
            
            function ordenar ($baraja) {
                $corazones=array();
                $picas=array();
                $treboles=array();
                $diamantes=array();
                
                foreach ($baraja as $carta) {
                    switch ($carta['palo']){
                        case 'corazones':
                            array_push($corazones, $carta);
                            break;
                        case 'picas':
                            array_push($picas, $carta);
                            break;
                        case 'treboles':
                            array_push($treboles, $carta);
                            break;
                        case 'diamantes':
                            array_push($diamantes, $carta);
                            break;

                        default:
                            break;
                    }
                }
//                array_multisort($corazones);
//                array_multisort($diamantes);
//                array_multisort($picas);
//                array_multisort($treboles);
                
                
                usort($corazones,"cmp");
                usort($diamantes,"cmp");
                usort($picas,"cmp");
                usort($treboles,"cmp");

                return array_merge ($corazones,$diamantes,$picas,$treboles);
            }
            
            function cmp($a, $b)
                {
                    return strcmp($a['numero'], $b['numero']);
                }
                
            $baraja=crearBaraja($baraja,$palos,$numeros);
//            barajar($baraja);
//            mostrarbaraja($baraja);
//            mostrarbaraja(ordenar($baraja));
            

            ?>
    </body>
</html>
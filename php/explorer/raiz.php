<?php
session_start();
if ($_SESSION['ultimaAccion']['localoftp'] == "local") {
    unset($_SESSION['localurl']);
} else {
    unset($_SESSION['cloudurl'][$_SESSION['ultimaAccion']['idftp']]); 
}   
